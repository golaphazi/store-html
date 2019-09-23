<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Carousel;

use EPIC\Module\ModuleViewAbstract;

abstract Class CarouselViewAbstract extends ModuleViewAbstract
{
    public function render_module($attr, $column_class)
    {
        $attr['pagination_number_post'] = 1;
        $results = $this->build_query($attr);
        return $this->render_element($results['result'], $attr);
    }

    public function post_meta($post)
    {
        $output = "<div class=\"jeg_post_meta\">";
        $output .= epic_get_option('show_block_meta_date', true) ? "<div class=\"jeg_meta_date\"><a href=\"" . get_the_permalink($post) . "\" ><i class=\"fa fa-clock-o\"></i> " . $this->format_date($post) . "</a></div>" : "";
        $output .= "</div>";

        return $output;
    }

    abstract public function render_element($result, $attr);
}
