<?php
/**
 * Dashboard Jegstudio Product
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

if ( defined( 'EPIC_DASHBOARD_VERSION' ) ) {
	return;
}

defined( 'EPIC_DASHBOARD_VERSION' ) || define( 'EPIC_DASHBOARD_VERSION', '1.0.0' );
defined( 'EPIC_DASHBOARD_URL' ) || define( 'EPIC_DASHBOARD_URL', JEG_THEME_URL . '/lib/epic-dashboard' );
defined( 'EPIC_DASHBOARD_FILE' ) || define( 'EPIC_DASHBOARD_FILE', __FILE__ );
defined( 'EPIC_DASHBOARD_DIR' ) || define( 'EPIC_DASHBOARD_DIR', dirname( __FILE__ ) );
defined( 'EPIC_DASHBOARD_CLASSPATH' ) || define( 'EPIC_DASHBOARD_CLASSPATH', EPIC_DASHBOARD_DIR . '/class' );

add_action( 'after_setup_theme', 'epic_dashboard_initialize', 11 );

require_once 'autoload.php';

/**
 * Epic dashboard initializer
 */
if ( ! function_exists( 'epic_dashboard_initialize' ) ) {
	function epic_dashboard_initialize() {
		if ( is_admin() ) {
			new EPIC\Dashboard\Init();
		}
	}	
}

/**
 * Register activation hook
 *
 * @param string $file Plugin file path.
 */
if ( ! function_exists( 'epic_activation_hook' ) ) {
	function epic_activation_hook( $file ) {
		register_activation_hook( $file, 'epic_redirect_activation_hook' );
	}	
}

/**
 * Redirect activation hook
 */
if ( ! function_exists( 'epic_redirect_activation_hook' ) ) {
	function epic_redirect_activation_hook() {
		set_transient( '_dashboard_redirect', 1, 30 );
	}
}

add_action( 'admin_init', 'epic_dashboard_redirect' );

/**
 * Epic Dashboard Redirect
 */
if ( ! function_exists( 'epic_dashboard_redirect' ) ) {
	function epic_dashboard_redirect() {
		$redirect = get_transient( '_dashboard_redirect' );
		delete_transient( '_dashboard_redirect' );
		$redirect && wp_safe_redirect( admin_url( 'admin.php?page=epic' ) );
	}
}

if ( ! function_exists( 'jeg_sanitize_output' ) ) {
	function jeg_sanitize_output( $output ) {
		return $output;
	}
}
