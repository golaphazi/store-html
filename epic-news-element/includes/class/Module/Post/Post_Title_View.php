<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Post;

Class Post_Title_View extends PostViewAbstract {

	public function render_module_back( $attr, $column_class ) {

		$style = $this->generate_style( $attr );

		return
			"<div {$this->element_id($attr)} class='jeg_custom_title_wrapper {$attr['scheme']} {$attr['el_class']}'>
				{$style}
                <h1 class=\"jeg_post_title\">This is dummy title and will be replaced with real title of your post</h1>
            </div>";
	}

	public function render_module_front( $attr, $column_class ) {

		$style = $this->generate_style( $attr );

		return
			"<div {$this->element_id($attr)} class='jeg_custom_title_wrapper {$attr['scheme']} {$attr['el_class']}'>
				{$style}
                <h1 class=\"jeg_post_title\">" . get_the_title() . "</h1>
            </div>";
	}

	public function generate_style( $attr ) {

		$result = '';

		if ( isset( $attr['title_color'] ) && $attr['title_color'] ) {
			$result .= 'color: ' . $attr['title_color'] . ';';
		}

		if ( isset( $attr['font_size'] ) && $attr['font_size'] ) {
			$result .= 'font-size: ' . $attr['font_size'] . ';';
		}

		if ( $result ) {
			$result = '<style>' . $this->element_id( $attr ) . ' .jeg_post_title {' . $result . '}' . '</style>';
		}

		return $result;
	}
}
