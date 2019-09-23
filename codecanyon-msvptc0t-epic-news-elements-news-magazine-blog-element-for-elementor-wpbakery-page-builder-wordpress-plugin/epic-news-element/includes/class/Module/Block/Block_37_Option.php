<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_37_Option extends BlockOptionAbstract
{
	protected $default_number_post = 6;
	protected $default_ajax_post = 4;

	public function get_module_name()
	{
		return esc_html__('EPIC - Module 37', 'epic-ne');
	}

	public function additional_style()
	{
		$this->options[] = array(
			'type'          => 'colorpicker',
			'param_name'    => 'title_color',
			'group'         => esc_html__('Design', 'epic-ne'),
			'heading'       => esc_html__('Title Color', 'epic-ne'),
			'description'   => esc_html__('This option will change your Title color.', 'epic-ne'),
		);

		$this->options[] = array(
			'type'          => 'colorpicker',
			'param_name'    => 'accent_color',
			'group'         => esc_html__('Design', 'epic-ne'),
			'heading'       => esc_html__('Accent Color & Link Hover', 'epic-ne'),
			'description'   => esc_html__('This option will change your accent color.', 'epic-ne'),
		);

		$this->options[] = array(
			'type'          => 'colorpicker',
			'param_name'    => 'alt_color',
			'group'         => esc_html__('Design', 'epic-ne'),
			'heading'       => esc_html__('Meta Color', 'epic-ne'),
			'description'   => esc_html__('This option will change your meta color.', 'epic-ne'),
		);

		$this->options[] = array(
			'type'          => 'colorpicker',
			'param_name'    => 'block_background',
			'group'         => esc_html__('Design', 'epic-ne'),
			'heading'       => esc_html__('Block Background', 'epic-ne'),
			'description'   => esc_html__('This option will change your Block Background', 'epic-ne'),
		);

		$this->options[] = array(
			'type'          => 'checkbox',
			'param_name'    => 'box_shadow',
			'group'         => esc_html__('Design', 'epic-ne'),
			'heading'       => esc_html__('Box Shadow', 'epic-ne'),
			'std'           => false
		);
	}

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for post title', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_post_title > a',
			]
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'meta_typography',
				'label'       => esc_html__( 'Meta Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for post meta', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_post_meta, {{WRAPPER}} .jeg_post_meta .fa, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a:hover, {{WRAPPER}} .jeg_pl_md_card .jeg_post_category a, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a.current, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta .fa, {{WRAPPER}} .jeg_post_category a',
			]
		);
	}
}
