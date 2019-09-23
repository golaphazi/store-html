<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_33_Option extends BlockOptionAbstract
{
    protected $default_number_post = 6;
    protected $show_excerpt = true;
    protected $default_ajax_post = 3;

    public function get_module_name()
    {
        return esc_html__('EPIC - Module 33', 'epic-ne');
    }

	public function additional_style()
	{
		parent::additional_style();

		$this->options[] = array(
			'type'          => 'colorpicker',
			'param_name'    => 'readmore_background',
			'group'         => esc_html__('Design', 'epic-ne'),
			'heading'       => esc_html__('Readmore Button Background', 'epic-ne'),
			'description'   => esc_html__('Change the readmore button background color', 'epic-ne'),
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
			'std'			=> false
		);
	}
}
