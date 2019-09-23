<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Post;

Class Post_Sequence_View extends PostViewAbstract {
	public function render_module_back( $attr, $column_class ) {
		$style = isset( $attr['style'] ) ? $attr['style'] : '';

		$border_style = $this->generate_style( $attr );

		return
			"<div {$this->element_id($attr)} class='jeg_custom_prev_next_wrapper epic_prev_next_container {$style} {$attr['scheme']} {$attr['el_class']}'>   
				{$border_style}             
                <div class=\"jeg_prevnext_post\">
                    <a href=\"#\" class=\"post prev-post\">
                        <span class=\"caption\">Previous Post</span>
                        <h3 class=\"post-title\">Lorem ipsum dolor sit amet consectetur adipiscing elit conubia nostra</h3>
                    </a>
        
                    <a href=\"#\" class=\"post next-post\">
                        <span class=\"caption\">Next Post</span>
                        <h3 class=\"post-title\">Nunc eu iaculis mi nulla facilisi aenean a risus sed luctus arcu </h3>
                    </a>
                </div>
            </div>";
	}

	public function render_module_front( $attr, $column_class ) {
		$prev_post_output = $next_post_output = '';
		$prev_post        = get_previous_post();
		$next_post        = get_next_post();

		$style = isset( $attr['style'] ) ? $attr['style'] : '';

		$border_style = $this->generate_style( $attr );

		if ( ! empty( $prev_post ) ) {
			$prev_post_output =
				"<a href=\"" . esc_url( get_permalink( $prev_post->ID ) ) . "\" class=\"post prev-post\">
		            <span class=\"caption\">" . esc_html__( 'Previous Post', 'epic-ne' ) . "</span>
		            <h3 class=\"post-title\">" . wp_kses_post( $prev_post->post_title ) . "</h3>
		        </a>";
		}

		if ( ! empty( $next_post ) ) {
			$next_post_output =
				"<a href=\"" . esc_url( get_permalink( $next_post->ID ) ) . "\" class=\"post next-post\">
		            <span class=\"caption\">" . esc_html__( 'Next Post', 'epic-ne' ) . "</span>
		            <h3 class=\"post-title\">" . wp_kses_post( $next_post->post_title ) . "</h3>
		        </a>";
		}

		return
			"<div {$this->element_id($attr)} class='jeg_custom_prev_next_wrapper epic_prev_next_container {$style} {$attr['scheme']} {$attr['el_class']}'>
				{$border_style}
				<div class=\"jeg_prevnext_post\">
					{$prev_post_output}
					{$next_post_output}
				</div>                
            </div>";
	}

	public function generate_style( $attr ) {

		$result = '';

		if ( isset( $attr['border_color'] ) && $attr['border_color'] ) {
			$result .= $this->element_id( $attr ) . ' .jeg_prevnext_post h3 {border-left-color: ' . $attr['border_color'] . ';}';
		}

		if ( isset( $attr['border_color_hover'] ) && $attr['border_color_hover'] ) {
			$result .= $this->element_id( $attr ) . ' .jeg_prevnext_post a:hover h3 {border-left-color: ' . $attr['border_color_hover'] . ';}';
		}

		if ( isset( $attr['nav_font_size'] ) && $attr['nav_font_size'] ) {
			$result .= $this->element_id( $attr ) . ' .jeg_prevnext_post .caption {font-size: ' . $attr['nav_font_size'] . ';}';
		}

		if ( isset( $attr['nav_color'] ) && $attr['nav_color'] ) {
			$result .= $this->element_id( $attr ) . ' .jeg_prevnext_post .caption {color: ' . $attr['nav_color'] . ';}';
		}

		if ( isset( $attr['title_font_size'] ) && $attr['title_font_size'] ) {
			$result .= $this->element_id( $attr ) . ' .jeg_prevnext_post h3 {font-size: ' . $attr['title_font_size'] . ';}';
		}

		if ( isset( $attr['title_color'] ) && $attr['title_color'] ) {
			$result .= $this->element_id( $attr ) . ' .jeg_prevnext_post h3 {color: ' . $attr['title_color'] . ';}';
		}

		if ( $result ) {
			$result = '<style>' . $result . '</style>';
		}

		return $result;
	}
}
