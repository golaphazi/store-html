<?php
/**
 * Plugins Class
 *
 * @author Jegstudio
 * @license https://opensource.org/licenses/MIT
 * @package epic-dashboard
 */

namespace EPIC\Dashboard;

/**
 * Class Plugin
 *
 * @package EPIC\Dashboard
 */
class Plugins {
	/**
	 * Plugin List
	 *
	 * @var array
	 */
	private $plugins;

	/**
	 * Instance of plugin
	 *
	 * @var Plugins
	 */
	private static $instance;

	/**
	 * Get Instance
	 *
	 * @return Plugins
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {
		$this->setup_plugins();
	}

	/**
	 * Setup Plugins
	 */
	public function setup_plugins() {
		$plugins = $this->plugin_list();
		foreach ( $plugins as $plugin ) {
			$this->plugins[] = new Plugin( $plugin );
		}
	}

	/**
	 * Get All Plugin
	 *
	 * @return array
	 */
	public function get_plugins() {
		return $this->plugins;
	}

	/**
	 * Plugin list
	 *
	 * @return array
	 */
	public function plugin_list() {
		return apply_filters( 'epic_plugin_list', array() );
	}
}