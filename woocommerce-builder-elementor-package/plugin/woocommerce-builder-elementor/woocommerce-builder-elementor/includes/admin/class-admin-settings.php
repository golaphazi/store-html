<?php

class DTWCBE_Admin_Settings{
	
	/**
	 * Setting pages.
	 *
	 * @var array
	 */
	private static $settings = array();

	/**
	 * Error messages.
	 *
	 * @var array
	 */
	private static $errors = array();

	/**
	 * Update messages.
	 *
	 * @var array
	 */
	private static $messages = array();

	/**
	 * Include the settings page classes.
	 */
	public static function get_settings_pages() {
		if ( empty( self::$settings ) ) {
			$settings = array();

			include_once dirname( __FILE__ ) . '/settings/class-admin-settings-page.php';

			$settings[] = include 'settings/class-admin-settings-templates.php';
			$settings[] = include 'settings/class-admin-settings-product.php';

		}

		return self::$settings;
	}
	
	/**
	 * Add a message.
	 *
	 * @param string $text Message.
	 */
	public static function add_message( $text ) {
		self::$messages[] = $text;
	}
	
	/**
	 * Add an error.
	 *
	 * @param string $text Message.
	 */
	public static function add_error( $text ) {
		self::$errors[] = $text;
	}
	
	/**
	 * Output messages + errors.
	 */
	public static function show_messages() {
		if ( count( self::$errors ) > 0 ) {
			foreach ( self::$errors as $error ) {
				echo '<div id="message" class="error inline"><p><strong>' . esc_html( $error ) . '</strong></p></div>';
			}
		} elseif ( count( self::$messages ) > 0 ) {
			foreach ( self::$messages as $message ) {
				echo '<div id="message" class="updated inline"><p><strong>' . esc_html( $message ) . '</strong></p></div>';
			}
		}
	}
	
	public static function output() {
		global $dtwcbe_current_tab;
		echo 'adsfsdf';
		// Get tabs for the settings page.
		$tabs = apply_filters( 'woocommerce_builder_elementor_settings_tabs_array', array() );
		
		include dirname( __FILE__ ) . '/views/html-admin-settings.php';
	}
	
	public static function output_templates( $templates ) {
		echo ( $templates ) ? $templates : '';
	}

	
}