<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Gutenberg;

use EPIC\Asset;

class ModuleGutenberg {

	private static $instance;

	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'setup_hook' ) );
	}

	public function setup_hook() {
		if ( function_exists( 'register_block_type' ) ) {
			add_action( 'enqueue_block_editor_assets',      array( $this, 'load_assets' ) );

			add_filter( 'block_categories',                 array( $this, 'module_category' ) );
			add_filter( 'epic_get_option_image_load',       array( $this, 'switch_normal_load' ) );

			$this->register_block();
		}
	}

	public function switch_normal_load( $value ) {
		if ( $this->is_gutenberg_editor() )
			return 'normal';

		return $value;
	}

	public function is_gutenberg_editor() {
		if ( isset( $_GET['context'] ) && $_GET['context'] === 'edit' )
			return true;

		return false;
	}

	public function register_block() {
		$modules = include_once 'modules.php';

		require_once EPIC_DIR . '/includes/class/Gutenberg/modules-gutenberg.php';

		foreach ( $modules as $module ) {
			$slug  = $this->get_class_slug( $module['name'] );
			$class = new $module['name']();

			register_block_type( 'epic-gutenberg/' . $slug, array(
				'attributes'      => $class->attribute(),
				'render_callback' => array( $class, 'render' ),
			) );
		}
	}

	protected function get_class_slug( $class ) {
		$slug = explode( '_', $class );
		$slug = strtolower( $slug[1] . '-' . $slug[2] );

		return $slug;
	}

	public function load_assets() {
		wp_enqueue_style('epic-icon',               EPIC_URL . '/assets/fonts/jegicon/jegicon.css');
		wp_enqueue_style( 'epic-frontend-style',    EPIC_URL . '/assets/css/style.min.css' );
		wp_enqueue_style( 'epic-gutenberg-editor',  EPIC_URL . '/assets/css/admin/gutenberg.css', null, null );

		wp_enqueue_script( 'wp-mediaelement' );
		wp_enqueue_script( 'imagesloaded' );

		wp_enqueue_script( 'epic-script',           EPIC_URL . '/assets/js/script.min.js', null, null, true );
		wp_enqueue_script( 'epic-gutenberg-editor', EPIC_URL . '/assets/js/admin/gutenberg.js', array(
			'wp-blocks',
			'wp-element',
			'wp-components',
			'wp-editor',
			'wp-i18n'
		) );

		wp_localize_script( 'epic-script', 'epicoption', Asset::getInstance()->localize_script() );
		wp_localize_script( 'epic-gutenberg-editor', 'epicgutenbergoption', Asset::getInstance()->localize_script() );
	}

	public function module_category( $categories ) {
		$category = array(
			array(
				'slug'  => 'epic-block',
				'title' => esc_html__( 'EPIC Block', 'epic-gutenberg' )
			),
			array(
				'slug'  => 'epic-hero',
				'title' => esc_html__( 'EPIC Hero', 'epic-gutenberg' )
			),
			array(
				'slug'  => 'epic-slider',
				'title' => esc_html__( 'EPIC Slider', 'epic-gutenberg' )
			),
			array(
				'slug'  => 'epic-element',
				'title' => esc_html__( 'EPIC Element', 'epic-gutenberg' )
			),
			array(
				'slug'  => 'epic-carousel',
				'title' => esc_html__( 'EPIC Carousel', 'epic-gutenberg' )
			)
		);

		return array_merge( $categories, $category );
	}
}
