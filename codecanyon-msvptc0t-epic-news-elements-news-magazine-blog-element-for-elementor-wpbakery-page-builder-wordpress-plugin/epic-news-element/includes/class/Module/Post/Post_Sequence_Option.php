<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Post;

use EPIC\Module\ModuleOptionAbstract;

Class Post_Sequence_Option extends ModuleOptionAbstract {
	public function get_category() {
		return esc_html__( 'EPIC - Post', 'epic-ne' );
	}

	public function compatible_column() {
		return array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 );
	}

	public function get_module_name() {
		return esc_html__( 'EPIC - Post Next Prev', 'epic-ne' );
	}

	public function set_options() {
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'style',
			'heading'     => esc_html__( 'Nav Style', 'epic-ne' ),
			'description' => esc_html__( 'Choose navigation style for post prev next element.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
			'default'     => 'style_1',
			'value'       => array(
				esc_html__( 'Style 1', 'epic-ne' ) => 'style_1',
				esc_html__( 'Style 2', 'epic-ne' ) => 'style_2',
				esc_html__( 'Style 3', 'epic-ne' ) => 'style_3'
			)
		);

		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'border_color',
			'heading'     => esc_html__( 'Border Color', 'epic-ne' ),
			'description' => esc_html__( 'Set left border color.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
			'dependency'  => array( 'element' => 'style', 'value' => 'style_1' )
		);

		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'border_color_hover',
			'heading'     => esc_html__( 'Border Color Hover', 'epic-ne' ),
			'description' => esc_html__( 'Set left border color hover.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
			'dependency'  => array( 'element' => 'style', 'value' => 'style_1' )
		);

		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'nav_font_size',
			'heading'     => esc_html__( 'Nav Text Font Size', 'epic-ne' ),
			'description' => esc_html__( 'Set font size with unit (Ex: 36px or 4em) for nav text.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
		);

		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'nav_color',
			'heading'     => esc_html__( 'Nav Text Color', 'epic-ne' ),
			'description' => esc_html__( 'Set nav text color.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
		);

		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'title_font_size',
			'heading'     => esc_html__( 'Post Title Font Size', 'epic-ne' ),
			'description' => esc_html__( 'Set font size with unit (Ex: 36px or 4em) for post title.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
		);

		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'title_color',
			'heading'     => esc_html__( 'Post Title Color', 'epic-ne' ),
			'description' => esc_html__( 'Set post title text color.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
		);

		$this->set_style_option();
	}

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'epic-ne' ),
				'selector' => '{{WRAPPER}} .post-title',
			]
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'nav_typography',
				'label'    => esc_html__( 'Nav Text Typography', 'epic-ne' ),
				'selector' => '{{WRAPPER}} .jeg_prevnext_post .caption',
			]
		);
	}
}
