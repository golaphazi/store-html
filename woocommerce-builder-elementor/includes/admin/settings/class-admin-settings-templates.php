<?php

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'DTWCBE_Settings_Templates', false ) ) {
	return new DTWCBE_Settings_Templates();
}

/**
 * WC_Admin_Settings_General.
 */
class DTWCBE_Settings_Templates extends DTWCBE_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'templates';
		$this->label = esc_html__( 'All Templates', 'woocommerce-builder-elementor' );

		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_templates() {

		$templates = 'All Templates';
		
		$typenow = 'dtwcbe_woo_library';
		
		ob_start();
		
		include( ABSPATH . 'wp-admin/edit.php' );
		
		$templates .= ob_get_clean();
		
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

return new DTWCBE_Settings_Templates();
