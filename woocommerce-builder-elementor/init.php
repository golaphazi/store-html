<?php
/**
* Plugin Name: DT WooCommerce Page Builder For Elementor
* Plugin URI: http://dawnthemes.com/
* Description: is the ideal Elementor add-on to effortlessly layout for WooCommerce and more.
* Version: 1.1.4
* Author: DawnThemes 
* Author URI: http://dawnthemes.com/
* Copyright @2019 by DawnThemes
* License: License GNU General Public License version 2 or later
* Text-domain: woocommerce-builder-elementor
* WC tested up to: 3.5.7
* 
* @package WooCommerce-Builder-Elementor
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define
define( 'DTWCBE_VERSION', '1.1.4' );

define( 'DTWCBE__FILE__', __FILE__ );
define( 'DTWCBE_PLUGIN_BASE', plugin_basename( DTWCBE__FILE__ ) );
define( 'DTWCBE_PATH', plugin_dir_path( DTWCBE__FILE__ ) );
define( 'DTWCBE_PATH_URL' , plugin_dir_url( DTWCBE__FILE__ ));
define( 'DTWCBE_URL', plugins_url( '/', DTWCBE__FILE__ ) );

define( 'DTWCBE_MODULES_PATH', plugin_dir_path( DTWCBE__FILE__ ) . 'modules' );
define( 'DTWCBE_ASSETS_PATH', DTWCBE_URL . 'assets/' );
define( 'DTWCBE_ASSETS_URL', DTWCBE_URL . 'assets/' );


// Include the main DTWCBE_WooCommerce_Builder_Elementor class.
if( !class_exists('DTWCBE_WooCommerce_Builder_Elementor') ){
	include_once dirname( __FILE__ ) . '/includes/class-woocommerce-builder-elementor.php';
}

/**
 * Main instance of DTWCBE_WooCommerce_Builder_Elementor.
 *
 * Returns the main instance of DTWCBE to prevent the need to use globals.
 *
 * @since  1.0
 * @return DTWCBE_WooCommerce_Builder_Elementor
 */
function dtwcbe() {
	return DTWCBE_WooCommerce_Builder_Elementor::instance();
}

// Global for backwards compatibility.
$GLOBALS['dtwcbe'] = dtwcbe();
