<?php
namespace ElementPack\Modules\BusinessHours\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Business_Hours extends Widget_Base {

	//protected $_has_template_content = false;

	public function get_name() {
		return 'bdt-business-hours';
	}

	public function get_title() {
		return esc_html__( 'Business Hours', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-columns';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_business_days_layout',
			[
				'label' => esc_html__( 'Business Days & Times', 'bdthemes-element-pack' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'enter_day',
			[
				'label'       => esc_html__( 'Enter Day', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Monday',
			]
		);

		$repeater->add_control(
			'enter_time',
			[
				'label'       => esc_html__( 'Enter Time', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '10:00 AM - 6:00 PM',
			]
		);

		$repeater->add_control(
			'current_styling_heading',
			[
				'label'     => esc_html__( 'Styling', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'highlight_this',
			[
				'label'        => esc_html__( 'Style This Day', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			]
		);

		$repeater->add_control(
			'single_business_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'default'   => '#db6159',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .bdt-business-day-off' => 'color: {{VALUE}}',
				],
				'condition' => [
					'highlight_this' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'single_business_timing_color',
			[
				'label'     => esc_html__( 'Time Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'default'   => '#db6159',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .bdt-business-time-off' => 'color: {{VALUE}}',
				],
				'condition' => [
					'highlight_this' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'single_business_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-business-hours-inner {{CURRENT_ITEM}}.border-divider' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'highlight_this' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'business_days_times',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => array_values( $repeater->get_controls() ),
				'default'     => [
					[
						'enter_day'  => esc_html__( 'Monday', 'bdthemes-element-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'bdthemes-element-pack' ),
					],
					[
						'enter_day'  => esc_html__( 'Tuesday', 'bdthemes-element-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'bdthemes-element-pack' ),
					],
					[
						'enter_day'  => esc_html__( 'Wednesday', 'bdthemes-element-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'bdthemes-element-pack' ),
					],
					[
						'enter_day'  => esc_html__( 'Thursday', 'bdthemes-element-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'bdthemes-element-pack' ),
					],
					[
						'enter_day'  => esc_html__( 'Friday', 'bdthemes-element-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'bdthemes-element-pack' ),
					],
					[
						'enter_day'      => esc_html__( 'Saturday', 'bdthemes-element-pack' ),
						'enter_time'     => esc_html__( '10:00 AM - 6:00 PM', 'bdthemes-element-pack' ),
					],
					[
						'enter_day'      => esc_html__( 'Sunday', 'bdthemes-element-pack' ),
						'enter_time'     => esc_html__( 'Closed', 'bdthemes-element-pack' ),
						'highlight_this' => esc_html__( 'yes', 'bdthemes-element-pack' ),
					],
				],
				'title_field' => '{{{ enter_day }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_bs_general',
			[
				'label' => esc_html__( 'General', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_bs_list_padding',
			[
				'label'      => esc_html__( 'Row Spacing', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => ['top' => 5, 'right' => 5, 'bottom' => 5, 'left' => 5],
				'selectors'  => [
					'{{WRAPPER}} div.bdt-business-hours-inner div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_bs_divider',
			[
				'label' => esc_html__( 'Divider', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'day_divider',
			[
				'label'        => esc_html__( 'Divider', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'day_divider_style',
			[
				'label'     => esc_html__( 'Style', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'solid'  => esc_html__( 'Solid', 'bdthemes-element-pack' ),
					'dotted' => esc_html__( 'Dotted', 'bdthemes-element-pack' ),
					'dashed' => esc_html__( 'Dashed', 'bdthemes-element-pack' ),
				],
				'default'   => 'solid',
				'selectors' => [
					'{{WRAPPER}} .bdt-business-hours div.bdt-business-hours-inner div.border-divider:not(:first-child)' => 'border-top-style: {{VALUE}};',
				],
				'condition' => [
					'day_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'day_divider_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e8e8e8',
				'selectors' => [
					'{{WRAPPER}} .bdt-business-hours div.bdt-business-hours-inner div.border-divider:not(:first-child)' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'day_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'day_divider_weight',
			[
				'label'     => esc_html__( 'Weight', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-business-hours div.bdt-business-hours-inner div.border-divider:not(:first-child)' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'day_divider' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_business_day_style',
			[
				'label' => esc_html__( 'Day and Time', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bs_note_heading',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => sprintf( '<p style="font-size: 12px;font-style: italic;line-height: 1.4;color: #a4afb7;">%s</p>', esc_html__( 'Note: By default, the color & typography options will inherit from parent styling. If you wish you can override that styling from here.', 'bdthemes-element-pack' ) ),
			]
		);

		$this->add_responsive_control(
			'business_hours_day_align',
			[
				'label'     => esc_html__( 'Day Alignment', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} div.bdt-business-hours-inner .heading-date' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'business_hours_time_align',
			[
				'label'     => esc_html__( 'Time Alignment', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} div.bdt-business-hours-inner .heading-time' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'business_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-business-day' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-widget-container' => 'overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Day Typography', 'bdthemes-element-pack' ),
				'name'     => 'business_day_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .heading-date',
			]
		);

		$this->add_control(
			'business_timing_color',
			[
				'label'     => esc_html__( 'Time Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-business-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Time Typography', 'bdthemes-element-pack' ),
				'name'     => 'business_timings_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .heading-time',
			]
		);

		$this->add_control(
			'business_hours_striped',
			[
				'label'        => esc_html__( 'Striped Effect', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'business_hours_striped_odd_color',
			[
				'label'     => esc_html__( 'Striped Odd Rows Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eaeaea',
				'selectors' => [
					'{{WRAPPER}} .border-divider:nth-child(odd)' => 'background: {{VALUE}};',
				],
				'condition' => [
					'business_hours_striped' => 'yes',
				],
			]
		);

		$this->add_control(
			'striped_effect_even',
			[
				'label'     => esc_html__( 'Striped Even Rows Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .border-divider:nth-child(even)' => 'background: {{VALUE}};',
				],
				'condition' => [
					'business_hours_striped' => 'yes',
				],
			]
		);

		$this->end_controls_section();

	}

	public function render() {
		$settings = $this->get_settings();

		?>

		<div class="bdt-business-hours">
			<?php
			if ( count( $settings['business_days_times'] ) ) {
			$count = 0;
			?>
				<div class="bdt-business-hours-inner">
					<?php
					foreach ( $settings['business_days_times'] as $item ) {
						$day_settings = $this->get_repeater_setting_key( 'enter_day', 'business_days_times', $count );
						$this->add_inline_editing_attributes( $day_settings );
						
						$time_settings = $this->get_repeater_setting_key( 'enter_time', 'business_days_times', $count );
						$this->add_inline_editing_attributes( $time_settings );

						$this->add_render_attribute( 'bdt-inner-element', 'class', 'bdt-inner bdt-grid', true );
						$this->add_render_attribute( 'bdt-inner-heading-time', 'class', 'inner-heading-time' );
						$this->add_render_attribute( 'bdt-bs-background' . $item['_id'], 'class', 'elementor-repeater-item-' . $item['_id'] );
						$this->add_render_attribute( 'bdt-bs-background' . $item['_id'], 'class', 'border-divider' );

						if ( 'yes' === $item['highlight_this'] ) {
							$this->add_render_attribute( 'bdt-bs-background' . $item['_id'], 'class', 'bdt-highlight-bg' );
						} elseif ( 'yes' === $settings['business_hours_striped'] ) {
							$this->add_render_attribute( 'bdt-bs-background' . $item['_id'], 'class', 'stripes' );
						}
						
						$this->add_render_attribute( 'bdt-highlight-day' . $item['_id'], 'class', 'heading-date bdt-width-1-2' );
						$this->add_render_attribute( 'bdt-highlight-time' . $item['_id'], 'class', 'heading-time bdt-width-1-2' );

						if ( 'yes' === $item['highlight_this'] ) {
							$this->add_render_attribute( 'bdt-highlight-day' . $item['_id'], 'class', 'bdt-business-day-off' );
							$this->add_render_attribute( 'bdt-highlight-time' . $item['_id'], 'class', 'bdt-business-time-off' );
						} else {
							$this->add_render_attribute( 'bdt-highlight-day' . $item['_id'], 'class', 'bdt-business-day' );
							$this->add_render_attribute( 'bdt-highlight-time' . $item['_id'], 'class', 'bdt-business-time' );
						}
						?>
						<div <?php echo $this->get_render_attribute_string( 'bdt-bs-background' . $item['_id'] ); ?>>
							<div <?php echo $this->get_render_attribute_string( 'bdt-inner-element' ); ?>>
								<span <?php echo $this->get_render_attribute_string( 'bdt-highlight-day' . $item['_id'] ); ?>>
									<span <?php echo $this->get_render_attribute_string( $day_settings ); ?>><?php echo esc_html($item['enter_day']); ?></span>
								</span>

								<span <?php echo $this->get_render_attribute_string( 'bdt-highlight-time' . $item['_id'] ); ?>>
									<span <?php echo $this->get_render_attribute_string( 'bdt-inner-heading-time' ); ?>>
										<span <?php echo $this->get_render_attribute_string( $time_settings ); ?>><?php echo esc_html($item['enter_time']); ?></span>
									</span>
								</span>
							</div>
						</div>
						<?php
						$count++;
					} ?>
				</div>
			<?php } ?>
		</div>

		<?php
	}

	protected function _content_template() {
		?>
		<div class="bdt-business-hours">
			<div class="bdt-business-hours-inner">
			<#  if ( settings.business_days_times ) {

					var count = 0;

					_.each( settings.business_days_times, function( item ) {

						var bdt_current_item_wrap = 'elementor-repeater-item-' + item._id;
						var bdt_bs_background;
						if ( 'yes' == item.highlight_this ) {
							bdt_bs_background = 'bdt-highlight-bg';
						} else if ( 'yes' == settings.business_hours_striped ) {
							bdt_bs_background = 'stripes';
						} else {
							bdt_bs_background = 'bs-background';
						}
						var bdt_highlight_day;
						var bdt_highlight_time;
						if ( 'yes' == item.highlight_this ) {
							bdt_highlight_day  = 'bdt-business-day-off';
							bdt_highlight_time = 'bdt-business-time-off';
						} else {
							bdt_highlight_day  = 'bdt-business-day';
							bdt_highlight_time = 'bdt-business-time';
						}

					#>
					<div class="{{ bdt_current_item_wrap }} {{ bdt_bs_background }} border-divider">
						<div class="bdt-inner bdt-grid">
							<span class="{{ bdt_highlight_day }} heading-date bdt-width-1-2">
								<span class="elementor-inline-editing" data-elementor-setting-key="business_days_times.{{ count }}.enter_day" data-elementor-inline-editing-toolbar="basic">{{ item.enter_day }}</span>
							</span>
							<span class="{{ bdt_highlight_time }} heading-time bdt-width-1-2">
							<span class="inner-heading-time">								
								<span class="elementor-inline-editing" data-elementor-setting-key="business_days_times.{{ count }}.enter_time" data-elementor-inline-editing-toolbar="basic">{{ item.enter_time }}</span>
							</span>
							</span>
						</div>
					</div>
					<#
					count++;
					});
				}
				#>
			</div>
		</div>
		<?php
	}
}
