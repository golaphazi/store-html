<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Post;

Class Post_Author_View extends PostViewAbstract {

	public function render_module_back( $attr, $column_class ) {
		global $post;

		$author_socials = '';

		if ( get_the_author_meta( "url", $post->post_author ) ) {
			$author_socials .= "<a href='" . get_the_author_meta( 'url', $post->post_author ) . "' rel=\"nofollow\" class=\"url\"><i class=\"fa fa-globe\"></i></a>";
		}

		return
			"<div {$this->element_id($attr)} class='jeg_custom_author_wrapper epic_author_box_container {$attr['scheme']} {$attr['el_class']}'>
				<div class=\"jeg_authorbox\">
				    <div class=\"jeg_author_image\">
				    	" . get_avatar( get_the_author_meta( 'ID', $post->post_author ), 80, null, get_the_author_meta( 'display_name', $post->post_author ) ) . "
				    </div>
				    <div class=\"jeg_author_content\">
				        <h3 class=\"jeg_author_name\">
				        	" . epic_the_author_link( $post->post_author, false ) . "
				        </h3>
				        <p class=\"jeg_author_desc\">
				        	" . get_the_author_meta( 'description', $post->post_author ) . "
				        </p>
				        <div class=\"jeg_author_socials\">
				        	{$author_socials}
				        </div>
				    </div>
				</div>
			</div>";
	}

	public function render_module_front( $attr, $column_class ) {
		return $this->render_module_back( $attr, $column_class );
	}
}
