<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Slider;

Class Slider_2_Option extends SliderOptionAbstract
{
    protected $default_number = 5;

    public function get_module_name()
    {
        return esc_html__('EPIC - Slider 2', 'epic-ne');
    }
}
