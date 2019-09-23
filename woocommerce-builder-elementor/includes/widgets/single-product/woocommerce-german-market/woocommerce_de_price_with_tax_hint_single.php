<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_de_price_with_tax_hint_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'woocommerce-de-price-with-tax-hint-single';
	}

	public function get_title() {
		return esc_html__( 'German Market: print tax hint', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'print tax hint' , 'product' , 'single product', 'German Market' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		if( get_post_type() == 'product' && class_exists('WGM_Template') ){
			WGM_Template::woocommerce_de_price_with_tax_hint_single();
		}
	}
	

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_de_price_with_tax_hint_Widget());