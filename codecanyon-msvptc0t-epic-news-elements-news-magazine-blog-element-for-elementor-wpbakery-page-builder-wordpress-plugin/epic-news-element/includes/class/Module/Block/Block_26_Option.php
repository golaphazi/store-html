<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_26_Option extends BlockOptionAbstract
{
    protected $default_number_post = 3;
    protected $show_excerpt = true;
    protected $show_ads = true;
    protected $default_ajax_post = 3;

    public function get_module_name()
    {
        return esc_html__('EPIC - Module 26', 'epic-ne');
    }

	public function set_style_option()
	{
		$this->set_boxed_option();
		parent::set_style_option();
	}
}
