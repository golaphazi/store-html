<?php
defined( 'ABSPATH' ) || exit;

/**
 * Plugin Name: MetWoo – Most flexible and design friendly Woocomerce builder for Elementor
 * Plugin URI:  http://products.wpmet.com/metform
 * Description: Most flexible and design friendly Woocomerce  builder for Elementor
 * Version: 1.0.0
 * Author: WpMet
 * Author URI:  https://wpmet.com
 * Text Domain: metwoo
 * License:  GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

 // autoload class         
require_once 'autoloader.php';
// load plugin main file
require_once 'plugin.php';

// load hook for post url flush rewrites
register_activation_hook( __FILE__, [ MetWoo\Plugin::instance(), 'flush_rewrites'] );

// load plugin
add_action( 'plugins_loaded', function(){
	// action plugin instance class
	MetWoo\Plugin::instance()->init();
});

