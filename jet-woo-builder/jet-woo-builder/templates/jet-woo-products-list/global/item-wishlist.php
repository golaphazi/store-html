<?php
/**
 * Loop item tags
 */

$settings = $this->get_settings();

if( isset( $settings['show_wishlist'] ) ){
	if ( 'yes' === $settings['show_wishlist'] ) {
		do_action( 'jet-woo-builder/templates/jet-woo-products-list/wishlist-button', $settings );
	}
}
