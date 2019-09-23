<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Legal_Info_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'single-product-legal-info';
	}

	public function get_title() {
		return esc_html__( 'Woo Germanized Legal Info', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'legal info' , 'product' , 'single product' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		if( function_exists('woocommerce_gzd_template_single_legal_info') ){
			woocommerce_gzd_template_single_legal_info();
		}
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Legal_Info_Widget());