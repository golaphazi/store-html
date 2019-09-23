<?php
namespace ElementPack\Modules\TestimonialGrid;

use ElementPack\Base\Element_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

class Module extends Element_Pack_Module_Base {

	public function get_name() {
		return 'testimonial-grid';
	}

	public function get_widgets() {

		$widgets = [
			'Testimonial_Grid',
		];

		return $widgets;
	}
}
