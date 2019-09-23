<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Archive;

Class Archive_Hero_View extends ArchiveViewAbstract {

	public function render_module_back( $attr, $column_class ) {
		return $this->build_hero_module( $attr );
	}

	public function render_module_front( $attr, $column_class ) {
		return $this->build_hero_module( $attr );
	}

	public function build_hero_module( $attr ) {

		if ( $attr['first_page'] && epic_get_post_current_page() > 1 ) {
			return false;
		}

		$name         = epic_get_view_class_from_shortcode( 'EPIC_Hero_' . $attr['hero_type'] );
		$instance     = epic_get_module_instance( $name );
		$result       = $this->get_result( $attr, $instance->get_number_post() );
		$column_class = $this->get_module_column_class( $attr );

		return $instance->render_output( $result['result'], $attr, $column_class );
	}
}
