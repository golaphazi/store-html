<?php
/*
	Plugin Name: Epic News Elements
	Plugin URI: http://jegtheme.com/
	Description: News, magazine, blog elements for WPBakery Page Builder and Elementor plugin
	Version: 2.2.3
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
    Text Domain: epic-ne
*/

defined( 'EPIC' ) or define( 'EPIC', 'epic-news-element' );
defined( 'EPIC_VERSION' ) or define( 'EPIC_VERSION', '2.2.3' );
defined( 'EPIC_URL' ) or define( 'EPIC_URL', plugins_url( EPIC ) );
defined( 'EPIC_FILE' ) or define( 'EPIC_FILE', __FILE__ );
defined( 'EPIC_DIR' ) or define( 'EPIC_DIR', plugin_dir_path( __FILE__ ) );
defined( 'EPIC_PATH' ) or define( 'EPIC_PATH', plugin_basename( __FILE__ ) );

defined( 'JEG_FRAMEWORK' ) or define( 'JEG_FRAMEWORK', 'jeg_customizer_framework' );
defined( 'JEG_THEME_URL' ) or define( 'JEG_THEME_URL', EPIC_URL );

require_once EPIC_DIR . 'lib/jeg-framework/bootstrap.php';
require_once EPIC_DIR . 'lib/epic-dashboard/bootstrap.php';
require_once EPIC_DIR . 'includes/autoload.php';

EPIC\Init::getInstance();
