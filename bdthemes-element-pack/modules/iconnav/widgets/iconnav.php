<?php
namespace ElementPack\Modules\Iconnav\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use ElementPack\Modules\Navbar\ep_menu_walker;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Iconnav extends Widget_Base {
	public function get_name() {
		return 'bdt-iconnav';
	}

	public function get_title() {
		return esc_html__( 'Iconnav', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-navigation-vertical';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'tippyjs' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_iconnav',
			[
				'label' => esc_html__( 'Iconnav', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'iconnavs',
			[
				'label'   => esc_html__( 'Iconnav Items', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'iconnav_title' => esc_html__( 'Homepage', 'bdthemes-element-pack' ),
						'icon'          => 'fa fa-home',
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						] 
					],
					[
						'iconnav_title' => esc_html__( 'Product', 'bdthemes-element-pack' ),
						'icon'          => 'fa fa-shopping-bag',
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						]
					],
					[
						'iconnav_title' => esc_html__( 'Support', 'bdthemes-element-pack' ),
						'icon'          => 'fa fa-wrench',
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						]
					],
					[
						'iconnav_title' => esc_html__( 'Blog', 'bdthemes-element-pack' ),
						'icon'          => 'fa fa-book',
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						]
					],
					[
						'iconnav_title' => esc_html__( 'About Us', 'bdthemes-element-pack' ),
						'icon'          => 'fa fa-envelope-o',
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						]
					],
				],
				'fields' => [
					[
						'name'    => 'icon',
						'label'   => esc_html__( 'Icon', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::ICON,
						'default' => 'fa fa-home',
					],
					[
						'name'    => 'iconnav_title',
						'label'   => esc_html__( 'Iconnav Title', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::TEXT,
						'default' => esc_html__( 'Iconnav Title' , 'bdthemes-element-pack' ),
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'        => 'iconnav_link',
						'label'       => esc_html__( 'Link', 'bdthemes-element-pack' ),
						'type'        => Controls_Manager::URL,
						'default'     => [ 'url' => '#' ],
						'description' => 'Add your section id WITH the # key. e.g: #my-id also you can add internal/external URL',
						'dynamic'     => [ 'active' => true ],
					],
				],
				'title_field' => '{{{ iconnav_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_offcanvas_layout',
			[
				'label' => esc_html__( 'Offcanvas Menu', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'navbar',
			[
				'label'   => esc_html__( 'Select Menu', 'bdthemes-element-pack' ),
				'description'   => esc_html__( 'Child menu not visible in off-canvas for some design issue.', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => element_pack_get_menu(),
			]
		);

		$this->add_control(
			'offcanvas_overlay',
			[
				'label'        => esc_html__( 'Overlay', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => [
					'navbar!' => '0',
				],
			]
		);

		$this->add_control(
			'offcanvas_animations',
			[
				'label'     => esc_html__( 'Animations', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'slide',
				'options'   => [
					'slide'  => esc_html__( 'Slide', 'bdthemes-element-pack' ),
					'push'   => esc_html__( 'Push', 'bdthemes-element-pack' ),
					'reveal' => esc_html__( 'Reveal', 'bdthemes-element-pack' ),
					'none'   => esc_html__( 'None', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'navbar!' => '0',
				],
			]
		);

		$this->add_control(
			'offcanvas_flip',
			[
				'label'        => esc_html__( 'Flip', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => [
					'navbar!' => '0',
				],
			]
		);

		$this->add_control(
			'offcanvas_close_button',
			[
				'label'     => esc_html__( 'Close Button', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'navbar!' => '0',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_branding',
			[
				'label' => esc_html__( 'Branding', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'show_branding',
			[
				'label'   => __( 'Show Branding', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'branding_image',
			[
				'label'     => __( 'Choose Branding Image', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'show_branding' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'brading_space',
			[
				'label'   => __( 'Space', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-branding'     => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional_settings',
			[
				'label' => esc_html__( 'Additional Settings', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'iconnav_width',
			[
				'label' => esc_html__( 'Width', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 48,
						'max'  => 120,
						'step' => 2,
					],
				],
				'default' => [
					'size' => 48,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-container'     => 'width: {{SIZE}}{{UNIT}};',
					'body:not(.bdt-offcanvas-flip) #bdt-offcanvas{{ID}}.bdt-offcanvas.bdt-icon-nav-left .bdt-offcanvas-bar' => 'left: {{SIZE}}{{UNIT}};',
					'body.bdt-offcanvas-flip #bdt-offcanvas{{ID}}.bdt-offcanvas.bdt-icon-nav-right .bdt-offcanvas-bar' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'iconnav_position',
			[
				'label'   => esc_html__( 'Iconnav Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'bdthemes-element-pack' ),
					'right' => esc_html__( 'Right', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'iconnav_top_offset',
			[
				'label'   => __( 'Top Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 80,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-container'     => 'padding-top: {{SIZE}}{{UNIT}};',
					'#bdt-offcanvas{{ID}}.bdt-offcanvas .bdt-offcanvas-bar' => 'padding-top: calc({{SIZE}}{{UNIT}} + {{brading_space.SIZE}}px + 50px);',
				],
			]
		);

		$this->add_responsive_control(
			'iconnav_gap',
			[
				'label'   => __( 'Icon Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav-container ul.bdt-icon-nav.bdt-icon-nav-vertical li + li'     => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconnav_tooltip_spacing',
			[
				'label'   => __( 'Tooltip Spacing', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_iconnav',
			[
				'label' => esc_html__( 'Iconnav', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'iconnav_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-container' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'iconnav_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-container',
			]
		);

		$this->add_responsive_control(
			'iconnav_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'iconnav_shadow',
				'selector' => '{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-container',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_iconnav_icon',
			[
				'label' => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
	
		$this->start_controls_tabs( 'tabs_iconnav_icon_style' );

		$this->start_controls_tab(
			'tab_iconnav_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'iconnav_icon_size',
			[
				'label' => esc_html__( 'Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 10,
						'max'  => 48,
					],
				],
				'default' => [
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'iconnav_icon_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'iconnav_icon_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper',
			]
		);

		$this->add_responsive_control(
			'iconnav_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'iconnav_icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper',
			]
		);

		$this->add_responsive_control(
			'iconnav_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconnav_icon_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'iconnav_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'iconnav_icon_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iconnav_icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'iconnav_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'iconnav_icon_active',
			[
				'label' => esc_html__( 'Active', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'iconnav_icon_active_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iconnav_icon_active_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'iconnav_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-icon-wrapper' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tooltip',
			[
				'label' => esc_html__( 'Tooltip', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tooltip_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .tippy-backdrop' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tooltip_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .tippy-backdrop' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'tooltip_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-icon-nav .tippy-tooltip',
			]
		);

		$this->add_responsive_control(
			'tooltip_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-icon-nav .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tooltip_shadow',
				'selector' => '{{WRAPPER}} .bdt-icon-nav .tippy-tooltip',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tooltip_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-icon-nav .tippy-backdrop',
			]
		);
		
		$this->add_control(
			'tooltip_animation',
			[
				'label'   => esc_html__( 'Tooltip Animation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''             => esc_html__( 'Default', 'bdthemes-element-pack' ),
					'shift-toward' => esc_html__( 'Shift Toward', 'bdthemes-element-pack' ),
					'fade'         => esc_html__( 'Fade', 'bdthemes-element-pack' ),
					'scale'        => esc_html__( 'Scale', 'bdthemes-element-pack' ),
					'perspective'  => esc_html__( 'Perspective', 'bdthemes-element-pack' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tooltip_size',
			[
				'label'   => esc_html__( 'Tooltip Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''      => esc_html__( 'Default', 'bdthemes-element-pack' ),
					'large' => esc_html__( 'Large', 'bdthemes-element-pack' ),
					'small' => esc_html__( 'small', 'bdthemes-element-pack' ),
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas_content',
			[
				'label'     => esc_html__( 'Offcanvas', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navbar!' => '0',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-offcanvas{{ID}}.bdt-offcanvas .bdt-offcanvas-bar *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-offcanvas{{ID}}.bdt-offcanvas .bdt-offcanvas-bar a'   => 'color: {{VALUE}};',
					'#bdt-offcanvas{{ID}}.bdt-offcanvas .bdt-offcanvas-bar a *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-offcanvas{{ID}}.bdt-offcanvas .bdt-offcanvas-bar a:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-offcanvas{{ID}}.bdt-offcanvas .bdt-offcanvas-bar' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'offcanvas_content_box_shadow',
				'selector'  => '#bdt-offcanvas{{ID}}.bdt-offcanvas .bdt-offcanvas-bar',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'offcanvas_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#bdt-offcanvas{{ID}}.bdt-offcanvas .bdt-offcanvas-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_branding',
			[
				'label'     => esc_html__( 'Branding', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_branding' => 'yes',
				],
			]
		);

		$this->add_control(
			'branding_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-branding' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'branding_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-branding' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'branding_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-branding',
			]
		);

		$this->add_responsive_control(
			'branding_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-branding' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'branding_shadow',
				'selector' => '{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-branding',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'branding_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-icon-nav .bdt-icon-nav-branding',
			]
		);

		$this->end_controls_section();

	}

	public function render_loop_iconnav_list($list) {
		$settings        = $this->get_settings();

		$scroll_active = (preg_match("/(#\s*([a-z]+)\s*)/", $list['iconnav_link']['url'])) ? 'bdt-scroll' : '';

		$this->add_render_attribute( 'iconnav-item', 'class', 'bdt-icon-nav-icon-wrapper', true );
		$this->add_render_attribute( 'iconnav-item', 'title', $list["iconnav_title"], true );
		$this->add_render_attribute( 'iconnav-item', 'href', $list['iconnav_link']['url'], true );
		
		if ( $list['iconnav_link']['is_external'] ) {
			$this->add_render_attribute( 'iconnav-item', 'target', '_blank', true );
		}

		if ( $list['iconnav_link']['nofollow'] ) {
			$this->add_render_attribute( 'iconnav-item', 'rel', 'nofollow', true );
		}

		// Tooltip settings
		$this->add_render_attribute( 'iconnav-item', 'class', 'bdt-icon-nav-tooltip' );
		$this->add_render_attribute( 'iconnav-item', 'data-tippy', '', true );
		if ($settings['tooltip_animation']) {
			$this->add_render_attribute( 'iconnav-item', 'data-tippy-animation', $settings['tooltip_animation'], true );
		}
		if ($settings['tooltip_size']) {
			$this->add_render_attribute( 'iconnav-item', 'data-tippy-size', $settings['tooltip_size'], true );
		}
		if ($settings['iconnav_tooltip_spacing']) {
			$this->add_render_attribute( 'iconnav-item', 'data-tippy-distance', $settings['iconnav_tooltip_spacing'], true );
		}
		$this->add_render_attribute( 'iconnav-item', 'data-tippy-placement', 'left', true );
		

		?>
	    <li class="bdt-icon-nav-item">
			<a <?php echo $this->get_render_attribute_string( 'iconnav-item' ); ?> <?php echo $scroll_active; ?>>
				<?php if ($list['icon']) : ?>
					<span class="bdt-icon-nav-icon">
						<i class="<?php echo esc_attr($list['icon']); ?>"></i>
					</span>
				<?php endif; ?>
			</a>
		</li>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$this->add_render_attribute( 'icon-nav', 'class', 'bdt-icon-nav' );
		$this->add_render_attribute( 'icon-nav', 'id', 'bdt-icon-nav-' . $id );

		$this->add_render_attribute( 'nav-container', 'class', ['bdt-icon-nav-container', 'bdt-icon-nav-' . $settings['iconnav_position']] );
		
		?>
		<div <?php echo $this->get_render_attribute_string( 'icon-nav' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'nav-container' ); ?>>
				<div class="bdt-icon-nav-branding">
					<?php if ( $settings['show_branding']) : ?>
						<?php if ( ! empty( $settings['branding_image']['url'] ) ) : ?>
							<div class="bdt-logo-image"><img src="<?php echo esc_url( $settings['branding_image']['url'] ); ?>" alt=""></div>
						<?php else : ?>
							<?php
								$string          = get_bloginfo( 'name' );
								$words           = explode(" ", $string);
								$letters         = "";
								foreach ($words as $value) {
									$letters .= substr($value, 0, 1);
								}
							?>
							<div><div class="bdt-logo-txt">
								<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php echo esc_attr( $letters ); ?></a></div></div>
						<?php endif; ?>
					<?php endif; ?>

				</div>
				<ul class="bdt-icon-nav bdt-icon-nav-vertical">
					<?php if ( $settings['navbar'] ) : ?>
						<li>
							<a class="bdt-icon-nav-icon-wrapper" href="#" bdt-toggle="target: #bdt-offcanvas<?php echo esc_attr($id); ?>">
								<span class="bdt-icon-nav-icon">
									<i class="fa fa-navicon"></i>
								</span>
							</a>
						</li>
					<?php endif; ?>

					<?php
					foreach ($settings['iconnavs'] as $key => $nav) : 
						$this->render_loop_iconnav_list($nav);
					endforeach;
					?>
				</ul>
			</div>
		</div>
		<script type="text/javascript">
			document.addEventListener('DOMContentLoaded', function(){
			    tippy( '#bdt-icon-nav-<?php echo esc_attr($id); ?> .bdt-icon-nav-item .bdt-icon-nav-tooltip' , {
			    	appendTo: document.querySelector('#bdt-icon-nav-<?php echo esc_attr($id); ?>')

			    });
			}, false);
		</script>


	   <?php if ( $settings['navbar'] ) : ?>
		    <?php $this->offcanvas($settings); ?>
		<?php endif;
	}

	private function offcanvas($settings) {
		$id = $this->get_id();

		$this->add_render_attribute(
			[
				'offcanvas-settings' => [
					'id'            => 'bdt-offcanvas' . $id,
					'class'         => [
						'bdt-offcanvas',
						'bdt-icon-nav-offcanvas',
						'bdt-icon-nav-' . $settings['iconnav_position']
					],
					'bdt-offcanvas' => [
						wp_json_encode(array_filter([
							'mode'    => $settings['offcanvas_animations'],
							'overlay' => $settings['offcanvas_overlay'],
							'flip'    => $settings['offcanvas_flip']
						]))
					]
				]
			]
		);

		$nav_menu    = ! empty( $settings['navbar'] ) ? wp_get_nav_menu_object( $settings['navbar'] ) : false;
		$navbar_attr = [];
	    if ( ! $nav_menu ) {
	    	return;
	    }

	    $nav_menu_args = array(
	    	'fallback_cb'    => false,
	    	'container'      => false,
	    	'items_wrap'     => '<ul id="%1$s" class="%2$s" bdt-nav>%3$s</ul>',
	    	'menu_id'        => 'bdt-navmenu',
	    	'menu_class'     => 'bdt-nav',
	    	'theme_location' => 'default_navmenu', // creating a fake location for better functional control
	    	'menu'           => $nav_menu,
	    	'echo'           => true,
	    	'depth'          => 1,
	    	'walker'         => new ep_menu_walker
	    );

		?>		
	    <div <?php echo $this->get_render_attribute_string( 'offcanvas-settings' ); ?>>
	        <div class="bdt-offcanvas-bar">
				
				<?php if ($settings['offcanvas_close_button']) : ?>
	        		<button class="bdt-offcanvas-close" type="button" bdt-close></button>
	        	<?php endif; ?>
				
				<div id="bdt-navbar-<?php echo esc_attr($id); ?>" class="bdt-navbar-wrapper">
					<?php wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $settings ) ); ?>
				</div>
	        </div>
	    </div>
		<?php
	}
}
