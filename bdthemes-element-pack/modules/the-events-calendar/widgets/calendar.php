<?php
namespace ElementPack\Modules\TheEventsCalendar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Calendar extends Widget_Base {

	public function get_name() {
		return 'bdt-calendar';
	}

	public function get_title() {
		return esc_html__( 'Calendar', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-table';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_woocommerce_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);
	}

	private function get_shortcode() {
		$settings = $this->get_settings();

		/*if (!$settings['contact_form']) {
			return '<div class="bdt-alert bdt-alert-warning">'.__('Please select a Contact Form From Setting!', 'bdthemes-element-pack').'</div>';
		}

		$attributes = [
			'id'	=> $settings['contact_form'],
		];

		$this->add_render_attribute( 'shortcode', $attributes );*/

		$shortcode   = [];
		$shortcode[] = sprintf( '[tribe_events view="day"]' );

		return implode("", $shortcode);
	}

	public function render() {
		echo do_shortcode( $this->get_shortcode() );
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
		
}
