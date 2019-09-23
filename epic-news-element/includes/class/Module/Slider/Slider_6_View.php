<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Slider;

Class Slider_6_View extends SliderViewAbstract
{
    public function content($results)
    {
        $content = '';
        foreach($results as $key => $post)
        {
            $primary_category = $this->get_primary_category($post->ID);

            if($this->manager->get_current_width() > 8){
                $image = get_the_post_thumbnail_url($post->ID, 'epic-1140x570');
            } else {
                $image = get_the_post_thumbnail_url($post->ID, 'epic-750x375');
            }

            $content .=
                "<div " . epic_post_class("jeg_slide_item", $post->ID) . " style=\"background-image: url({$image})\">
                    " . epic_edit_post( $post->ID ) . "
                    <div class=\"jeg_slide_caption\">
                        <div class=\"jeg_caption_container\">
                            <div class=\"jeg_post_category\">
                                {$primary_category}
                            </div>
                            <h2 class=\"jeg_post_title\">
                                <a href=\"" . get_the_permalink($post) . "\">" . get_the_title($post) . "</a>
                            </h2>
                            <p class=\"jeg_post_excerpt\"> {$this->get_excerpt($post)} </p>
                            {$this->render_meta($post)}
                        </div>
                    </div>
                </div>";
        }

        return $content;
    }

    public function render_element($result, $attr)
    {
        if(!empty($result))
        {
            $content            = $this->content($result);
            $autoplay_delay     = isset( $attr['autoplay_delay']['size'] ) ? $attr['autoplay_delay']['size'] : $attr['autoplay_delay'];
            $nav_prev           = esc_html__('prev', 'epic-ne');
            $nav_next           = esc_html__('next', 'epic-ne');
	        $additional_class   = isset($attr['overlay_option']) && $attr['overlay_option'] === 'none' ? 'no-overlay' : '';
//	        $style              = $this->generate_style($attr);

            $output =
                "<div {$this->element_id($attr)} class=\"jeg_slider_wrapper {$this->unique_id} {$this->get_vc_class_name()} {$additional_class} {$attr['el_class']}\">
                    <div class=\"jeg_slider_type_6 jeg_slider epic-owl-carousel\" data-autoplay=\"{$attr['enable_autoplay']}\" data-delay=\"{$autoplay_delay}\" data-nav-prev=\"{$nav_prev}\" data-nav-next=\"{$nav_next}\">
                        {$content}
                    </div>
                </div>";

            return $output;
        } else {
            return $this->empty_content();
        }
    }
}
