<?php
namespace ElementPack\Modules\Elementor;

use Elementor;
use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use ElementPack\Base\Element_Pack_Module_Base;
use ElementPack\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Element_Pack_Module_Base {

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}


	public function get_name() {
		return 'bdt-elementor';
	}

	public function get_script_depends() {
		return [ 'particles' ];
	}

	public function register_controls_bg_parallax($section, $section_id, $args) {

		static $bg_sections = [ 'section_background' ];

		if ( !in_array( $section_id, $bg_sections ) ) { return; }
		
		$section->add_control(
			'section_parallax_on',
			[
				'label'        => esc_html__( 'Enable Parallax', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => esc_html__( 'Set parallax background by enable this option.', 'bdthemes-element-pack' ),
				'separator'    => 'before',
				'condition'    => [
					'background_background' => ['classic'],
				],
			]
		);

		$section->add_control(
			'section_parallax_value',
			[
				'label'        => esc_html__( 'Parallax Amount', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'steps' => 10,
					],
				],
				'default' => [
					'size' => -200,
				],
				'description'  => esc_html__( 'How much parallax move happen on scroll.', 'bdthemes-element-pack' ),
				'condition'    => [
					'section_parallax_on' => 'yes',
				],
			]
		);

	}

	public function register_controls_sticky($section, $section_id, $args) {

		static $layout_sections = [ 'section_layout'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }
		

		$section->start_controls_section(
			'section_sticky_controls',
			[
				'label' => __( 'Sticky Options', 'bdthemes-element-pack' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);


		$section->add_control(
			'section_sticky_on',
			[
				'label'        => esc_html__( 'Enable Sticky', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'description'  => esc_html__( 'Set sticky options by enable this option.', 'bdthemes-element-pack' ),
			]
		);

		$section->add_control(
			'section_sticky_offset',
			[
				'label'   => esc_html__( 'Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
					],
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_active_bg',
			[
				'label'     => esc_html__( 'Active Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.bdt-sticky.bdt-active' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Active Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.bdt-sticky.bdt-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_animation',
			[
				'label'     => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => element_pack_transition_options(),
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_bottom',
			[
				'label' => esc_html__( 'Scroll Until', 'bdthemes-element-pack' ),
				'description'  => esc_html__( 'If you don\'t want to scroll after specific section so set that section ID/CLASS here. for example: #section1 or .section1 it\'s support ID/CLASS', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_on_scroll_up',
			[
				'label'        => esc_html__( 'Sticky on Scroll Up', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'description'  => esc_html__( 'Set sticky options when you scroll up your mouse.', 'bdthemes-element-pack' ),
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);


		$section->add_control(
			'section_sticky_off_media',
			[
				'label'       => __( 'Turn Off', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'options' => [
					'960' => [
						'title' => __( 'On Tablet', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-tablet',
					],
					'768' => [
						'title' => __( 'On Mobile', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-mobile',
					],
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$section->end_controls_section();

	}

	public function register_controls_particles($section, $section_id, $args) {

		static $bg_sections = [ 'section_background' ];

		if ( !in_array( $section_id, $bg_sections ) ) { return; }

		$section->add_control(
			'section_particles_on',
			[
				'label'        => esc_html__( 'Enable Particles', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => __( 'Switch on to enable Particles options! Note that currently particles are not visible in edit/preview mode for better elementor performance. It\'s only can viewed on the frontend. <b>Z-Index Problem: set column z-index 1 so particles will set behind the content.</b>', 'bdthemes-element-pack' ),
			]
		);
		
		$section->add_control(
			'section_particles_js',
			[
				'label' => esc_html__( 'Particles JSON', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::TEXTAREA,
				'condition' => [
					'section_particles_on' => 'yes',
				],
				'description' => __( 'Paste your particles JSON code here - Generate it from <a href="http://vincentgarreau.com/particles.js/#default" target="_blank">Here</a>.', 'bdthemes-element-pack' ),
				'default' => '',
			]
		);

	}


	public function register_controls_scheduled($section, $section_id, $args) {

		static $layout_sections = [ 'section_layout'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }

		// Schedule content controls
		$section->start_controls_section(
			'section_scheduled_content_controls',
			[
				'label' => __( 'Schedule Content', 'bdthemes-element-pack' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);
		
		$section->add_control(
			'section_scheduled_content_on',
			[
				'label'        => __( 'Schedule Content?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => __( 'Switch on to schedule the contents of this column|section!.', 'bdthemes-element-pack' ),
			]
		);
		
		$section->add_control(
			'section_scheduled_content_start_date',
			[
				'label' => __( 'Start Date', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => '2018-02-01 00:00:00',
				'condition' => [
					'section_scheduled_content_on' => 'yes',
				],
				'description' => __( 'Set start date for show this section.', 'bdthemes-element-pack' ),
			]
		);
		
		$section->add_control(
			'section_scheduled_content_end_date',
			[
				'label' => __( 'End Date', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => '2018-02-28 00:00:00',
				'condition' => [
					'section_scheduled_content_on' => 'yes',
				],
				'description' => __( 'Set end date for hide the section.', 'bdthemes-element-pack' ),
			]
		);

		$section->end_controls_section();

	}

	public function register_controls_parallax($section, $section_id, $args) {

		static $style_sections = [ 'section_background'];

		if ( ! in_array( $section_id, $style_sections ) ) { return; }

		// Schedule content controls
		$section->start_controls_section(
			'section_parallax_content_controls',
			[
				'label' => __( 'Parallax', 'bdthemes-element-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$section->add_control(
			'section_parallax_elements',
			[
				'label'   => __( 'Parallax Items', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name'        => 'section_parallax_title',
						'label'       => __( 'Title', 'bdthemes-element-pack' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => __( 'Parallax 1' , 'bdthemes-element-pack' ),
						'label_block' => true,
						'render_type' => 'ui',
					],
					[
						'name'      => 'section_parallax_image',
						'label'     => esc_html__( 'Image', 'bdthemes-element-pack' ),
						'type'      => Controls_Manager::MEDIA,
						//'condition' => [ 'parallax_content' => 'parallax_image' ],
					],
					[
						'name'    => 'section_parallax_depth',
						'label'   => __( 'Depth', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::NUMBER,
						'default' => 0.1,
						'min'     => 0,
						'max'     => 1,
						'step'    => 0.1,
					],
					[
						'name'    => 'section_parallax_bgp_x',
						'label'   => __( 'Image X Position', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::NUMBER,
						'min'     => 0,
						'max'     => 100,
						'default' => 50,
					],
					[
						'name'    => 'section_parallax_bgp_y',
						'label'   => __( 'Image Y Position', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::NUMBER,
						'min'     => 0,
						'max'     => 100,
						'default' => 50,
					],
					[
						'name'    => 'section_parallax_bg_size',
						'label'   => __( 'Image Size', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'cover',
						'options' => [
							'auto'    => __( 'Auto', 'bdthemes-element-pack' ),
							'cover'   => __( 'Cover', 'bdthemes-element-pack' ),
							'contain' => __( 'Contain', 'bdthemes-element-pack' ),
						],
					],		
									
				],
				'title_field' => '{{{ section_parallax_title }}}',
			]
		);


		$section->add_control(
			'section_parallax_mode',
			[
				'label'   => esc_html__( 'Parallax Mode', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''         => esc_html__( 'Relative', 'bdthemes-element-pack' ),
					'clip'     => esc_html__( 'Clip', 'bdthemes-element-pack' ),
					'hover'    => esc_html__( 'Hovar (Mobile also turn off)', 'bdthemes-element-pack' ),
				],
			]
		);
		

		$section->end_controls_section();

	}


	public function register_controls_widget_parallax($widget, $widget_id, $args) {
		static $widgets = [
			'_section_style', /* Section */
		];

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$widget->add_control(
			'_widget_parallax_on',
			[
				'label'        => esc_html__( 'Enable Parallax', 'bdthemes-element-pack' ),
				'description'  => esc_html__( 'Enable parallax for this element set below option after switch yes.', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'separator'    => 'before',
			]
		);

		$widget->add_control(
			'_widget_parallax_x_value',
			[
				'label'       => esc_html__( 'Parallax X', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'If you need to parallax horizontally (x direction) so use this.', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -200,
						'max'   => 200,
						'steps' => 10,
					],
				],
				'condition'    => [
					'_widget_parallax_on' => 'yes',
				],
			]
		);

		$widget->add_control(
			'_widget_parallax_y_value',
			[
				'label'       => esc_html__( 'Parallax Y', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'If you need to parallax vertically (y direction) so use this.', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -200,
						'max'   => 200,
						'steps' => 10,
					],
				],
				'default' => [
					'size' => 50,
				],
				'condition'    => [
					'_widget_parallax_on' => 'yes',
				],
			]
		);

		$widget->add_control(
			'_widget_parallax_viewport_value',
			[
				'label'       => esc_html__( 'ViewPort Start', 'bdthemes-element-pack' ),
				'description' => esc_html__('Animation range depending on the viewport.', 'bdthemes-element-pack'),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0.2,
				],
				'condition'    => [
					'_widget_parallax_on' => 'yes',
				],
			]
		);

		$widget->add_control(
			'_widget_parallax_opacity_value',
			[
				'label'   => esc_html__( 'Opacity', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'This option set your element opacity when happen the parallax.', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0,1',
				'options' => [
					''  => esc_html__( 'None', 'bdthemes-element-pack' ),
					'0,1' => esc_html__( '0 -> 1', 'bdthemes-element-pack' ),
					'1,0' => esc_html__( '1 -> 0', 'bdthemes-element-pack' ),
				],
				'condition'    => [
					'_widget_parallax_on' => 'yes',
				],
			]
		);

	}


	public function register_controls_widget_tooltip($widget, $widget_id, $args) {
		static $widgets = [
			'_section_style', /* Section */
		];

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$widget->add_control(
			'element_pack_widget_tooltip',
			[
				'label'        => esc_html__( 'Use Tooltip?', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bdthemes-element-pack' ),
				'label_off'    => esc_html__( 'No', 'bdthemes-element-pack' ),
				'render_type'  => 'template',
			]
		);

		$widget->start_controls_tabs( 'element_pack_widget_tooltip_tabs' );

		$widget->start_controls_tab(
			'element_pack_widget_tooltip_settings_tab',
			[
				'label' => esc_html__( 'Settings', 'bdthemes-element-pack' ),
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'element_pack_widget_tooltip_text',
			[
				'label' => esc_html__( 'Description', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::TEXTAREA,
				'render_type'  => 'template',
				'default'      => 'This is Tooltip',
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'element_pack_widget_tooltip_placement',
			[
				'label'   => esc_html__( 'Placement', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top'    => esc_html__( 'Top', 'bdthemes-element-pack' ),
					'bottom' => esc_html__( 'Bottom', 'bdthemes-element-pack' ),
					'left'   => esc_html__( 'Left', 'bdthemes-element-pack' ),
					'right'  => esc_html__( 'Right', 'bdthemes-element-pack' ),
				],
				'render_type'  => 'template',
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'element_pack_widget_tooltip_animation',
			[
				'label'   => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'shift-toward',
				'options' => [
					'shift-away'   => esc_html__( 'Shift-Away', 'bdthemes-element-pack' ),
					'shift-toward' => esc_html__( 'Shift-Toward', 'bdthemes-element-pack' ),
					'fade'         => esc_html__( 'Fade', 'bdthemes-element-pack' ),
					'scale'        => esc_html__( 'Scale', 'bdthemes-element-pack' ),
					'perspective'  => esc_html__( 'Perspective', 'bdthemes-element-pack' ),
				],
				'render_type'  => 'template',
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'element_pack_widget_tooltip_x_offset',
			[
				'label'   => esc_html__( 'Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => -1000,
				'max'     => 1000,
				'step'    => 1,
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'element_pack_widget_tooltip_y_offset',
			[
				'label'   => esc_html__( 'Distance', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => -1000,
				'max'     => 1000,
				'step'    => 1,
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'element_pack_widget_tooltip_arrow',
			[
				'label'        => esc_html__( 'Arrow', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'condition'    => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'element_pack_widget_tooltip_styles_tab',
			[
				'label' => esc_html__( 'Style', 'bdthemes-element-pack' ),
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'element_pack_widget_tooltip_width',
			[
				'label'      => esc_html__( 'Width', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em',
				],
				'range'      => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
				'render_type'  => 'template',
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'element_pack_widget_tooltip_typography',
				'selector' => '{{WRAPPER}} .tippy-tooltip .tippy-content',
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'element_pack_widget_tooltip_color',
			[
				'label'  => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'color: {{VALUE}}',
				],
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'element_pack_widget_tooltip_text_align',
			[
				'label'   => esc_html__( 'Text Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'element_pack_widget_tooltip_background',
				'selector' => '{{WRAPPER}} .tippy-tooltip, {{WRAPPER}} .tippy-tooltip .tippy-backdrop',
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'element_pack_widget_tooltip_arrow_color',
			[
				'label'  => esc_html__( 'Arrow Color', 'bdthemes-element-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-popper[x-placement^=left] .tippy-arrow'  => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=right] .tippy-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=top] .tippy-arrow'   => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=bottom] .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				],
				'condition' => [
					'element_pack_widget_tooltip'       => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'element_pack_widget_tooltip_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type'  => 'template',
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'element_pack_widget_tooltip_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .tippy-tooltip',
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'element_pack_widget_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'element_pack_widget_tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .tippy-tooltip',
				'condition' => [
					'element_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->end_controls_tabs();



	}


	protected function add_actions() {

		$bg_parallax              = element_pack_option('section_parallax_show', 'element_pack_elementor_extend', 'on' );
		$widget_parallax          = element_pack_option('widget_parallax_show', 'element_pack_elementor_extend', 'on' );
		$widget_tooltip           = element_pack_option('widget_tooltip_show', 'element_pack_elementor_extend', 'off' );
		$section_particles        = element_pack_option('section_particles_show', 'element_pack_elementor_extend', 'on' );
		$section_schedule         = element_pack_option('section_schedule_show', 'element_pack_elementor_extend', 'on' );
		$section_sticky           = element_pack_option('section_sticky_show', 'element_pack_elementor_extend', 'on' );
		$section_parallax_content = element_pack_option('section_parallax_content_show', 'element_pack_elementor_extend', 'on' );

		if ( 'on' === $bg_parallax ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_bg_parallax' ], 10, 3 );		
			add_action( 'elementor/frontend/section/before_render', [ $this, 'parallax_before_render' ], 10, 1 );
		}
		
		if ( 'on' === $widget_parallax ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_widget_parallax' ], 10, 3 );
			add_action( 'elementor/frontend/widget/before_render', [ $this, 'widget_parallax_before_render' ], 10, 1 );
		}

		if ( 'on' === $widget_tooltip ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_widget_tooltip' ], 10, 3 );
			add_action( 'elementor/frontend/widget/before_render', [ $this, 'widget_tooltip_before_render' ], 10, 1 );
		}

		if ( 'on' === $section_particles ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_particles' ], 10, 3 );		
			add_action( 'elementor/frontend/section/before_render', [ $this, 'particles_before_render' ], 10, 1 );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
			add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
			add_action( 'elementor/frontend/section/after_render', [ $this, 'particles_after_render' ], 10, 1 );
		}
		
		if ( 'on' === $section_schedule ) {
			add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_scheduled' ], 10, 3 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'schedule_before_render' ], 10, 1 );
		}

		if ( 'on' === $section_parallax_content ) {
			add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_parallax' ], 10, 3 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'section_parallax_before_render' ], 10, 1 );
		}

		if ( 'on' === $section_sticky ) {
			add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_sticky' ], 10, 3 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'sticky_before_render' ], 10, 1 );
		}

		
		
	}



	public function parallax_before_render($section) {    		
		$settings = $section->get_settings();
		if( $section->get_settings( 'section_parallax_on' ) == 'yes' ) {
			$parallax_settings = $section->get_settings( 'section_parallax_value' );
			$section->add_render_attribute( '_wrapper', 'bdt-parallax', 'bgy: '.$parallax_settings['size'] );
		}
	}


	public function schedule_before_render($section) {    		
		$settings = $section->get_settings();
		if( $section->get_settings( 'section_scheduled_content_on' ) == 'yes' ) {
			$star_date    = strtotime($settings['section_scheduled_content_start_date']);
			$end_date     = strtotime($settings['section_scheduled_content_end_date']);
			$current_date = strtotime(gmdate( 'Y-m-d H:i', ( time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ) ));

			if ( ($current_date >= $star_date) and ($current_date <= $end_date) ) {
				$section->add_render_attribute( '_wrapper', 'class', 'bdt-scheduled' );
			} else {
				$section->add_render_attribute( '_wrapper', 'class', 'bdt-hidden' );
			}
		}
	}

	public function sticky_before_render($section) {    		
		$settings = $section->get_settings();
		if( !empty($settings[ 'section_sticky_on' ]) == 'yes' ) {
			$sticky_option = [];
			if ( !empty($settings[ 'section_sticky_on_scroll_up' ]) ) {
				$sticky_option['show-on-up'] = 'show-on-up: true';
			}

			if ( !empty($settings[ 'section_sticky_offset' ]['size']) ) {
				$sticky_option['offset'] = 'offset: ' . $settings[ 'section_sticky_offset' ]['size'];
			}

			if ( !empty($settings[ 'section_sticky_animation' ]) ) {
				$sticky_option['animation'] = 'animation: bdt-animation-' . $settings[ 'section_sticky_animation' ] . '; top: 100';
			}

			if ( !empty($settings[ 'section_sticky_bottom' ]) ) {
				$sticky_option['bottom'] = 'bottom: ' . $settings[ 'section_sticky_bottom' ];
			}

			if ( !empty($settings[ 'section_sticky_off_media' ]) ) {
				$sticky_option['media'] = 'media: ' . $settings[ 'section_sticky_off_media' ];
			}
			
			$section->add_render_attribute( '_wrapper', 'bdt-sticky', implode(";",$sticky_option) );
		}
	}
	

	public function widget_parallax_before_render($widget) {    		
		$settings = $widget->get_settings();
		if( $settings['_widget_parallax_on'] == 'yes' ) {
			$slider_settings = [];
			if (!empty($settings['_widget_parallax_opacity_value'])) {
				$slider_settings['x'] = 'opacity: ' . $settings['_widget_parallax_opacity_value'] . ';';	
			}
			if (!empty($settings['_widget_parallax_x_value']['size'])) {
				$slider_settings['x'] = 'x: ' . $settings['_widget_parallax_x_value']['size'] . ',0;';	
			}
			if (!empty($settings['_widget_parallax_y_value']['size'])) {
				$slider_settings['y'] = 'y: ' . $settings['_widget_parallax_y_value']['size'] . ',0;';
			}
			if (!empty($settings['_widget_parallax_viewport_value']['size'])) {
				$slider_settings['viewport'] = 'viewport: ' . $settings['_widget_parallax_viewport_value']['size'] . ';';
			}

			$widget->add_render_attribute( '_wrapper', 'bdt-parallax', implode(" ",$slider_settings) );
		}
	}

	public function widget_tooltip_before_render($widget) {    		
		$settings = $widget->get_settings();

		$element_id = $widget->get_settings( '_element_id' );
		if (empty($element_id)) {
			$id = 'bdt-widget-tooltip-'.$widget->get_id();
			$widget->add_render_attribute( '_wrapper', 'id', $id, true );
		} else {
			$id = $widget->get_settings( '_element_id' );

		}

		if( $settings['element_pack_widget_tooltip'] == 'yes' ) {
			
			$widget->add_render_attribute( '_wrapper', 'data-tippy', '', true );
			$widget->add_render_attribute( '_wrapper', 'data-tippy', '', true );

			if (!empty($settings['element_pack_widget_tooltip_text'])) {
				$widget->add_render_attribute( '_wrapper', 'title', $settings['element_pack_widget_tooltip_text'], true );
			}
			if (!empty($settings['element_pack_widget_tooltip_placement'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-placement', $settings['element_pack_widget_tooltip_placement'], true );
			}
			if (!empty($settings['element_pack_widget_tooltip_arrow'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-arrow', 'true', true );
			}
			if (!empty($settings['element_pack_widget_tooltip_animation'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-animation', $settings['element_pack_widget_tooltip_animation'], true );
			}
			if (!empty($settings['element_pack_widget_tooltip_x_offset']) and !empty($settings['element_pack_widget_tooltip_x_offset'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-offset', $settings['element_pack_widget_tooltip_x_offset'] .','. $settings['element_pack_widget_tooltip_y_offset'], true );
			}

			wp_enqueue_script( 'tippyjs' );

			?> 
			<script type="text/javascript">
				document.addEventListener('DOMContentLoaded', function(){
				    tippy( '#<?php echo esc_attr($id); ?>.elementor-widget' , {
				    	appendTo: document.querySelector('#<?php echo esc_attr($id); ?>')

				    });
				}, false);
			</script>
			<?php

		}
	}
	
	public function particles_before_render($section) {    		
		$settings = $section->get_settings();
		if( $section->get_settings( 'section_particles_on' ) == 'yes' ) {
			$section->add_render_attribute( '_wrapper', 'class', 'bdt-particles' );
			$element_id = $section->get_settings( '_element_id' );
			if (empty($element_id)) {
				$section->add_render_attribute( '_wrapper', 'id', 'bdt-particles-' . $section->get_id() );	
			}
		}
	}

	public function particles_after_render($section) {
		$settings = $section->get_settings();
		$element_id = $section->get_settings( '_element_id' );
		if (empty($element_id)) {
			$id = 'bdt-particles-'.$section->get_id();
		} else {
			$id = $section->get_settings( '_element_id' );
		}
		if( $section->get_settings( 'section_particles_on' ) == 'yes' ) {		
			if ( ! empty( $settings['section_particles_js'] ) ) { ?>
				<script type="text/javascript">
					document.addEventListener("DOMContentLoaded", evt => {
						particlesJS("<?php echo esc_attr($id); ?>", <?php echo $settings['section_particles_js']; ?> );
					});
				</script>
			<?php } else { $this->default_particles_render($section); }
		}
	}

	protected function default_particles_render($section) {
		$element_id = $section->get_settings( '_element_id' );
		if (empty($element_id)) {
			$id = 'bdt-particles-'.$section->get_id();
		} else {
			$id = $section->get_settings( '_element_id' );
		}
		?>
		<script type="text/javascript">
			document.addEventListener("DOMContentLoaded", evt => {
				particlesJS("<?php echo esc_attr($id); ?>", {"particles":{"number":{"value":80,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});
			});
		</script>		
	<?php
	}


	public function section_parallax_before_render($section) {
		$parallax_elements = $section->get_settings('section_parallax_elements');
		$settings          = $section->get_settings();

		if( empty($parallax_elements) ) {
			return;
		}

		wp_enqueue_script( 'parallax' );

		$id                = $section->get_id();
		$section->add_render_attribute( 'scene', 'class', 'parallax-scene' );
		$section->add_render_attribute( '_wrapper', 'class', 'has-bdt-parallax' );

		if ( 'relative' === $settings['section_parallax_mode']) {
			$section->add_render_attribute( 'scene', 'data-relative-input', 'true' );
		} elseif ( 'clip' === $settings['section_parallax_mode']) {
			$section->add_render_attribute( 'scene', 'data-clip-relative-input', 'true' );
		} elseif ( 'hover' === $settings['section_parallax_mode']) {
			$section->add_render_attribute( 'scene', 'data-hover-only', 'true' );
		}


		?>
		<div data-parallax-id="bdt_scene<?php echo esc_attr($id); ?>" id="bdt_scene<?php echo esc_attr($id); ?>" <?php echo $section->get_render_attribute_string( 'scene' ); ?>>
			<?php foreach ( $parallax_elements as $index => $item ) : ?>
			
				<?php 

				$image_src = wp_get_attachment_image_src( $item['section_parallax_image']['id'], 'full' ); 

				if ($item['section_parallax_bgp_x']) {
					$section->add_render_attribute( 'item', 'style', 'background-position-x: ' . $item['section_parallax_bgp_x'] . '%;', true );
				}
				if ($item['section_parallax_bgp_y']) {
					$section->add_render_attribute( 'item', 'style', 'background-position-y: ' . $item['section_parallax_bgp_y'] . '%;' );
				}
				if ($item['section_parallax_bg_size']) {
					$section->add_render_attribute( 'item', 'style', 'background-size: ' . $item['section_parallax_bg_size'] . ';' );
				}

				if ($image_src[0]) {
					$section->add_render_attribute( 'item', 'style', 'background-image: url(' . esc_url($image_src[0]) .');' );
				}

				?>
				
				<div data-depth="<?php echo $item['section_parallax_depth']; ?>" class="bdt-scene-item" <?php echo $section->get_render_attribute_string( 'item' ); ?>></div>
				

			<?php endforeach; ?>
		</div>

		<?php
	}

	public function enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'particles', BDTEP_URL . 'assets/vendor/js/particles' . $suffix . '.js', ['jquery'], '2.0.0', false );
	}



}
