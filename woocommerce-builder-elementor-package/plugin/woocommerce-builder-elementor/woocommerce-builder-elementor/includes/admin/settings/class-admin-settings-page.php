<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC_Settings_Page.
 */
abstract class DTWCBE_Settings_Page {
	
	/**
	 * Setting page id.
	 *
	 * @var string
	 */
	protected $id = '';
	
	/**
	 * Setting page label.
	 *
	 * @var string
	 */
	protected $label = '';
	
	public function __construct() {
		add_filter( 'woocommerce_builder_elementor_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'woocommerce_builder_elementor_settings_' . $this->id, array( $this, 'output' ) );
	}
	
	public function get_id() {
		return $this->id;
	}
	
	public function get_label() {
		return $this->label;
	}
	
	public function add_settings_page( $pages ) {
		$pages[ $this->id ] = $this->label;
	
		return $pages;
	}
	
	public function get_templates() {
		return apply_filters( 'woocommerce_builder_elementor_get_templates_' . $this->id, array() );
	}
	
	public function output() {
		$templates = $this->get_templates();
	
		DTWCBE_Admin_Settings::output_templates( $templates );
	}

}
