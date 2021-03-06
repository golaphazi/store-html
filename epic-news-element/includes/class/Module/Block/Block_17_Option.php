<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_17_Option extends BlockOptionAbstract
{
    protected $default_number_post = 6;
    protected $show_excerpt = true;
    protected $default_ajax_post = 4;

    public function get_module_name()
    {
        return esc_html__('EPIC - Module 17', 'epic-ne');
    }

	public function set_style_option()
	{
		$this->set_boxed_option();
		parent::set_style_option();
	}
}
