<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_16_Option extends BlockOptionAbstract
{
    protected $default_number_post = 5;
    protected $show_excerpt = true;
    protected $default_ajax_post = 4;

    public function get_module_name()
    {
        return esc_html__('EPIC - Module 16', 'epic-ne');
    }
}
