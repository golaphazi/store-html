<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Single;

class SingleArchive extends SingleAbstract {

	private static $instance;

	protected $post_type = 'archive-template';

	protected $post_slug = 'archive_template';

	protected $post_option_key = 'single_category_template';

	public static function getInstance() {

		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	protected function __construct() {

		add_action( 'init', array( $this, 'single_archive_post_type' ), 9 );

		add_filter( 'category_template', array( $this, 'get_category_template' ) );
		add_filter( 'tag_template', array( $this, 'get_tag_template' ) );
		add_filter( 'date_template', array( $this, 'get_date_template' ) );
		add_filter( 'author_template', array( $this, 'get_author_template' ) );
		add_filter( 'single_template', array( $this, 'get_archive_template_editor' ) );
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
		return epic_get_option( 'single_archive_template_id', null );
	}

	public function single_archive_post_type() {

		register_post_type( 'archive-template', array(
			'labels'          =>
				array(
					'name'               => esc_html__( 'Archive Template', 'epic-ne' ),
					'singular_name'      => esc_html__( 'Archive Template', 'epic-ne' ),
					'menu_name'          => esc_html__( 'Archive Template', 'epic-ne' ),
					'add_new'            => esc_html__( 'New Archive Template', 'epic-ne' ),
					'add_new_item'       => esc_html__( 'Build Archive Template', 'epic-ne' ),
					'edit_item'          => esc_html__( 'Edit Archive Template', 'epic-ne' ),
					'new_item'           => esc_html__( 'New Archive Template Entry', 'epic-ne' ),
					'view_item'          => esc_html__( 'View Archive Template', 'epic-ne' ),
					'search_items'       => esc_html__( 'Search Archive Template', 'epic-ne' ),
					'not_found'          => esc_html__( 'No entry found', 'epic-ne' ),
					'not_found_in_trash' => esc_html__( 'No Archive Template in Trash', 'epic-ne' ),
					'parent_item_colon'  => ''
				),
			'description'     => esc_html__( 'Single Archive Template', 'epic-ne' ),
			'public'          => true,
			'show_ui'         => true,
			'menu_position'   => 6,
			'capability_type' => 'post',
			'hierarchical'    => false,
			'supports'        => array( 'title', 'editor' ),
			'map_meta_cap'    => true,
			'rewrite'         => array(
				'slug' => 'archive-template'
			)
		) );
	}

	public function get_archive_template_editor( $template ) {

		global $post;

		if ( $post->post_type == 'archive-template' ) {
			$template = EPIC_DIR . '/template/editor/archive.php';
		}

		return $template;
	}

	public function get_category_template( $template ) {

		if ( epic_get_option( 'single_category_template', false ) ) {
			$template = EPIC_DIR . '/template/archive/category.php';
		}

		return $template;
	}

	public function get_tag_template( $template ) {

		if ( epic_get_option( 'single_tag_template', false ) ) {
			$template = EPIC_DIR . '/template/archive/tag.php';
		}

		return $template;
	}

	public function get_date_template( $template ) {

		if ( epic_get_option( 'single_date_template', false ) ) {
			$template = EPIC_DIR . '/template/archive/date.php';
		}

		return $template;
	}

	public function get_author_template( $template ) {

		if ( epic_get_option( 'single_author_template', false ) ) {
			$template = EPIC_DIR . '/template/archive/author.php';
		}

		return $template;
	}

	protected function get_category_name() {
		return esc_html__( 'Archive Template', 'epic-ne' );
	}

	protected function get_category_desc() {
		return esc_html__( 'Archive Template for Epic News Element', 'epic-ne' );
	}
}
