<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Post;

Class Post_Meta_View extends PostViewAbstract {

	/** Backend */
	public function render_module_back( $attr, $column_class ) {
		$left_html = $right_html = '';

		$lefts = is_array( $attr['meta_left'] ) ? $attr['meta_left'] : explode( ',', $attr['meta_left'] );
		foreach ( $lefts as $left ) {
			$left_html .= $this->render_meta_back( $left, $attr );
		}
		$left_html = "<div class='meta_left'>{$left_html}</div>";

		$rights = is_array( $attr['meta_right'] ) ? $attr['meta_right'] : explode( ',', $attr['meta_right'] );
		foreach ( $rights as $right ) {
			$right_html .= $this->render_meta_back( $right, $attr );
		}
		$right_html = "<div class='meta_right'>{$right_html}</div>";

		return "<div {$this->element_id($attr)} class='jeg_custom_meta_wrapper {$attr['scheme']} {$attr['el_class']}'>
					<div class='jeg_post_meta'>
						" . $left_html . $right_html . "
					</div>
				</div>";
	}

	public function render_meta_back( $meta, $attr ) {
		if ( ! empty( $meta ) ) {
			$func = "render_" . $meta . "_back";

			return $this->$func( $attr );
		}
	}

	public function render_date_back( $attr ) {
		$date = $attr['post_date'] === 'modified' ? get_the_modified_date() : get_the_date();

		return
			"<div class=\"jeg_meta_date\">
                <a href=\"#\">{$date}</a>
            </div>";
	}

	public function render_category_back( $attr ) {
		return
			"<div class=\"jeg_meta_category\">
                <span>
                    <span class=\"meta_text\">" . esc_html__( 'in', 'epic-ne' ) . "</span>
                    <a href=\"#\" rel=\"category tag\">Dummy</a>, 
                    <a href=\"#\" rel=\"category tag\">Another</a>, 
                    <a href=\"#\" rel=\"category tag\">Category</a>            
                </span>
            </div>";
	}

	public function render_comment_back( $attr ) {
		return '<div class="jeg_meta_comment">
                    <a href="/#respond"><i class="fa fa-comment-o"></i> 0</a>
                </div>';
	}

	public function render_author_back( $attr ) {
		$avatar = '';
		if ( $attr['show_avatar'] ) {
			$avatar = "<img alt=\"admin\" src=\"https://secure.gravatar.com/avatar/2af1c8d5b4f403f0549caed4d53c438e?s=80&d=mm&r=g\" class=\"avatar avatar-80 photo\" data-pin-no-hover=\"true\" width=\"80\" height=\"80\">";
		}

		return
			"<div class=\"jeg_meta_author\"> {$avatar}" .
			"<span class=\"meta_text\"> " .
			esc_html__( 'by', 'epic-ne' ) .
			" </span>" .
			"<a href='#'>admin</a>" .
			"</div>";
	}

	/** Frontend */
	public function render_module_front( $attr, $column_class ) {
		$left_html = $right_html = '';

		// add_filter('theme_mod_global_post_date', function() use ($attr) {return $attr['post_date'];});

		$lefts = is_array( $attr['meta_left'] ) ? $attr['meta_left'] : explode( ',', $attr['meta_left'] );
		foreach ( $lefts as $left ) {
			$left_html .= $this->render_meta( $left, $attr );
		}
		$left_html = "<div class='meta_left'>{$left_html}</div>";

		$rights = is_array( $attr['meta_right'] ) ? $attr['meta_right'] : explode( ',', $attr['meta_right'] );
		foreach ( $rights as $right ) {
			$right_html .= $this->render_meta( $right, $attr );
		}
		$right_html = "<div class='meta_right'>{$right_html}</div>";

		return
			"<div {$this->element_id($attr)} class='jeg_custom_meta_wrapper {$attr['scheme']} {$attr['el_class']}'>
				<div class='jeg_post_meta'>
					" . $left_html . $right_html . "
				</div>
			</div>";
	}

	public function render_meta( $meta, $attr ) {
		if ( ! empty( $meta ) ) {
			$func = "render_" . $meta;

			return $this->$func( $attr );
		}
	}

	public function render_date( $attr ) {
		$date = $attr['post_date'] === 'modified' ? get_the_modified_date() : get_the_date();

		return
			"<div class=\"jeg_meta_date\">
                <a href=\"" . get_the_permalink() . "\">" . esc_html( $date ) . "</a>
            </div>";
	}

	public function render_category( $attr ) {
		return
			"<div class=\"jeg_meta_category\">
                <span>
                    <span class=\"meta_text\">" . esc_html__( 'in', 'epic-ne' ) . "</span>
                    " . get_the_category_list( ', ' ) . " 
                </span>
            </div>";
	}

	public function render_comment( $attr ) {
		return "<div class=\"jeg_meta_comment\"><a href=\"" . epic_get_respond_link() . "\"><i class=\"fa fa-comment-o\"></i> " . esc_html( get_comments_number() ) . "</a></div>";
	}

	public function render_author( $attr ) {
		global $post;

		return
			"<div class=\"jeg_meta_author\">" .
			get_avatar( get_the_author_meta( 'ID', $post->post_author ), 80, null, get_the_author_meta( 'display_name', $post->post_author ) ) .
			"<span class=\"meta_text\">" .
			esc_html__( 'by', 'epic-ne' ) .
			"</span>" .
			epic_the_author_link( $post->post_author, false ) .
			"</div>";
	}
}
