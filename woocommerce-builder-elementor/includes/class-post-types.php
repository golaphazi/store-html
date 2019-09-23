<?php
defined( 'ABSPATH' ) || exit();

/**
 * WooCommerce Builder Elementor Post types Class.
 */
class DTWCBE_Post_Types {
	
	const CPT = 'dtwcbe_woo_library';
	
	const TAXONOMY_TYPE_SLUG = 'dtwcbe_woo_library_type';
	
	private $post_type_object;
	
	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_data' ), 5 );
		add_filter( 'gutenberg_can_edit_post_type', array( __CLASS__, 'gutenberg_can_edit_post_type' ), 10, 2 );
		add_filter( 'use_block_editor_for_post_type', array( __CLASS__, 'gutenberg_can_edit_post_type' ), 10, 2 );
	}

	public static function register_data() {
		if ( ! is_blog_installed() || ! class_exists( 'WooCommerce' ) )
			return;
		
		$supports = array( 'title', 'thumbnail', 'author', 'elementor' );
		
		$labels = array( 
			'name' => esc_html__( 'WooCommerce Builder Templates', 'woocommerce-builder-elementor' ), 
			'singular_name' => esc_html__( 'WooCommerce Builder Templates', 'woocommerce-builder-elementor' ), 
			'all_items' => esc_html__( 'WooCommerce Builder Templates', 'woocommerce-builder-elementor' ), 
			'menu_name' => esc_html_x( 'WooCommerce Templates', 'Admin menu name', 'woocommerce-builder-elementor' ), 
			'add_new' => esc_html__( 'Add New', 'woocommerce-builder-elementor' ), 
			'add_new_item' => esc_html__( 'Add new product template', 'woocommerce-builder-elementor' ), 
			'edit' => esc_html__( 'Edit', 'woocommerce-builder-elementor' ), 
			'edit_item' => esc_html__( 'Edit template', 'woocommerce-builder-elementor' ), 
			'new_item' => esc_html__( 'New template', 'woocommerce-builder-elementor' ), 
			'view_item' => esc_html__( 'View template', 'woocommerce-builder-elementor' ), 
			'view_items' => esc_html__( 'View templates', 'woocommerce-builder-elementor' ), 
			'search_items' => esc_html__( 'Search template', 'woocommerce-builder-elementor' ), 
			'not_found' => esc_html__( 'No templates found', 'woocommerce-builder-elementor' ), 
			'not_found_in_trash' => esc_html__( 'No templates found in trash', 'woocommerce-builder-elementor' ), 
			'parent' => esc_html__( 'Parent template', 'woocommerce-builder-elementor' ), 
		);
		
		$args = [
			'labels' => $labels,
			'public' => true,
			'rewrite' => false,
			'menu_icon' => 'dashicons-admin-page',
			'show_ui' => true,
			'show_in_menu' => 'edit.php?post_type=dtwcbe_woo_library',
			'show_in_nav_menus' => false,
			'exclude_from_search' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => $supports,
		];
		
		register_post_type( self::CPT, $args );
		
		$args = [
			'hierarchical' => false,
			'show_ui' => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' => is_admin(),
			'rewrite' => false,
			'public' => false,
			'label' => esc_html_x( 'Type', 'Template Library', 'woocommerce-builder-elementor' ),
		];
		/**
		 * Register template library taxonomy args.
		 *
		 * Filters the taxonomy arguments when registering elementor template library taxonomy.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Arguments for registering a taxonomy.
		*/
		register_taxonomy( self::TAXONOMY_TYPE_SLUG, self::CPT, $args );
	}
	
	public static function post_type(){
		return self::CPT;
	}
	
	/**
	 * Disable Gutenberg for products.
	 *
	 * @param bool   $can_edit Whether the post type can be edited or not.
	 * @param string $post_type The post type being checked.
	 * @return bool
	 */
	public static function gutenberg_can_edit_post_type( $can_edit, $post_type ) {
		return 'dtwcbe_woo_library' === $post_type ? false : $can_edit;
	}
}

DTWCBE_Post_Types::init();
