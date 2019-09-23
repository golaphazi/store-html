<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Purchasing_Discount_Message_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'single-product-purchasing-discount-message';
	}

	public function get_title() {
		return esc_html__( 'Woo Memberships: Product Purchasing Discount', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'Purchasing Discount' , 'product' , 'single product' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		// WC_Memberships_Products_Restrictions->display_product_purchasing_discount_message
		if( !is_product() ) { return ''; }
		global $post, $product;
		
		ob_start();

		if ( $product instanceof \WC_Product ) {
		
			$user_id = get_current_user_id();
			$args    = array(
				'post'      => $post && in_array( $post->post_type, array( 'product', 'product_variation' ), true ) ? $post : get_post( $product ),
				'rule_type' => 'purchasing_discount',
			);
		
			// if the main/parent product needs the message, just display it normally
			if (      wc_memberships_product_has_member_discount( $product )
				&& ! wc_memberships_user_has_member_discount( $product, $user_id ) ) {
		
					echo \WC_Memberships_User_Messages::get_message_html( 'product_discount', $args );
		
					// if this is a variable product, set the messages up for display per-variation
				} elseif ( $product->is_type( 'variable' ) && $product->has_child() ) {
		
					unset( $args['post'] );
		
					$variations_discounted = false;
		
					/* @type \WC_Product_Variable $product */
					foreach ( $product->get_children() as $variation_id ) {
		
						if (      wc_memberships_product_has_member_discount( $variation_id )
							&& ! wc_memberships_user_has_member_discount( $variation_id, $user_id ) ) {
		
								$args['post_id']       = (int) $variation_id;
								$args['classes']       = array( 'wc-memberships-variation-message', 'js-variation-' . sanitize_html_class( $variation_id ) );
								$variations_discounted = true;
		
								echo WC_Memberships_User_Messages::get_message_html( 'product_discount', $args );
							}
					}
		
					if ( $variations_discounted ) {
						wc_enqueue_js( "
						jQuery( '.variations_form' )
							.on( 'woocommerce_variation_select_change', function( event ) {
								jQuery( '.wc-memberships-variation-message.wc-memberships-member-discount-message' ).hide();
							} )
							.on( 'found_variation', function( event, variation ) {
								jQuery( '.wc-memberships-variation-message.wc-memberships-member-discount-message' ).hide();
								jQuery( '.wc-memberships-variation-message.wc-memberships-member-discount-message.js-variation-' + variation.variation_id ).show();
							} )
							.find( '.variations select' ).change();
					" );
					}
				}
		}
		
		echo ob_get_clean();
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Purchasing_Discount_Message_Widget());