<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Single;

class SinglePost extends SingleAbstract {

	private static $instance;

	protected $post_type = 'custom-post-template';

	protected $post_slug = 'post_template';

	protected $post_option_key = 'single_post_template';

	public static function getInstance() {

		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {

		add_action( 'init', array( $this, 'single_template_post_type' ), 9 );

		add_filter( 'single_template', array( $this, 'get_post_template' ) );
		add_filter( 'post_row_actions', array( $this, 'single_row_action' ), null, 2 );

		if ( is_admin() ) {
			add_filter( 'vc_get_all_templates', array( $this, 'template_library' ) );
			add_filter( 'vc_templates_render_category', array( $this, 'render_template_library' ) );
			add_filter( 'vc_templates_render_backend_template', array( $this, 'ajax_template_backend' ), null, 2 );
		} else {
			add_action( 'wp_head', array( $this, 'custom_post_css' ), 999 );
			add_filter( 'vc_templates_render_frontend_template', array( $this, 'ajax_template_frontend' ), null, 2 );
		}
	}

	public function get_custom_page_id() {
		return epic_get_option( 'single_post_template_id', null );
	}

	public function single_template_post_type() {

		register_post_type( 'custom-post-template', array(
			'labels'          =>
				array(
					'name'               => esc_html__( 'Post Template', 'epic-ne' ),
					'singular_name'      => esc_html__( 'Post Template', 'epic-ne' ),
					'menu_name'          => esc_html__( 'Post Template', 'epic-ne' ),
					'add_new'            => esc_html__( 'New Post Template', 'epic-ne' ),
					'add_new_item'       => esc_html__( 'Build Post Template', 'epic-ne' ),
					'edit_item'          => esc_html__( 'Edit Post Template', 'epic-ne' ),
					'new_item'           => esc_html__( 'New Post Template Entry', 'epic-ne' ),
					'view_item'          => esc_html__( 'View Post Template', 'epic-ne' ),
					'search_items'       => esc_html__( 'Search Post Template', 'epic-ne' ),
					'not_found'          => esc_html__( 'No entry found', 'epic-ne' ),
					'not_found_in_trash' => esc_html__( 'No Post Template in Trash', 'epic-ne' ),
					'parent_item_colon'  => ''
				),
			'description'     => esc_html__( 'Single Post Template', 'epic-ne' ),
			'public'          => true,
			'show_ui'         => true,
			'menu_position'   => 6,
			'capability_type' => 'post',
			'hierarchical'    => false,
			'supports'        => array( 'title', 'editor' ),
			'map_meta_cap'    => true,
			'rewrite'         => array(
				'slug' => 'post-template'
			)
		) );
	}

	public function get_post_template( $single_template ) {
		global $post;

		if ( $post->post_type == 'post' && epic_get_option( 'single_post_template', false ) ) {
			$single_template = EPIC_DIR . '/template/post/single.php';
		}

		if ( $post->post_type == 'custom-post-template' ) {
			$single_template = EPIC_DIR . '/template/editor/single.php';
		}

		return $single_template;
	}

	protected function get_category_name() {
		return esc_html__( 'Post Template', 'epic-ne' );
	}

	protected function get_category_desc() {
		return esc_html__( 'Post Template for Epic News Element', 'epic-ne' );
	}
}
