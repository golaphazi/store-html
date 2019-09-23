<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Post;

use EPIC\Module\Block\BlockViewAbstract;

Class Post_Related_View extends PostViewAbstract {

	public function render_module_back( $attr, $column_class ) {

		$attribute = array(
			'first_title'             => $attr['first_title'],
			'second_title'            => $attr['second_title'],
			'header_type'             => $attr['header_type'],
			'date_format'             => $attr['date'],
			'date_format_custom'      => $attr['date_custom'],
			'excerpt_length'          => $attr['excerpt'],
			'pagination_number_post'  => $attr['number'],
			'number_post'             => $attr['number'],
			'include_category'        => '',
			'include_tag'             => '',
			'sort_by'                 => 'latest',
			'pagination_mode'         => $attr['pagination'],
			'pagination_scroll_limit' => $attr['auto_load'],
			'paged'                   => 1,
		);

		$name = 'EPIC_Block_' . $attr['template'];
		$name = epic_get_view_class_from_shortcode( $name );

		/** @var $content_instance BlockViewAbstract */
		$content_instance = epic_get_module_instance( $name );
		$result           = $content_instance->build_module( $attribute );

		return
			"<div {$this->element_id($attr)} class='jeg_custom_related_wrapper {$attr['scheme']} {$attr['el_class']}'>" .
			$result .
			"</div>";
	}

	public function render_module_front( $attr, $column_class ) {
		$match    = $attr['match'];
		$category = $tag = $result = array();
		if ( $match === 'category' ) {
			jeg_recursive_category( get_the_category(), $result );

			if ( $result ) {
				foreach ( $result as $cat ) {
					$category[] = $cat->term_id;
				}
			}
		} else if ( $match === 'tag' ) {
			$tags = get_the_tags();
			if ( $tags ) {
				foreach ( $tags as $cat ) {
					$tag[] = $cat->term_id;
				}
			}
		}

		$attribute = array(
			'first_title'             => isset( $attr['first_title'] ) ? $attr['first_title'] : esc_html__( 'Related', 'epic-ne' ),
			'second_title'            => isset( $attr['second_title'] ) ? $attr['second_title'] : esc_html__( ' Posts', 'epic-ne' ),
			'header_type'             => $attr['header_type'],
			'date_format'             => $attr['date'],
			'date_format_custom'      => $attr['date_custom'],
			'excerpt_length'          => $attr['excerpt'],
			'pagination_number_post'  => $attr['number'],
			'number_post'             => $attr['number'],
			'include_category'        => implode( ',', $category ),
			'include_tag'             => implode( ',', $tag ),
			'exclude_post'            => get_the_ID(),
			'sort_by'                 => 'latest',
			'pagination_mode'         => $attr['pagination'],
			'pagination_scroll_limit' => $attr['auto_load'],
			'paged'                   => 1,
		);

		$name = 'EPIC_Block_' . $attr['template'];
		$name = epic_get_view_class_from_shortcode( $name );

		/** @var $content_instance BlockViewAbstract */
		$content_instance = epic_get_module_instance( $name );
		$result           = $content_instance->build_module( $attribute );

		return
			"<div {$this->element_id($attr)} class='epic_related_post_container jeg_custom_related_wrapper {$attr['scheme']} {$attr['el_class']}'>" .
			$result .
			"</div>";
	}
}
