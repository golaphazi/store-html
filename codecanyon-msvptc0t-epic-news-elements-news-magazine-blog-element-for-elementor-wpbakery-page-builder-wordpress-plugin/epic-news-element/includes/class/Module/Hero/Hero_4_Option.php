<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Hero;

Class Hero_4_Option extends HeroOptionAbstract
{
    protected $number_post = 3;

    public function get_module_name()
    {
        return esc_html__('EPIC - Hero 4', 'epic-ne');
    }
}
