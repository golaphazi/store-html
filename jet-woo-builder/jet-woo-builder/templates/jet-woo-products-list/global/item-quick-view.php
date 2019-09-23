<?php
/**
 * Loop item tags
 */

$settings = $this->get_settings();

if( isset( $settings['show_quickview'] ) ){
	if ( 'yes' === $settings['show_quickview'] ) {
		do_action( 'jet-woo-builder/templates/jet-woo-products-list/quickview-button', $settings );
	}
}
