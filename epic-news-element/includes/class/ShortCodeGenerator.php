<?php
/**
 * @author : Jegtheme
 */

namespace EPIC;

class ShortCodeGenerator {

	/**
	 * Instance of ShortCodeGenerator
	 *
	 * @var ShortCodeGenerator
	 */
	private static $instance;

	/**
	 * Singleton Pattern for ShortCodeGenerator Generator
	 *
	 * @return ShortCodeGenerator
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * ShortCodeGenerator constructor.
	 */
	private function __construct() {
		$this->load_hook();
	}

	/**
	 * Load All hook for this shortcode generator
	 */
	public function load_hook() {
		add_action( 'current_screen', array( $this, 'shortcode_button' ) );
	}

	/**
	 * Shortcode generator button hook
	 */
	public function shortcode_button() {
		$screen = get_current_screen();
		if ( ( $screen->post_type === 'post' || $screen->post_type === 'page' ) && $screen->post_type !== '' ) {
			if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) == 'true' ) {
				add_filter( 'mce_external_plugins', array( $this, 'add_tinymce_plugin' ) );
				add_filter( 'mce_buttons', array( $this, 'register_button' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
				add_action( 'admin_footer', array( $this, 'template_script' ) );
			}
		}
	}

	/**
	 * Add Javascript for Tiny MCE
	 *
	 * @param array $plugin_array Javascript going to enqueue on frontend
	 *
	 * @return mixed
	 */
	public function add_tinymce_plugin( $plugin_array ) {
		$plugin_array['epic-shortcode'] = EPIC_URL . '/assets/js/admin/shortcode.js';

		return $plugin_array;
	}

	/**
	 * Register Shortcode Generator Button
	 *
	 * @param array $buttons Array of button in Shortcode Generator
	 *
	 * @return array
	 */
	public function register_button( $buttons ) {
		array_push( $buttons, 'epic-shortcode-generator' );

		return $buttons;
	}

	/**
	 * Get registered element
	 *
	 * @return array
	 */
	public function get_registered_element() {
		$elements = apply_filters( 'epic_shortcode_elements', array() );

		return $elements;
	}

	/**
	 * Enqueue script
	 */
	public function enqueue_script() {
		wp_enqueue_style( 'epic-shortcode-style', EPIC_URL . '/assets/css/admin/shortcode-builder.css', null, jeg_get_version() );

		wp_enqueue_script( 'epic-shortcode-generator', EPIC_URL . '/assets/js/admin/shortcode-generator.js', array(
			'underscore',
			'wp-util',
			'customize-base',
			'jquery-ui-draggable',
		), EPIC_VERSION, true );

		wp_localize_script( 'epic-shortcode-generator', 'epic', array(
			'nonce'    => wp_create_nonce( 'epic' ),
			'elements' => $this->get_registered_element(),
			'title'    => esc_html__( 'Epic Shortcode Generator', 'epic' ),
			'close'    => esc_html__( 'Close', 'epic' ),
			'generate' => esc_html__( 'Generate', 'epic' ),
		) );
	}

	public function get_default_group() {
		return esc_html__( 'General', 'epic-ne' );
	}

	/**
	 * Convert Type
	 *
	 * @param $type
	 *
	 * @return string
	 */
	public function convert_type( $type ) {
		if ( $type === 'textfield' ) {
			return 'text';
		}

		if ( $type === 'colorpicker' ) {
			return 'color';
		}

		if ( $type === 'dropdown' ) {
			return 'select';
		}

		if ( $type === 'textarea_html' ) {
			return 'textarea';
		}

		if ( $type === 'attach_image' ) {
			return 'image';
		}

		return $type;
	}

	public function prepare_segments( $options ) {
		$segments = array();
		$priority = 1;

		foreach ( $options as $option ) {
			if ( ! isset( $option['group'] ) || empty( $option['group'] ) ) {
				$option['group'] = $this->get_default_group();
			}

			$id = sanitize_title_with_dashes( $option['group'] );

			if ( ! isset( $segments[ $id ] ) ) {
				$segments[ $id ] = array(
					'id'       => $id,
					'type'     => 'widget',
					'name'     => $option['group'],
					'priority' => $priority ++,
				);
			}
		}

		return $segments;
	}


