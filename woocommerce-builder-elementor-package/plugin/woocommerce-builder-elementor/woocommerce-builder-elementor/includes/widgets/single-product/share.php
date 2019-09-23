<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Share_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'single-product-share';
	}

	public function get_title() {
		return esc_html__( 'Woo Product Share', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-share';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'share' , 'product' , 'single product' ];
	}

	protected function _register_controls() {

	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();
		$post_type = get_post_type();
		
		if ( $post_type == 'product' || $post_type == DTWCBE_Post_Types::post_type() ){
			
			echo DTWCBE_Single_Product_Elementor::_render( $this->get_name() );
			
		}else{
			
			esc_html_e('Product Share', 'woocommerce-builder-elementor' );
			
		}
		
	}
	

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Share_Widget());