<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Hero;

Class Hero_12_Option extends HeroOptionAbstract
{
    protected $number_post = 5;

    public function get_module_name()
    {
        return esc_html__('EPIC - Hero 12', 'epic-ne');
    }
}
