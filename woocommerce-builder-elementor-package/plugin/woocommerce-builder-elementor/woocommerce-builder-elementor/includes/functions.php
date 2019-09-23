<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if( !function_exists('dtwcbe_get_last_order_id') ){
	function dtwcbe_get_last_order_id(){
		global $wpdb;
		$statuses = array_keys(wc_get_order_statuses());
		$statuses = implode( "','", $statuses );
	
		// Getting last Order ID (max value)
		$results = $wpdb->get_col( "
			SELECT MAX(ID) FROM {$wpdb->prefix}posts
			WHERE post_type LIKE 'shop_order'
			AND post_status IN ('$statuses')
			" );
			return reset($results);
	}
}