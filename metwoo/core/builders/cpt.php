<?php
namespace MetWoo\Core\Builders;
defined( 'ABSPATH' ) || exit;
/**
 * Cpt Class.
 * Cpt class for custom post type of Builders.
 * @extend Inherite class \MetWoo\Base\Cpt Abstract Class
 *
 * @since 1.0.0
 */
Class Cpt extends \MetWoo\Base\Cpt{

    // set custom post type name
    public function get_name(){
        return 'metwoo-form';
    }

    // set custom post type options data
    public function post_type()
    {
        $labels = array(
            'name'                  => esc_html_x( 'Templates', 'Post Type General Name', 'metwoo' ),
            'singular_name'         => esc_html_x( 'Template', 'Post Type Singular Name', 'metwoo' ),
            'menu_name'             => esc_html__( 'Template', 'metwoo' ),
            'name_admin_bar'        => esc_html__( 'Template', 'metwoo' ),
            'archives'              => esc_html__( 'Template Archives', 'metwoo' ),
            'attributes'            => esc_html__( 'Template Attributes', 'metwoo' ),
            'parent_item_colon'     => esc_html__( 'Parent Item:', 'metwoo' ),
            'all_items'             => esc_html__( 'Templates', 'metwoo' ),
            'add_new_item'          => esc_html__( 'Add New Template', 'metwoo' ),
            'add_new'               => esc_html__( 'Add New', 'metwoo' ),
            'new_item'              => esc_html__( 'New Template', 'metwoo' ),
            'edit_item'             => esc_html__( 'Edit Template', 'metwoo' ),
            'update_item'           => esc_html__( 'Update Template', 'metwoo' ),
            'view_item'             => esc_html__( 'View Template', 'metwoo' ),
            'view_items'            => esc_html__( 'View Templates', 'metwoo' ),
            'search_items'          => esc_html__( 'Search Templates', 'metwoo' ),
            'not_found'             => esc_html__( 'Not found', 'metwoo' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'metwoo' ),
            'featured_image'        => esc_html__( 'Featured Image', 'metwoo' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'metwoo' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'metwoo' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'metwoo' ),
            'insert_into_item'      => esc_html__( 'Insert into Template', 'metwoo' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this Template', 'metwoo' ),
            'items_list'            => esc_html__( 'Templates list', 'metwoo' ),
            'items_list_navigation' => esc_html__( 'Templates list navigation', 'metwoo' ),
            'filter_items_list'     => esc_html__( 'Filter froms list', 'metwoo' ),
        );
        $rewrite = array(
            'slug'                  => 'metwoo',
            'with_front'            => true,
            'pages'                 => false,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => esc_html__( 'Templates', 'metwoo' ),
            'description'           => esc_html__( 'Metwoo Template', 'metwoo' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'elementor', 'permalink' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => "metwoo-menu",
            'menu_icon'             => 'dashicons-text-page',
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'publicly_queryable' => true,
            'rewrite'               => $rewrite,
            'query_var' => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => false,
            'rest_base'             => $this->get_name(),
        );

        return $args;

    }

    // Operation custom post type
    public function flush_rewrites() {
        $name = $this->get_name();
        $args = $this->post_type();
        register_post_type( $name, $args );

        flush_rewrite_rules();
    }

}