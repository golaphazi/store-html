<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_38_Option extends BlockOptionAbstract
{
	protected $default_number_post = 6;
	protected $show_excerpt = true;
	protected $default_ajax_post = 4;

	public function get_module_name()
	{
		return esc_html__('EPIC - Module 38', 'epic-ne');
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
}
