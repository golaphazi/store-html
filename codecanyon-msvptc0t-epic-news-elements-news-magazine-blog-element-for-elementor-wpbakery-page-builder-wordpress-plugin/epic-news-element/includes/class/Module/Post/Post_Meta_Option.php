<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Post;

use EPIC\Module\ModuleOptionAbstract;

Class Post_Meta_Option extends ModuleOptionAbstract {
	public function get_category() {
		return esc_html__( 'EPIC - Post', 'epic-ne' );
	}

	public function compatible_column() {
		return array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 );
	}

	public function get_module_name() {
		return esc_html__( 'EPIC - Post Meta', 'epic-ne' );
	}

	public function set_options() {
		$this->set_post_option();
		$this->set_style_option();
	}

	public function set_post_option() {
		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'param_name'  => 'meta_left',
			'heading'     => esc_html__( 'Left Meta Element', 'epic-ne' ),
			'description' => esc_html__( 'Pick element you want to add on meta wrapper.', 'epic-ne' ),
			'group'       => esc_html__( 'Meta Option', 'epic-ne' ),
			'std'         => '',
			'value'       => array(
				esc_html__( 'Author', 'epic-ne' )   => 'author',
				esc_html__( 'Date', 'epic-ne' )     => 'date',
				esc_html__( 'Category', 'epic-ne' ) => 'category',
				esc_html__( 'Comment', 'epic-ne' )  => 'comment',
			)
		);

		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'param_name'  => 'meta_right',
			'heading'     => esc_html__( 'Right Meta Element', 'epic-ne' ),
			'description' => esc_html__( 'Pick element you want to add on meta wrapper.', 'epic-ne' ),
			'group'       => esc_html__( 'Meta Option', 'epic-ne' ),
			'std'         => '',
			'value'       => array(
				esc_html__( 'Author', 'epic-ne' )   => 'author',
				esc_html__( 'Date', 'epic-ne' )     => 'date',
				esc_html__( 'Category', 'epic-ne' ) => 'category',
				esc_html__( 'Comment', 'epic-ne' )  => 'comment',
			)
		);

		$this->options[] = array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show avatar image on author element', 'epic-ne' ),
			'param_name' => 'show_avatar',
			'group'      => esc_html__( 'Meta Option', 'epic-ne' ),
			'value'      => array( esc_html__( "Show avatar image.", 'epic-ne' ) => 'yes' ),
			'std'        => 'yes',
		);

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'post_date',
			'heading'     => esc_html__( 'Post Date', 'epic-ne' ),
			'description' => esc_html__( 'Choose which post date type that you want to show.', 'epic-ne' ),
			'group'       => esc_html__( 'Meta Option', 'epic-ne' ),
			'std'         => 'modified',
			'value'       => array(
				esc_html__( 'Modified Date', 'epic-ne' )  => 'modified',
				esc_html__( 'Published Date', 'epic-ne' ) => 'publish',
			)
		);
	}

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'label'    => esc_html__( 'Typography', 'epic-ne' ),
				'selector' => '{{WRAPPER}} .jeg_post_meta, {{WRAPPER}} .jeg_post_meta .fa, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a:hover, {{WRAPPER}} .jeg_pl_md_card .jeg_post_category a, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a.current, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta .fa, {{WRAPPER}} .jeg_post_category a',
			]
		);
	}
}
