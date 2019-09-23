<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Hero;

Class Hero_10_Option extends HeroOptionAbstract
{
    protected $number_post = 7;

    public function get_module_name()
    {
        return esc_html__('EPIC - Hero 10', 'epic-ne');
    }
}
