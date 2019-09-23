<?php

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'DTWCBE_Settings_Products', false ) ) {
	return new DTWCBE_Settings_Products();
}

/**
 * WC_Admin_Settings_General.
 */
class DTWCBE_Settings_Products extends DTWCBE_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'product';
		$this->label = esc_html__( 'Single Product', 'woocommerce-builder-elementor' );

		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_templates() {
		
		$templates = 'Product';
		
		return $templates;

	}

	/**
	 * Output the templates.
	 */
	public function output() {
		$templates = $this->get_templates();

		DTWCBE_Admin_Settings::output_templates( $templates );
	}
}

return new DTWCBE_Settings_Products();
