<?php

use Elementor\Controls_Manager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Jet_Woo_Builder_Shop_Document extends Jet_Woo_Builder_Document_Base {

	/**
	 * @access public
	 */
	public function get_name() {
		return 'jet-woo-builder-shop';
	}

	/**
	 * @access public
	 * @static
	 */
	public static function get_title() {
		return __( 'Jet Woo Shop Template', 'jet-woo-builder' );
	}

	public function get_preview_as_query_args() {

		jet_woo_builder()->documents->set_current_type( $this->get_name() );

		$args = array();

		$products = get_posts( array(
			'post_type'      => 'product',
			'posts_per_page' => 5,
		) );

		if ( ! empty( $products ) ) {

			$args = array(
				'post_type' => 'product',
				'p'         => $products,
			);

		}

		wc_set_loop_prop( 'total', 20 );
		wc_set_loop_prop( 'total_pages', 3 );

		return $args;

	}

}