<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Post;

use EPIC\Module\ModuleOptionAbstract;

Class Post_Title_Option extends ModuleOptionAbstract {
	public function get_category() {
		return esc_html__( 'EPIC - Post', 'epic-ne' );
	}

	public function compatible_column() {
		return array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 );
	}

	public function get_module_name() {
		return esc_html__( 'EPIC - Post Title', 'epic-ne' );
	}

	public function set_options() {

		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'font_size',
			'heading'     => esc_html__( 'Font Size', 'epic-ne' ),
			'description' => esc_html__( 'Set font size with unit (Ex: 36px or 4em).', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
		);

		$this->options[] = array(
			'type'        => 'colorpicker',
			'param_name'  => 'title_color',
			'heading'     => esc_html__( 'Title Color', 'epic-ne' ),
			'description' => esc_html__( 'Set title color.', 'epic-ne' ),
			'group'       => esc_html__( 'Design', 'epic-ne' ),
		);

		$this->set_style_option();
	}

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'epic-ne' ),
				'selector' => '{{WRAPPER}} .jeg_post_title',
			]
		);
	}
}
