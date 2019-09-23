<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Purchasing_Restricted_Message_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'single-product-purchasing-restricted-message';
	}

	public function get_title() {
		return esc_html__( 'Woo Memberships: Product Purchasing Restricted', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'Purchasing restricted' , 'product' , 'single product' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		// WC_Memberships_Products_Restrictions->display_product_purchasing_restricted_message
		if( !is_product() ) { return ''; }
		global $product;
		
		ob_start();
		
		if ( $product instanceof \WC_Product ) {
	
			$product_id = $product instanceof \WC_Product ? $product->get_id() : 0;
			$args       = array( 'post_id' => $product_id );

			if ( ! current_user_can( 'wc_memberships_purchase_restricted_product', $product_id ) ) {

				// purchasing is restricted
				echo \WC_Memberships_User_Messages::get_message_html( 'product_purchasing_restricted', $args );

			} elseif ( ! current_user_can( 'wc_memberships_purchase_delayed_product', $product_id ) ) {

				$args['access_time'] = wc_memberships()->get_capabilities_instance()->get_user_access_start_time_for_post( get_current_user_id(), $product_id, 'purchase' );

				// purchasing is delayed
				echo \WC_Memberships_User_Messages::get_message_html( 'product_access_delayed', $args );

			} elseif ( $product->is_type( 'variable' ) && $product->has_child() ) {

				// variation-specific messages
				$variations_restricted = false;

				/* @type \WC_Product_Variable $product */
				foreach ( $product->get_available_variations() as $variation ) {

					if ( ! $variation['is_purchasable'] ) {

						$variation_id    = (int) $variation['variation_id'];
						$args['classes'] = array( 'wc-memberships-variation-message', 'js-variation-' . sanitize_html_class( $variation_id ) );
						$args['post_id'] = $variation_id;

						if ( ! current_user_can( 'wc_memberships_purchase_restricted_product', $variation_id ) ) {

							$variations_restricted = true;

							// purchasing is restricted
							echo \WC_Memberships_User_Messages::get_message_html( 'product_purchasing_restricted', $args );

						} elseif ( ! current_user_can( 'wc_memberships_purchase_delayed_product', $variation['variation_id'] ) ) {

							$args['access_time']   = wc_memberships()->get_capabilities_instance()->get_user_access_start_time_for_post( get_current_user_id(), $product_id, 'purchase' );
							$variations_restricted = true;

							// purchasing is delayed
							echo \WC_Memberships_User_Messages::get_message_html( 'product_access_delayed', $args );
						}
					}
				}

				if ( $variations_restricted ) {
					wc_enqueue_js( "
						jQuery( '.variations_form' )
							.on( 'woocommerce_variation_select_change', function( event ) {
								jQuery( '.wc-memberships-variation-message' ).hide();
							} )
							.on( 'found_variation', function( event, variation ) {
								jQuery( '.wc-memberships-variation-message' ).hide();
								if ( ! variation.is_purchasable ) {
									jQuery( '.wc-memberships-variation-message.js-variation-' + variation.variation_id ).show();
								}
							} )
							.find( '.variations select' ).change();
					" );
				}
			}
		}
		
		
		echo ob_get_clean();
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Purchasing_Restricted_Message_Widget());