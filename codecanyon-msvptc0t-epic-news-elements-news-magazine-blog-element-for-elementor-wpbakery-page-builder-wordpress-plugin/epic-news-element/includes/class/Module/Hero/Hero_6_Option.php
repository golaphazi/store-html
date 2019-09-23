<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Hero;

Class Hero_6_Option extends HeroOptionAbstract
{
    protected $number_post = 4;

    public function get_module_name()
    {
        return esc_html__('EPIC - Hero 6', 'epic-ne');
    }
}
