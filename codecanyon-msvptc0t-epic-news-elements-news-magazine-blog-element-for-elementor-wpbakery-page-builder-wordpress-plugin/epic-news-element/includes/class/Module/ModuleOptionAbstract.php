<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module;

use EPIC\ShortCodeGenerator;

abstract Class ModuleOptionAbstract {
	protected static $instance;

	protected $options = array();

	public static function getInstance() {
		$class = get_called_class();

		if ( ! isset( self::$instance[ $class ] ) ) {
			self::$instance[ $class ] = new $class();
		}

		return self::$instance[ $class ];
	}

	protected function __construct() {
		$this->setup_hook();
	}

	public function get_options() {
		if ( empty( $this->options ) ) {
			$this->set_options();
		}

		return $this->options;
	}

	public function setup_hook() {
		$shortcode = epic_get_shortcode_name_from_option( get_class( $this ) );
		add_action( 'init', array( $this, 'map_vc' ) );
		add_filter( 'epic_shortcode_elements', array( $this, 'register_shortcode' ) );
		add_action( 'wp_ajax_' . $shortcode, array( $this, 'get_ajax_option' ) );
	}

	public function get_ajax_option() {
		$options  = $this->get_options();
		$segments = ShortCodeGenerator::getInstance()->prepare_segments( $options );
		$fields   = ShortCodeGenerator::getInstance()->prepare_fields( array(), $options );

		wp_send_json_success( array(
			'segments' => $segments,
			'fields'   => $fields,
		) );
	}

	public function remove_description() {
		$options = array();

		foreach ( $this->options as $key => $option ) {
			unset( $option['description'] );
			$options[] = $option;
		}

		return $options;
	}

	public function register_shortcode( $elements ) {
		$id                  = epic_get_shortcode_name_from_option( get_class( $this ) );
		$element             = array();
		$element['name']     = $this->get_module_name();
		$element['category'] = $this->get_category();

		$elements[ $id ] = $element;

		return $elements;
	}

	public function map_vc() {
		if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
			$this->set_options();
			$this->show_compatible_column();

			$vc_options['base']        = epic_get_shortcode_name_from_option( get_class( $this ) );
			$vc_options['params']      = $this->options;
			$vc_options['name']        = $this->get_module_name();
			$vc_options['category']    = $this->get_category();
			$vc_options['icon']        = strtolower( $vc_options['base'] );
			$vc_options['description'] = $this->get_module_name();
			$vc_options['as_parent']   = $this->get_module_parent();
			$vc_options['as_child']    = $this->get_module_child();

			if ( ! empty( $vc_options['as_parent'] ) ) {
				include_once 'modules-container.php';

				$vc_options['js_view'] = 'VcColumnView';
			}

			vc_map( $vc_options );
		}
	}

	public function get_module_parent() {
		return '';
	}

	public function get_module_child() {
		return '';
	}

	public function show_compatible_column() {
		$option_group = isset( $this->options[0]['group'] ) ? $this->options[0]['group'] : "";


		$compatible_column = array(
			'type'        => 'alert',
			'param_name'  => 'compatible_column_notice',
			'heading'     => esc_html__( 'Compatible Column: ', 'epic-ne' ) . implode( $this->compatible_column(), ', ' ),
			'description' => esc_html__( 'Please check style / design tab to change Module / Block width and make it fit with your current column width', 'epic-ne' ),
			'group'       => $option_group,
			'std'         => 'info'
		);

		array_unshift( $this->options, $compatible_column );
	}

	public function set_content_filter_option( $number = 10, $hide_number_post = false ) {
		$dependency = array(
			'element' => "sort_by",
			'value'   => array(
				'post_type',
				'latest',
				'oldest',
				'alphabet_asc',
				'alphabet_desc',
				'random',
				'random_week',
				'random_month',
				'most_comment',
				'most_comment_day',
				'most_comment_week',
				'most_comment_month',
				'popular_post_jetpack_day',
				'popular_post_jetpack_week',
				'popular_post_jetpack_month',
				'popular_post_jetpack_all',
				'rate',
				'like',
				'share'
			)
		);

		$this->options[] = array(
			'type'        => 'select',
			'param_name'  => 'post_type',
			'heading'     => esc_html__( 'Include Post Type', 'epic-ne' ),
			'description' => esc_html__( 'Choose post type for this content.', 'epic-ne' ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => 'post',
			'value'       => array_flip( epic_get_enable_post_type() ),
			'dependency'  => $dependency
		);

		if ( ! $hide_number_post ) {
			$this->options[] = array(
				'type'        => 'slider',
				'param_name'  => 'number_post',
				'heading'     => esc_html__( 'Number of Post', 'epic-ne' ),
				'description' => esc_html__( 'Show number of post on this module.', 'epic-ne' ),
				'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
				'min'         => 1,
				'max'         => 30,
				'step'        => 1,
				'std'         => $number,
			);
		}

		if ( $hide_number_post && $number > 0 ) {
			$this->options[] = array(
				'type'        => 'alert',
				'param_name'  => 'content_filter_number_alert',
				'heading'     => esc_html__( 'Number of post', 'epic-ne' ),
				'description' => sprintf( esc_html__( 'This module will require you to choose %s number of post.', 'epic-ne' ), $number ),
				'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
				'std'         => 'info',
			);
		}

		$this->options[] = array(
			'type'        => 'number',
			'param_name'  => 'post_offset',
			'heading'     => esc_html__( 'Post Offset', 'epic-ne' ),
			'description' => esc_html__( 'Number of post offset (start of content).', 'epic-ne' ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'min'         => 0,
			'max'         => PHP_INT_MAX,
			'step'        => 1,
			'std'         => 0,
			'dependency'  => $dependency
		);

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'unique_content',
			'heading'     => esc_html__( 'Include into Unique Content Group', 'epic-ne' ),
			'description' => esc_html__( 'Choose unique content option, and this module will be included into unique content group. It won\'t duplicate content across the group. Ajax loaded content won\'t affect this unique content feature.', 'epic-ne' ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => 'disable',
			'value'       => array(
				esc_html__( 'Disable', 'epic-ne' )                  => 'disable',
				esc_html__( 'Unique Content - Group 1', 'epic-ne' ) => 'unique1',
				esc_html__( 'Unique Content - Group 2', 'epic-ne' ) => 'unique2',
				esc_html__( 'Unique Content - Group 3', 'epic-ne' ) => 'unique3',
				esc_html__( 'Unique Content - Group 4', 'epic-ne' ) => 'unique4',
				esc_html__( 'Unique Content - Group 5', 'epic-ne' ) => 'unique5',
			),
			'dependency'  => $dependency
		);

		$this->options[] = array(
			'type'     => 'select',
			'multiple' => PHP_INT_MAX,
			'ajax'     => 'epic_find_post',
			'options'  => 'epic_get_post_option',
			'nonce'    => wp_create_nonce( 'epic_find_post' ),

			'param_name'  => 'include_post',
			'heading'     => esc_html__( 'Include Post ID', 'epic-ne' ),
			'description' => wp_kses( __( "Tips :<br/> - You can search post id by inputing title, clicking search title, and you will have your post id.<br/>- You can also directly insert your post id, and click enter to add it on the list.", 'epic-ne' ), wp_kses_allowed_html() ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => '',
			'dependency'  => $dependency
		);

		$this->options[] = array(
			'type'     => 'select',
			'multiple' => PHP_INT_MAX,
			'ajax'     => 'epic_find_post',
			'options'  => 'epic_get_post_option',
			'nonce'    => wp_create_nonce( 'epic_find_post' ),

			'param_name'  => 'exclude_post',
			'heading'     => esc_html__( 'Exclude Post ID', 'epic-ne' ),
			'description' => wp_kses( __( "Tips :<br/> - You can search post id by inputing title, clicking search title, and you will have your post id.<br/>- You can also directly insert your post id, and click enter to add it on the list.", 'epic-ne' ), wp_kses_allowed_html() ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => '',
			'dependency'  => $dependency
		);

		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'epic_find_category',
			'options'     => 'epic_get_category_option',
			'nonce'       => wp_create_nonce( 'epic_find_category' ),
			'param_name'  => 'include_category',
			'heading'     => esc_html__( 'Include Category', 'epic-ne' ),
			'description' => esc_html__( 'Choose which category you want to show on this module.', 'epic-ne' ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => '',
			'dependency'  => array( 'element' => "post_type", 'value' => "post" ),
		);

		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'epic_find_category',
			'options'     => 'epic_get_category_option',
			'nonce'       => wp_create_nonce( 'epic_find_category' ),
			'param_name'  => 'exclude_category',
			'heading'     => esc_html__( 'Exclude Category', 'epic-ne' ),
			'description' => esc_html__( 'Choose excluded category for this module.', 'epic-ne' ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => '',
			'dependency'  => array( 'element' => "post_type", 'value' => "post" ),
		);

		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'epic_find_author',
			'options'     => 'epic_get_author_option',
			'nonce'       => wp_create_nonce( 'epic_find_author' ),
			'param_name'  => 'include_author',
			'heading'     => esc_html__( 'Author', 'epic-ne' ),
			'description' => esc_html__( 'Write to search post author.', 'epic-ne' ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => '',
			'dependency'  => $dependency
		);

		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'epic_find_tag',
			'options'     => 'epic_get_tag_option',
			'nonce'       => wp_create_nonce( 'epic_find_tag' ),
			'param_name'  => 'include_tag',
			'heading'     => esc_html__( 'Include Tags', 'epic-ne' ),
			'description' => esc_html__( 'Write to search post tag.', 'epic-ne' ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => '',
			'dependency'  => array( 'element' => "post_type", 'value' => "post" ),
		);

		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'epic_find_tag',
			'options'     => 'epic_get_tag_option',
			'nonce'       => wp_create_nonce( 'epic_find_tag' ),
			'param_name'  => 'exclude_tag',
			'heading'     => esc_html__( 'Exclude Tags', 'epic-ne' ),
			'description' => esc_html__( 'Write to search post tag.', 'epic-ne' ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => '',
			'dependency'  => array( 'element' => "post_type", 'value' => "post" ),
		);

		$this->set_taxonomy_option();

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'sort_by',
			'heading'     => esc_html__( 'Sort by', 'epic-ne' ),
			'description' =>
				wp_kses( __( "Sort post by this option<br/>* <strong>Jetpack :</strong> Need <strong>Jetpack</strong> plugin & Stat module enabled.<br/>", 'epic-ne' ), wp_kses_allowed_html() ),
			'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
			'std'         => 'latest',
			'value'       => array(
				esc_html__( 'Latest Post', 'epic-ne' )                       => 'latest',
				esc_html__( 'Oldest Post', 'epic-ne' )                       => 'oldest',
				esc_html__( 'Alphabet Asc', 'epic-ne' )                      => 'alphabet_asc',
				esc_html__( 'Alphabet Desc', 'epic-ne' )                     => 'alphabet_desc',
				esc_html__( 'Random Post', 'epic-ne' )                       => 'random',
				esc_html__( 'Random Post (7 Days)', 'epic-ne' )              => 'random_week',
				esc_html__( 'Random Post (30 Days)', 'epic-ne' )             => 'random_month',
				esc_html__( 'Most Comment', 'epic-ne' )                      => 'most_comment',
				esc_html__( 'Popular Post (1 Day - Jetpack)', 'epic-ne' )    => 'popular_post_jetpack_day',
				esc_html__( 'Popular Post (7 Days - Jetpack)', 'epic-ne' )   => 'popular_post_jetpack_week',
				esc_html__( 'Popular Post (30 Days - Jetpack)', 'epic-ne' )  => 'popular_post_jetpack_month',
				esc_html__( 'Popular Post (All Time - Jetpack)', 'epic-ne' ) => 'popular_post_jetpack_all',
			)
		);
	}

	public function set_style_option() {
		$width = array(
			esc_html__( 'Auto', 'epic-ne' ) => 'auto'
		);

		if ( in_array( 4, $this->compatible_column() ) ) {
			$width = array_merge( $width, array(
				esc_html__( '4 Column Design ( 1 Block )', 'epic-ne' ) => 4
			) );
		}

		if ( in_array( 8, $this->compatible_column() ) ) {
			$width = array_merge( $width, array(
				esc_html__( '8 Column Design ( 2 Block )', 'epic-ne' ) => 8
			) );
		}

		if ( in_array( 12, $this->compatible_column() ) ) {
			$width = array_merge( $width, array(
				esc_html__( '12 Column Design ( 3 Block )', 'epic-ne' ) => 12
			) );
		}

		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'epic-ne' ),
			'description' => wp_kses( sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s">w3c specification</a>).', 'epic-ne' ), 'http://www.w3schools.com/tags/att_global_id.asp' ), wp_kses_allowed_html() ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
		);

		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'el_class',
			'heading'     => esc_html__( 'Extra class name', 'epic-ne' ),
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
		);

		if ( $this->show_color_scheme() ) {
			$this->options[] = array(
				'type'        => 'dropdown',
				'param_name'  => 'scheme',
				'heading'     => esc_html__( 'Element Color Scheme', 'epic-ne' ),
				'description' => esc_html__( 'choose element color scheme for your element ', 'epic-ne' ),
				'group'       => esc_html__( 'Design', 'epic-ne' ),
				'default'     => 'normal',
				'value'       => array(
					esc_html__( 'Light', 'epic-ne' ) => 'normal',
					esc_html__( 'Dark', 'epic-ne' )  => 'alt'
				)
			);
		}

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'column_width',
			'heading'     => esc_html__( 'Block / Column Width', 'epic-ne' ),
			'description' => esc_html__( 'Please choose width of column you want to use on this block. 1 Block represents 4 columns.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
			'std'         => 'auto',
			'value'       => $width,
		);

		$this->additional_style();

		$this->options[] = array(
			'type'       => 'css_editor',
			'param_name' => 'css',
			'heading'    => esc_html__( 'CSS Box', 'epic-ne' ),
			'group'      => esc_html__( 'Design', 'epic-ne' ),
		);
	}

	public function additional_style() {
	}

	public function show_color_scheme() {
		return true;
	}

	public function get_category() {
		return esc_html__( 'EPIC - Module', 'epic-ne' );
	}

	public function set_typography_option( $instance ) {
		return false;
	}

	public function set_taxonomy_option() {

		$taxonomies = \EPIC\Util\Cache::get_enable_custom_taxonomies();

		foreach ( $taxonomies as $key => $value ) {

			$this->options[] = array(
				'type'        => 'textfield',
				'param_name'  => $key,
				'heading'     => $value['name'],
				'description' => esc_html__( 'Insert ids of ' . strtolower( $value['name'] ) . ' that you want to include as filter and separate them by comma (Ex: 12,34,56).', 'epic-ne' ),
				'group'       => esc_html__( 'Content Filter', 'epic-ne' ),
				'dependency'  => array( 'element' => 'post_type', 'value' => $value['post_types'] ),
			);
		}
	}

	abstract public function set_options();

	abstract public function get_module_name();

	abstract public function compatible_column();
}
