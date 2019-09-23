<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Archive;

Class Archive_Pagination_View extends ArchiveViewAbstract {

	public function render_module_back( $attr, $column_class ) {
		return $this->build_pagination_module( $attr, 3 );
	}

	public function render_module_front( $attr, $column_class ) {
		return $this->build_pagination_module( $attr, false );
	}

	public function build_pagination_module( $attr, $total ) {
		return epic_paging_navigation( $attr, $total );
	}
}
