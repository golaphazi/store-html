<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Widget;

use EPIC\Module\ModuleOptionAbstract;

abstract class WidgetAbstract extends \WP_Widget {
	/**
	 * @var ModuleOptionAbstract
	 */
	protected $option_instance;

	public function __construct( $id_base = false, $name, $widget_options = array(), $control_options = array() ) {
		$widget_options['customize_selective_refresh'] = true;
		parent::__construct( $id_base, $name, $widget_options, $control_options );
	}

	public function get_default_group() {
		return esc_html__( 'General', 'epic-ne' );
	}
}
