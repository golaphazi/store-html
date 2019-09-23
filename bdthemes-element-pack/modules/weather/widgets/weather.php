<?php
namespace ElementPack\Modules\Weather\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

use ElementPack\Element_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Weather extends Widget_Base {

	public function get_name() {
		return 'bdt-weather';
	}

	public function get_title() {
		return esc_html__( 'Weather', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-divider-shape';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_style_depends() {
		return ['weather'];
	}

	public function get_script_depends() {
		return [ 'weather' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_weather',
			[
				'label' => __( 'Weather', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'view',
			[
				'label'   => __( 'Layout', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'full',
				'options' => [
					'full'     => __( 'Full', 'bdthemes-element-pack' ),
					'partial'  => __( 'Partial', 'bdthemes-element-pack' ),
					'simple'   => __( 'Simple', 'bdthemes-element-pack' ),
					'today'    => __( 'Today', 'bdthemes-element-pack' ),
					'forecast' => __( 'Forecast', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'location',
			[
				'label'   => __( 'Location', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => 'Bogura',
			]
		);

		$this->add_control(
			'country',
			[
				'label'   => __( 'Country', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => 'Bangladesh',
			]
		);

		$this->add_control(
			'units',
			[
				'label'   => __( 'Units', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'metric',
				'options' => [
					'auto'     => __( 'Auto', 'bdthemes-element-pack' ),
					'metric'   => __( 'Metric', 'bdthemes-element-pack' ),
					'imperial' => __( 'Imperial', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'timeformat',
			[
				'label'   => __( 'Time Format', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '12',
				'options' => [
					'12' => __( '12', 'bdthemes-element-pack' ),
					'24' => __( '24', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'displayCityNameOnly',
			[
				'label'   => __( 'Hide Country Name', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'forecast',
			[
				'label' => __( 'Forecast', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'default' => [
					'size' => 5,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_weather',
			[
				'label' => __( 'Weather', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 25,
					'bottom' => 25,
					'left'   => 25,
					'right'  => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-weather' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Title', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-weather h2' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-weather h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-weather h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-weather h2',
			]
		);

		$this->add_control(
			'title_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather h2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'title_shadow',
				'selector' => '{{WRAPPER}} .bdt-weather h2',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-weather h2',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_unit',
			[
				'label' => __( 'Unit', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'unit_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .wiMax' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .wiMin' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'unit_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'unit_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'unit_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'unit_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-weather .wiTemperature',
			]
		);

		$this->add_control(
			'unit_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'unit_shadow',
				'selector' => '{{WRAPPER}} .bdt-weather .wiTemperature',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'unit_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-weather .wiTemperature',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .wiForecast .wi:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .astronomy .wi:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .atmosphere .wi:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-weather .wiIconGroup',
			]
		);

		$this->add_control(
			'icon_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-weather .wiIconGroup',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'icon_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-weather .wiIconGroup',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_days',
			[
				'label' => __( 'Days', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'days_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiDetail .wiDay, {{WRAPPER}} .bdt-weather .wiDay span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'days_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiDay span' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'days_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-weather .wiDetail .wiDay, {{WRAPPER}} .bdt-weather .wiDay span',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$id       = $this->get_id();
		$settings = $this->get_settings();
		$lang     = get_bloginfo('language');
		$lang     = strtoupper(substr($lang, 0, 2));
		?>
		<div class="bdt-weather" id="bdt-weather-<?php echo esc_attr($id); ?>">
			<div></div>		
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var bdt_weather = $("#bdt-weather-<?php echo esc_attr($id); ?> > div").flatWeatherPlugin({
		            location: "<?php echo esc_attr($settings['location']); ?>", 
		            country: "<?php echo esc_attr($settings['country']); ?>",     
		            view : "<?php echo esc_attr($settings['view']); ?>", 
		            timeformat: <?php echo esc_attr($settings['timeformat']); ?>, 
		            displayCityNameOnly : <?php echo ( $settings['displayCityNameOnly'] ) ? 'true' : 'false' ?>,
		            forecast: <?php echo esc_attr($settings['forecast']['size']); ?>, 
		            units : "<?php echo esc_attr($settings['units']); ?>", 
		            lang: "<?php echo esc_attr($lang); ?>",
				});
			});
		</script>
		<?php
	}
}
