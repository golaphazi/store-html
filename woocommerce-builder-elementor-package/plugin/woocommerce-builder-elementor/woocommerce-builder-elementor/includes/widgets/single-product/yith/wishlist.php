<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Yith_Wishlist_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'product-yith-wishlist';
	}

	public function get_title() {
		return esc_html__( 'YITH Add To Wishlist', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'wishlist' , 'product' , 'single product' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		echo do_shortcode('[yith_wcwl_add_to_wishlist]');
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Yith_Wishlist_Widget());