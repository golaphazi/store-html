<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Slider;

use EPIC\Module\ModuleViewAbstract;

abstract Class SliderViewAbstract extends ModuleViewAbstract
{
    public function render_module($attr, $column_class)
    {
        $attr['pagination_number_post'] = 1;
        $results = $this->build_query($attr);
        return $this->render_element($results['result'], $attr);
    }

    public function render_meta($post)
    {
        $output = '';

        if(epic_get_option('show_block_meta', true))
        {
            $author = $post->post_author;
            $author_url = get_author_posts_url($author);
            $author_name = get_the_author_meta('display_name', $author);
            $time = $this->format_date($post);

            $output .= "<div class=\"jeg_post_meta\">";
            $output .= epic_get_option('show_block_meta_author', true) ? "<span class=\"jeg_meta_author\">" . esc_html__('by', 'epic-ne') . " <a href=\"{$author_url}\">{$author_name}</a></span>" : "";
            $output .= epic_get_option('show_block_meta_date', true) ? "<span class=\"jeg_meta_date\">{$time}</span>" : "";
            $output .= "</div>";
        }

        return $output;
    }

    public function set_slider_option()
    {
        $this->options['enable_autoplay'] = '';
        $this->options['autoplay_delay'] = '3000';
        $this->options['date_format'] = 'default';
        $this->options['date_format_custom'] = 'Y/m/d';
    }

    abstract public function render_element($result, $attr);
}
