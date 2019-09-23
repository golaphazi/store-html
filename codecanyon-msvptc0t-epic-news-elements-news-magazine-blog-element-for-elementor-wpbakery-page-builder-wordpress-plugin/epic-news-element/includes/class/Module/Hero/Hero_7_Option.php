<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Hero;

Class Hero_7_Option extends HeroOptionAbstract
{
    protected $number_post = 4;

    public function get_module_name()
    {
        return esc_html__('EPIC - Hero 7', 'epic-ne');
    }
}
