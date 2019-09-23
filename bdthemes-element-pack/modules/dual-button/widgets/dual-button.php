<?php
namespace ElementPack\Modules\DualButton\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DualButton extends Widget_Base {
	public function get_name() {
		return 'bdt-dual-button';
	}

	public function get_title() {
		return __( 'Dual Button', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-button';
	}	

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_style_depends() {
		return [ 'bdt-advanced-button' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_button',
			[
				'label' => __( 'Button', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'dual_button_size',
			[
				'label'   => __( 'Button Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => __( 'Extra Small', 'bdthemes-element-pack' ),
					'sm' => __( 'Small', 'bdthemes-element-pack' ),
					'md' => __( 'Medium', 'bdthemes-element-pack' ),
					'lg' => __( 'Large', 'bdthemes-element-pack' ),
					'xl' => __( 'Extra Large', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Left', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-center',
					],
					'end' => [
						'title' => __( 'Right', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'bdt-element-align%s-',
			]
		);

		$this->add_responsive_control(
			'button_width',
			[
				'label' => __( 'Button Width', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'max' => 100,
						'min' => 20,
					],
					'px' => [
						'max' => 1200,
						'min' => 300,
					],
				],
				'size_units' => ['%', 'px'],
				'default' => [
					'size' => 40,
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => 80,
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button'  => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'show_middle_text',
			[
				'label' => __( 'Middle Text', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'middle_text',
			[
				'label'       => __( 'Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'or', 'bdthemes-element-pack' ),
				'placeholder' => __( 'or', 'bdthemes-element-pack' ),
				'condition'   => [
					'show_middle_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'dual_button_gap',
			[
				'label'   => __( 'Button Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button-a' => 'margin-right: {{SIZE}}px;',
				],
				'condition' => [
					'show_middle_text!' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button_a',
			[
				'label' => __( 'Button A', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_a_text',
			[
				'label'       => __( 'Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'Click Me', 'bdthemes-element-pack' ),
				'placeholder' => __( 'Click Me', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_a_link',
			[
				'label'       => __( 'Link', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'https://your-link.com', 'bdthemes-element-pack' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_a_onclick',
			[
				'label' => esc_html__( 'OnClick', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'button_a_onclick_event',
			[
				'label'       => __( 'OnClick Event', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'button_a_onclick' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'button_a_align',
			[
				'label'   => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-a'  => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_a_icon',
			[
				'label'       => __( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_a_icon_align',
			[
				'label'   => __( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => __( 'Left', 'bdthemes-element-pack' ),
					'right'  => __( 'Right', 'bdthemes-element-pack' ),
					'top'    => __( 'Top', 'bdthemes-element-pack' ),
					'bottom' => __( 'Bottom', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'button_a_icon!' => '',
				],
			]
		);

		$this->add_control(
			'button_a_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
					'default' => [
						'size' => 8,
					],
				'condition' => [
					'button_a_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-a .bdt-button-icon-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-dual-button-a .bdt-button-icon-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-dual-button-a .bdt-button-icon-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-dual-button-a .bdt-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button_b',
			[
				'label' => __( 'Button B', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_b_text',
			[
				'label'       => __( 'Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'Read More', 'bdthemes-element-pack' ),
				'placeholder' => __( 'Read More', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_b_link',
			[
				'label'       => __( 'Link', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'https://your-link.com', 'bdthemes-element-pack' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_b_size',
			[
				'label'   => __( 'Button Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => __( 'Extra Small', 'bdthemes-element-pack' ),
					'sm' => __( 'Small', 'bdthemes-element-pack' ),
					'md' => __( 'Medium', 'bdthemes-element-pack' ),
					'lg' => __( 'Large', 'bdthemes-element-pack' ),
					'xl' => __( 'Extra Large', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'button_b_onclick',
			[
				'label' => esc_html__( 'OnClick', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'button_b_onclick_event',
			[
				'label'       => __( 'OnClick Event', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'button_b_onclick' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'button_balign',
			[
				'label'   => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-b'  => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_b_icon',
			[
				'label'       => __( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_b_icon_align',
			[
				'label'   => __( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => __( 'Left', 'bdthemes-element-pack' ),
					'right'  => __( 'Right', 'bdthemes-element-pack' ),
					'top'    => __( 'Top', 'bdthemes-element-pack' ),
					'bottom' => __( 'Bottom', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'button_b_icon!' => '',
				],
			]
		);

		$this->add_control(
			'button_b_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
					'default' => [
						'size' => 8,
					],
				'condition' => [
					'button_b_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-b .bdt-button-icon-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-dual-button-b .bdt-button-icon-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-dual-button-b .bdt-button-icon-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-dual-button-b .bdt-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Button', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_dual_button_style' );

		$this->start_controls_tab(
			'tab_dual_button_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_border_style',
			[
				'label'   => __( 'Border Style', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => __( 'None', 'bdthemes-element-pack' ),
					'solid'  => __( 'Solid', 'bdthemes-element-pack' ),
					'dotted' => __( 'Dotted', 'bdthemes-element-pack' ),
					'dashed' => __( 'Dashed', 'bdthemes-element-pack' ),
					'groove' => __( 'Groove', 'bdthemes-element-pack' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button a' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_width',
			[
				'label'      => __( 'Border Width', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => 3,
					'right'  => 3,
					'bottom' => 3,
					'left'   => 3,
				],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->add_responsive_control(
			'dual_button_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dual_button_shadow',
				'selector' => '{{WRAPPER}} .bdt-dual-button a',
			]
		);

		$this->add_responsive_control(
			'dual_button_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dual_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-dual-button a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dual_button_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'dual_button_hover_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dual_button_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-dual-button a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style_a',
			[
				'label' => __( 'Button A', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_a_effect',
			[
				'label'   => __( 'Effect', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'a',
				'options' => [
					'a' => __( 'Effect A', 'bdthemes-element-pack' ),
					'b' => __( 'Effect B', 'bdthemes-element-pack' ),
					'c' => __( 'Effect C', 'bdthemes-element-pack' ),
					'd' => __( 'Effect D', 'bdthemes-element-pack' ),
					'e' => __( 'Effect E', 'bdthemes-element-pack' ),
					'f' => __( 'Effect F', 'bdthemes-element-pack' ),
					'g' => __( 'Effect G', 'bdthemes-element-pack' ),
					'h' => __( 'Effect H', 'bdthemes-element-pack' ),
					'i' => __( 'Effect I', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_a_style' );

		$this->start_controls_tab(
			'tab_button_a_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_a_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_a_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-dual-button-a, 
								{{WRAPPER}} .bdt-dual-button-a.bdt-advanced-button-effect-i .bdt-advanced-button-content-wrapper:after,
								{{WRAPPER}} .bdt-dual-button-a.bdt-advanced-button-effect-i .bdt-advanced-button-content-wrapper:before',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_a_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-a' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_a_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_a_hover_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_a_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-dual-button-a:after, 
								{{WRAPPER}} .bdt-dual-button-a:hover,
								{{WRAPPER}} .bdt-dual-button-a.bdt-advanced-button-effect-i,
								{{WRAPPER}} .bdt-dual-button-a.bdt-advanced-button-effect-h:after',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_a_hover_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-a:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style_b',
			[
				'label' => __( 'Button B', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_b_effect',
			[
				'label'   => __( 'Effect', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'a',
				'options' => [
					'a' => __( 'Effect A', 'bdthemes-element-pack' ),
					'b' => __( 'Effect B', 'bdthemes-element-pack' ),
					'c' => __( 'Effect C', 'bdthemes-element-pack' ),
					'd' => __( 'Effect D', 'bdthemes-element-pack' ),
					'e' => __( 'Effect E', 'bdthemes-element-pack' ),
					'f' => __( 'Effect F', 'bdthemes-element-pack' ),
					'g' => __( 'Effect G', 'bdthemes-element-pack' ),
					'h' => __( 'Effect H', 'bdthemes-element-pack' ),
					'i' => __( 'Effect I', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_b_style' );

		$this->start_controls_tab(
			'tab_button_b_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_b_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-b' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_b_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bdt-dual-button-b, 
							   {{WRAPPER}} .bdt-dual-button-b.bdt-advanced-button-effect-i .bdt-advanced-button-content-wrapper:after, 
							   {{WRAPPER}} .bdt-dual-button-b.bdt-advanced-button-effect-i .bdt-advanced-button-content-wrapper:before',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_b_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-b' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_b_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_b_hover_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-b:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_b_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-dual-button-b:after,
								{{WRAPPER}} .bdt-dual-button-b:hover, 
								{{WRAPPER}} .bdt-dual-button-b.bdt-advanced-button-effect-i,
								{{WRAPPER}} .bdt-dual-button-a.bdt-advanced-button-effect-h:after
								',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_b_hover_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-b:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button_a_icon',
			[
				'label'     => __( 'Button A Icon', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_a_icon!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_a_icon_style' );

		$this->start_controls_tab(
			'tab_button_a_icon_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_a_icon_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-a .bdt-dual-button-a-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_a_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-dual-button-a .bdt-dual-button-a-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_a_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-dual-button-a .bdt-dual-button-a-icon:after',
			]
		);

		$this->add_control(
			'button_a_icon_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button-a .bdt-dual-button-a-icon:after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_a_icon_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button-a .bdt-dual-button-a-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_a_icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-dual-button-a .bdt-dual-button-a-icon:after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_a_icon_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-dual-button-a .bdt-dual-button-a-icon:after',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_a_icon_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_a_icon_hover_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-a:hover .bdt-dual-button-a-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_a_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-dual-button-a:hover .bdt-dual-button-a-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_a_icon_hover_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_a_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-a:hover .bdt-dual-button-a-icon:after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button_b_icon',
			[
				'label'     => __( 'Button B Icon', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_b_icon!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_b_icon_style' );

		$this->start_controls_tab(
			'tab_button_b_icon_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_b_icon_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-b .bdt-dual-button-b-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_b_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-dual-button-b .bdt-dual-button-b-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_b_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-dual-button-b .bdt-dual-button-b-icon:after',
			]
		);

		$this->add_control(
			'button_b_icon_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button-b .bdt-dual-button-b-icon:after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_b_icon_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button-b .bdt-dual-button-b-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_b_icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-dual-button-b .bdt-dual-button-b-icon:after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_b_icon_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-dual-button-b .bdt-dual-button-b-icon:after',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_b_icon_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_b_icon_hover_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-b:hover .bdt-dual-button-b-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_b_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-dual-button-b:hover .bdt-dual-button-b-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_b_icon_hover_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_b_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button-b:hover .bdt-dual-button-b-icon:after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_middle_text',
			[
				'label'      => __( 'Middle Text', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'show_middle_text',
							'value'    => 'yes',
						],
						[
							'name'     => 'middle_text',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]

		);

		$this->add_control(
			'middle_text_color',
			[
				'label'     => __( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dual-button span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'middle_text_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bdt-dual-button span',
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'middle_text_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-dual-button span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'middle_text_shadow',
				'selector' => '{{WRAPPER}} .bdt-dual-button span',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'middle_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-dual-button span',
			]
		);

		$this->end_controls_section();
	}

	public function render_text_a($settings) {

		$this->add_render_attribute( 'content-wrapper-a', 'class', 'bdt-advanced-button-content-wrapper' );
		$this->add_render_attribute( 'content-wrapper-a', 'class', ( 'top' == $settings['button_a_icon_align'] ) ? 'bdt-flex bdt-flex-column' : '' );
		$this->add_render_attribute( 'content-wrapper-a', 'class', ( 'bottom' == $settings['button_a_icon_align'] ) ? 'bdt-flex bdt-flex-column-reverse' : '' );
		$this->add_render_attribute( 'content-wrapper-a', 'data-text', esc_attr($settings['button_a_text']));

		$this->add_render_attribute( 'button-a-text', 'class', 'bdt-advanced-button-text' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper-a' ); ?>>
			<?php if ( ! empty( $settings['button_a_icon'] ) ) : ?>
				<div class="bdt-advanced-button-icon bdt-dual-button-a-icon bdt-button-icon-align-<?php echo esc_attr($settings['button_a_icon_align']); ?>">
					<i class="<?php echo esc_attr( $settings['button_a_icon'] ); ?>" aria-hidden="true"></i>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'button-a-text' ); ?>><?php echo $settings['button_a_text']; ?></div>
		</div>
		<?php
	}

	public function render_text_b($settings) {

		$this->add_render_attribute( 'content-wrapper-b', 'class', 'bdt-advanced-button-content-wrapper' );
		$this->add_render_attribute( 'content-wrapper-b', 'class', ( 'top' == $settings['button_b_icon_align'] ) ? 'bdt-flex bdt-flex-column' : '' );
		$this->add_render_attribute( 'content-wrapper-b', 'class', ( 'bottom' == $settings['button_b_icon_align'] ) ? 'bdt-flex bdt-flex-column-reverse' : '' );
		$this->add_render_attribute( 'content-wrapper-b', 'data-text', esc_attr($settings['button_b_text']));

		$this->add_render_attribute( 'button-b-text', 'class', 'bdt-advanced-button-text' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper-b' ); ?>>
			<?php if ( ! empty( $settings['button_b_icon'] ) ) : ?>
				<div class="bdt-advanced-button-icon bdt-dual-button-b-icon bdt-button-icon-align-<?php echo esc_attr($settings['button_b_icon_align']); ?>">
					<i class="<?php echo esc_attr( $settings['button_b_icon'] ); ?>" aria-hidden="true"></i>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'button-b-text' ); ?>><?php echo $settings['button_b_text']; ?></div>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'bdt-dual-button bdt-advanced-button-wrapper bdt-element' );

		if ( ! empty( $settings['button_a_link']['url'] ) ) {
			$this->add_render_attribute( 'button_a', 'href', $settings['button_a_link']['url'] );

			if ( $settings['button_a_link']['is_external'] ) {
				$this->add_render_attribute( 'button_a', 'target', '_blank' );
			}

			if ( $settings['button_a_link']['nofollow'] ) {
				$this->add_render_attribute( 'button_a', 'rel', 'nofollow' );
			}
		}

		if ( ! empty( $settings['button_b_link']['url'] ) ) {
			$this->add_render_attribute( 'button_b', 'href', $settings['button_b_link']['url'] );

			if ( $settings['button_b_link']['is_external'] ) {
				$this->add_render_attribute( 'button_b', 'target', '_blank' );
			}

			if ( $settings['button_b_link']['nofollow'] ) {
				$this->add_render_attribute( 'button_b', 'rel', 'nofollow' );
			}
		}

		if ( $settings['button_a_link']['nofollow'] ) {
			$this->add_render_attribute( 'button_a', 'rel', 'nofollow' );
		}

		if ( $settings['button_b_link']['nofollow'] ) {
			$this->add_render_attribute( 'button_b', 'rel', 'nofollow' );
		}

		if ( 'yes' === $settings['button_a_onclick'] ) {
			$this->add_render_attribute( 'button_a', 'onclick', $settings['onclick_event_a'] );
		}

		if ( 'yes' === $settings['button_b_onclick'] ) {
			$this->add_render_attribute( 'button_b', 'onclick', $settings['onclick_event_b'] );
		}

		$this->add_render_attribute( 'button_a', 'class', 'bdt-dual-button-a bdt-advanced-button' );		
		$this->add_render_attribute( 'button_a', 'class', 'bdt-advanced-button-effect-' . esc_attr($settings['button_a_effect']) );
		$this->add_render_attribute( 'button_a', 'class', 'bdt-advanced-button-size-' . esc_attr($settings['dual_button_size']) );

		$this->add_render_attribute( 'button_b', 'class', 'bdt-dual-button-b bdt-advanced-button' );		
		$this->add_render_attribute( 'button_b', 'class', 'bdt-advanced-button-effect-' . esc_attr($settings['button_b_effect']) );
		$this->add_render_attribute( 'button_b', 'class', 'bdt-advanced-button-size-' . esc_attr($settings['dual_button_size']) );	

		?>
		<div class="bdt-element-align-wrapper">
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<a <?php echo $this->get_render_attribute_string( 'button_a' ); ?>>
					<?php $this->render_text_a($settings); ?>
				</a>

				<?php if ( 'yes' === $settings['show_middle_text'] ) : ?>
					<span><?php echo esc_attr($settings['middle_text']); ?></span>
				<?php endif; ?>

				<a <?php echo $this->get_render_attribute_string( 'button_b' ); ?>>
					<?php $this->render_text_b($settings); ?>
				</a>
			</div>
		</div>
		<?php
	}
}