	/**
	 * Prepare option to be loaded on Widget
	 *
	 * @param array $instance
	 * @param array $fields
	 *
	 * @return mixed
	 */
	public function prepare_fields( $instance, $fields ) {
		$setting = array();

		foreach ( $fields as $key => $field ) {
			if ( $field['param_name'] === 'compatible_column_notice' ) {
				continue;
			}

			$setting[ $key ]              = array();
			$setting[ $key ]['id']        = $field['param_name'];
			$setting[ $key ]['fieldID']   = $field['param_name'];
			$setting[ $key ]['fieldName'] = $field['param_name'];
			$setting[ $key ]['type']      = $this->convert_type( $field['type'] );

			$setting[ $key ]['title']       = isset( $field['heading'] ) ? $field['heading'] : '';
			$setting[ $key ]['description'] = isset( $field['description'] ) ? $field['description'] : '';
			$setting[ $key ]['segment']     = isset( $field['group'] ) ? sanitize_title_with_dashes( $field['group'] ) : sanitize_title_with_dashes( $this->get_default_group() );
			$setting[ $key ]['default']     = isset( $field['std'] ) ? $field['std'] : '';
			$setting[ $key ]['priority']    = isset( $field['priority'] ) ? $field['priority'] : 10;
			$setting[ $key ]['options']     = isset( $field['value'] ) ? array_flip( $field['value'] ) : array();

			if ( $field['type'] === 'slider' || $field['type'] === 'number' ) {
				$setting[ $key ]['options'] = array(
					'min'  => $field['min'],
					'max'  => $field['max'],
					'step' => $field['step'],
				);
			}

			if ( 'select' === $field['type'] ) {
				if ( isset( $field['value'] ) ) {
					$setting[ $key ]['options'] = array_flip( $field['value'] );
				}
				if ( isset( $field['options'] ) ) {
					$value                      = isset( $instance[ $field['param_name'] ] ) ? $instance[ $field['param_name'] ] : null;
					$setting[ $key ]['options'] = call_user_func_array( $field['options'], array( $value ) );
				}
			}

			if ( isset( $field['dependency'] ) ) {
				if ( is_array( $field['dependency'] ) ) {
					$setting[ $key ]['dependency'] = array(
						array(
							'field'    => $field['dependency']['element'],
							'operator' => 'in',
							'value'    => $field['dependency']['value']
						)
					);
				}

				if ( 'true' === $field['dependency']['value'] || 'false' === $field['dependency']['value'] ) {
					$setting[ $key ]['dependency'] = array(
						array(
							'field'    => $field['dependency']['element'],
							'operator' => '==',
							'value'    => $field['dependency']['value'] ? true : false,
						)
					);
				}
			}

			$setting[ $key ]['multiple']  = isset( $field['multiple'] ) ? $field['multiple'] : 1;
			$setting[ $key ]['ajax']      = isset( $field['ajax'] ) ? $field['ajax'] : '';
			$setting[ $key ]['nonce']     = isset( $field['nonce'] ) ? $field['nonce'] : '';
			$setting[ $key ]['value']     = $this->get_value( $field['param_name'], $instance, $setting[ $key ]['default'] );
			$setting[ $key ]['fields']    = isset( $field['fields'] ) ? $field['fields'] : array();
			$setting[ $key ]['row_label'] = isset( $field['row_label'] ) ? $field['row_label'] : array();


			// only for image type
			if ( 'image' === $setting[ $key ]['type'] ) {
				$image = wp_get_attachment_image_src( $setting[ $key ]['value'], 'full' );
				if ( isset( $image[0] ) ) {
					$setting[ $key ]['imageUrl'] = $image[0];
				}
			}
		}

		return $setting;
	}

	/**
	 * Get menu default value
	 *
	 * @param string $id Key of field option.
	 * @param array $value Array of value.
	 * @param mixed $default Default value for this item.
	 *
	 * @return mixed
	 */
	public function get_value( $id, $value, $default ) {
		if ( isset( $value[ $id ] ) ) {
			return $value[ $id ];
		} else {
			return $default;
		}
	}

	/**
	 * Script template for shortcode generator
	 */
	public function template_script() {
		?>
		<div class="shortcode-popup-list-wrapper shortcode-tab" id="shortcode-popup-list-wrapper"></div>
		<div class="shortcode-option-wrapper shortcode-tab" id="shortcode-option-wrapper"></div>
		<script type="text/html" id="tmpl-shortcode-popup">
			<div class="popup-shortcode-list">
				<div class="popup-header">
					<h2>{{ data.header }}</h2>
					<span class="close">
						<i class="fa fa-close"></i>
					</span>
				</div>
				<div class="popup-body">
					<ul class="tabbed-list"></ul>
					<div class="tabbed-body popup-content"></div>
				</div>
			</div>
		</script>
		<script type="text/html" id="tmpl-shortcode-category-list">
			<# var active = ( data.index === 0 ) ? 'active' : ''; #>
			<li href="#{{ data.id }}" class="{{ active }}"><span>{{ data.text }}</span></li>
		</script>
		<script type="text/html" id="tmpl-shortcode-category">
			<# var active = ( data.index === 0 ) ? 'active' : ''; #>
			<div class="jeg_tabbed_body {{ data.id }} {{ active }}" id="{{ data.id }}">
				<div class="jeg_metabox_body"></div>
			</div>
		</script>
		<script type="text/html" id="tmpl-shortcode-item">
			<div class="element">
				<div class="element-wrapper">
					<i class="{{ data.id }}"></i>
				</div>
				<span>{{ data.name }}</span>
			</div>
		</script>
		<script type="text/html" id="tmpl-shortcode-option">
			<div class="popup-shortcode-option">
				<div class="popup-header">
					<h2>{{ data.header }}</h2>
					<span class="close">
						<i class="fa fa-close"></i>
					</span>
				</div>
				<div class="popup-body">
					<ul class="tabbed-list"></ul>
					<div class="tabbed-body popup-content"></div>
				</div>
				<div class="popup-footer">
					<div class="close">{{ data.close }}</div>
					<div class="generate">{{ data.generate }}</div>
				</div>
			</div>
		</script>
		<?php
	}
}