<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Archive;

Class Archive_Block_View extends ArchiveViewAbstract {

	public function render_module_back( $attr, $column_class ) {
		return $this->build_block_module( $attr );
	}

	public function render_module_front( $attr, $column_class ) {
		return $this->build_block_module( $attr );
	}

	public function build_block_module( $attr ) {

		if ( $attr['first_page'] && epic_get_post_current_page() > 1 ) {
			return false;
		}

		$name         = epic_get_view_class_from_shortcode( 'EPIC_Block_' . $attr['block_type'] );
		$instance     = epic_get_module_instance( $name );
		$result       = $this->get_result( $attr, $attr['number_post'] );

		if ( ! empty( $result['result'] ) ) {
			$attr['pagination_mode'] = 'disable';
			$attr['results'] = $result;
			return $instance->build_module( $attr );
		}

	}
}
