<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Widget\Module;

use EPIC\Module\ModuleManager;

Class RegisterModuleWidget {
	/**
	 * @var RegisterModuleWidget
	 */
	private static $instance;

	/**
	 * @return RegisterModuleWidget
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
		include EPIC_DIR . 'includes/class/Widget/Module/module-widget.php';
		add_action( 'widgets_init', array( $this, 'register_widget_module' ) );

		add_action( 'dynamic_sidebar_before', array( $this, 'begin_render_widget' ) );
		add_action( 'dynamic_sidebar_after', array( $this, 'normalize_widget_size' ) );
	}

	// assume widget size is 4 column
	public function begin_render_widget() {
		ModuleManager::getInstance()->force_set_width( 4 );
	}

	public function normalize_widget_size() {
		ModuleManager::getInstance()->normalize_width();
	}

	public function register_widget_module() {
		$manager = ModuleManager::getInstance();
		$modules = $manager->populate_module();

		foreach ( $modules as $module ) {
			if ( $module['widget'] ) {
				$module_widget = $this->widget_name( $module );
				register_widget( $module_widget );
			}
		}
	}

	public function widget_name( $module ) {
		return $module['name'] . '_Widget';
	}
}