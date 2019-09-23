<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Slider;

Class Slider_5_Option extends SliderOptionAbstract
{
    protected $default_number = 5;
	protected $gradient_option = true;
	protected $design_option = true;

    public function get_module_name()
    {
        return esc_html__('EPIC - Slider 5', 'epic-ne');
    }
}
