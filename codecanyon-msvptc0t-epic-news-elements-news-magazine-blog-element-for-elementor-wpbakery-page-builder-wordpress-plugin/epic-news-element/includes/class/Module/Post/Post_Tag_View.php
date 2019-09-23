<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Post;

Class Post_Tag_View extends PostViewAbstract {
	public function render_module_back( $attr, $column_class ) {

		$style = $this->generate_style( $attr );

		return
			"<div {$this->element_id($attr)} class='jeg_custom_tag_wrapper {$attr['scheme']} {$attr['el_class']}'>
				{$style}
                <div class=\"jeg_post_tags\">
                    <span>Tags:</span> 
                    <a href=\"#\" rel=\"tag\">First</a>
                    <a href=\"#\" rel=\"tag\">Second</a>
                    <a href=\"#\" rel=\"tag\">Third</a>
                    <a href=\"#\" rel=\"tag\">Forth</a>
                    <a href=\"#\" rel=\"tag\">Fifth</a>
                    <a href=\"#\" rel=\"tag\">Sixth</a>
                </div>
            </div>";
	}

	public function render_module_front( $attr, $column_class ) {

		$style = $this->generate_style( $attr );

		if ( has_tag() ) {
			$tag = "<span>" . esc_html__( 'Tags:', 'epic-ne' ) . "</span> " . get_the_tag_list( '', '', '' );;

			return
				"<div {$this->element_id($attr)} class='jeg_custom_tag_wrapper {$attr['scheme']} {$attr['el_class']}'>
					{$style}
                    <div class=\"jeg_post_tags\">
                        {$tag}
                    </div>
                </div>";
		}
	}

	public function generate_style( $attr ) {

		$result = $normal = $hover = '';

		if ( isset( $attr['text_color'] ) && $attr['text_color'] ) {
			$normal .= 'color: ' . $attr['text_color'] . ';';
		}

		if ( isset( $attr['bg_color'] ) && $attr['bg_color'] ) {
			$normal .= 'background-color: ' . $attr['bg_color'] . ';';
		}

		if ( isset( $attr['font_size'] ) && $attr['font_size'] ) {
			$normal .= 'font-size: ' . $attr['font_size'] . ';';
		}

		if ( $normal ) {
			$result .= $this->element_id( $attr ) . ' .jeg_post_tags a{' . $normal . '}';
		}

		if ( isset( $attr['text_color_hover'] ) && $attr['text_color_hover'] ) {
			$hover .= 'color: ' . $attr['text_color_hover'] . ';';
		}

		if ( isset( $attr['bg_color_hover'] ) && $attr['bg_color_hover'] ) {
			$hover .= 'background-color: ' . $attr['bg_color_hover'] . ';';
		}

		if ( $hover ) {
			$result .= $this->element_id( $attr ) . ' .jeg_post_tags a:hover{' . $hover . '}';
		}

		if ( $result ) {
			$result = '<style>' . $result . '</style>';
		}

		return $result;
	}
}
