<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Hero;

Class Hero_9_Option extends HeroOptionAbstract
{
    protected $number_post = 2;

    public function get_module_name()
    {
        return esc_html__('EPIC - Hero 9', 'epic-ne');
    }
}
