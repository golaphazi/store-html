<?php
/**
 * @author Jegtheme
 */

namespace EPIC\Module;

use EPIC\Module\Block\BlockViewAbstract;

Class ModuleManager {
	private static $instance;

	private $width = array();

	private $module = array();

	private $overlay_slider = false;

	private $module_count = 0;

	private $unique_article = array();

	private $module_array = array();

	public static $module_ajax_prefix = 'epic_module_ajax_';

	/**
	 * @return ModuleManager
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
		if ( ( isset( $_GET['vc_editable'] ) && $_GET['vc_editable'] ) ||
		     ( isset( $_GET['vc_action'] ) && $_GET['vc_action'] === 'vc_inline' ) ) {
			$this->load_all_module_option();
			$this->do_shortcode();
		} else if ( is_admin() ) {
			$this->load_all_module_option();
		} else {
			$this->do_shortcode();
		}

		$this->setup_hook();
	}


	public function module_ajax( $module_name ) {
		$class_name = epic_get_view_class_from_shortcode( $module_name );

		/** @var ModuleViewAbstract $instance */
		$instance = call_user_func( array( $class_name, 'getInstance' ) );

		if ( $instance instanceof BlockViewAbstract ) {
			$instance->ajax_request();
		}
	}

	public function setup_hook() {
		add_filter( 'epic_module_block_container_extend_after', array( $this, 'module_container_after' ), null, 2 );
		add_filter( 'epic_module_block_navigation_extend_before', array( $this, 'module_navigation_before' ), null, 2 );
		add_filter( 'the_content', array( $this, 'move_slider' ), 1 );

		add_filter( 'pre_do_shortcode_tag', array( $this, 'register_column_width' ), null, 3 );
		add_filter( 'do_shortcode_tag', array( $this, 'reset_column_width' ), null, 2 );
		add_action( 'epic_module_set_width', array( &$this, 'force_set_width' ) );
	}

	public function is_overlay_slider_rendered() {
		return $this->overlay_slider;
	}

	public function overlay_slider_rendered() {
		$this->overlay_slider = true;
	}

	public function move_slider( $content ) {
		if ( function_exists( 'vc_is_page_editable' ) && is_page() && ! vc_is_page_editable() ) {
			$slider = null;
			$first  = strpos( $content, '[epic_slider_overlay' );

			if ( $first ) {
				$second = strpos( $content, ']', $first );
				$slider = substr( $content, $first, $second - $first + 1 );
			}

			return $slider . $content;
		}

		return $content;
	}

	public function module_loader() {
		$loader = epic_get_option( "module_loader", "dot" );
		$output =
			"<div class='module-overlay'>
                <div class='preloader_type preloader_{$loader}'>
                    <div class=\"module-preloader jeg_preloader dot\">
                        <span></span><span></span><span></span>
                    </div>
                    <div class=\"module-preloader jeg_preloader circle\">
                        <div class=\"epic_preloader_circle_outer\">
                            <div class=\"epic_preloader_circle_inner\"></div>
                        </div>
                    </div>
                    <div class=\"module-preloader jeg_preloader square\">
                        <div class=\"jeg_square\"><div class=\"jeg_square_inner\"></div></div>
                    </div>
                </div>
            </div>";

		return $output;
	}

	public function module_container_after( $content, $attr ) {
		$output  = $this->module_loader();
		$content = $content . $output;

		return $content;
	}

	public function module_navigation_before( $content, $attr ) {
		$output  = "<div class='navigation_overlay'><div class='module-preloader jeg_preloader'><span></span><span></span><span></span></div></div>";
		$content = $content . $output;

		return $content;
	}

	public function populate_module() {
		if ( empty( $this->module_array ) ) {
			$this->module_array = include "modules.php";
		}

		return apply_filters( 'epic_module_list', $this->module_array );
	}

	public function load_all_module_option() {
		$modules = $this->populate_module();

		// Need to load module first
		do_action( 'epic_load_all_module_option' );

		foreach ( $modules as $module ) {
			$mod                  = epic_get_option_class_from_shortcode( $module['name'] );
			$this->module[ $mod ] = call_user_func( array( $mod, 'getInstance' ) );
		}
	}

	public function get_all_module_option() {
		$this->load_all_module_option();

		return $this->module;
	}

	public function do_shortcode() {
		$self    = $this;
		$modules = $this->populate_module();

		foreach ( $modules as $module ) {
			$shortcode = strtolower( $module['name'] );

			add_shortcode( $shortcode, function ( $attr, $content ) use ( $self, $module ) {
				$mod = epic_get_view_class_from_shortcode( $module['name'] );

				// Call shortcode from plugin
				do_action( 'epic_build_shortcode_' . strtolower( $mod ) );

				/** @var ModuleViewAbstract $instance */
				$instance = call_user_func( array( $mod, 'getInstance' ) );

				if ( $instance instanceof ModuleViewAbstract ) {
					return $instance->build_module( $attr, $content );
				} else {
					return null;
				}
			} );
		}
	}

	public function calculate_width( $width ) {
		preg_match( '/(\d+)\/(\d+)/', $width, $matches );

		if ( ! empty( $matches ) ) {
			$part_x = (int) $matches[1];
			$part_y = (int) $matches[2];
			if ( $part_x > 0 && $part_y > 0 ) {
				$value = ceil( $part_x / $part_y * 12 );
				if ( $value > 0 && $value <= 12 ) {
					$width = $value;
				}
			}
		}

		return $width;
	}

	public function register_column_width( $flag, $tag, $attr ) {
		if ( $tag === 'vc_column' || $tag === 'vc_column_inner' ) {
			$width = isset( $attr['width'] ) ? $attr['width'] : '1/1';
			$width = $this->calculate_width( $width );
			array_push( $this->width, $width );
		}

		return $flag;
	}

	public function reset_column_width( $output, $tag ) {
		if ( $tag === 'vc_column' || $tag === 'vc_column_inner' ) {
			array_pop( $this->width );
		}

		return $output;
	}

	public function get_current_width() {
		if ( ! empty( $this->width ) ) {
			$current_width = 12;

			foreach ( $this->width as $width ) {
				$current_width = $width / 12 * $current_width;
			}

			return ceil( $current_width );
		} else {
			// Default Width
			if ( isset( $_REQUEST['colwidth'] ) ) {
				return $_REQUEST['colwidth'];
			} else if ( $this->is_widget_customizer() ) {
				return 4;
			} else {
				return 8;
			}
		}
	}

	public function is_widget_customizer() {
		if ( isset( $_REQUEST['customized'] ) ) {
			if ( strpos( $_REQUEST['customized'], 'widget_epic_module' ) !== false ) {
				return true;
			}
		}

		return false;
	}

	public function set_width( $width ) {
		$this->width = $width;
	}

	public function force_set_width( $width ) {
		$this->set_width( array( $width ) );
	}

	public function normalize_width() {
		$this->width = array();
	}

	public function get_column_class() {
		$class_name = 'jeg_col_1o3';
		$width      = $this->get_current_width();

		if ( $width < 6 ) {
			$class_name = "jeg_col_1o3";
		} else if ( $width >= 6 && $width <= 8 ) {
			$class_name = "jeg_col_2o3";
		} else if ( $width > 8 && $width <= 12 ) {
			$class_name = "jeg_col_3o3";
		}

		return $class_name;
	}

	public function increase_module_count() {
		$this->module_count ++;
	}

	public function get_module_count() {
		return $this->module_count;
	}

	public function add_unique_article( $group, $unique ) {
		if ( ! isset( $this->unique_article[ $group ] ) ) {
			$this->unique_article[ $group ] = array();
		}

		if ( is_array( $unique ) ) {
			$this->unique_article[ $group ] = array_merge( $this->unique_article[ $group ], $unique );
		} else {
			array_push( $this->unique_article[ $group ], $unique );
		}
	}

	public function get_unique_article( $group ) {
		if ( isset( $this->unique_article[ $group ] ) ) {
			return $this->unique_article[ $group ];
		} else {
			return array();
		}
	}
}
