<?php
namespace ElementPack\Modules\TheEventsCalendar;

use ElementPack\Base\Element_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Element_Pack_Module_Base {

	public function get_name() {
		return 'bdt-the-events-calendar';
	}

	public function get_widgets() {
		return [
			'Calendar',
		];
	}
}
