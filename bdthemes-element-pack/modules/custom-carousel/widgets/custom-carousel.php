<?php
namespace ElementPack\Modules\CustomCarousel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Embed;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Custom_Carousel extends Widget_Base {
	private $slide_prints_count = 0;

	public function get_name() {
		return 'bdt-custom-carousel';
	}

	public function get_title() {
		return esc_html__( 'Custom Carousel', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-slider-push';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'bdt-uikit-icons' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'bdthemes-element-pack' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'skin',
			[
				'label'   => esc_html__( 'Skin', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => [
					'carousel'  => esc_html__( 'Carousel', 'bdthemes-element-pack' ),
					'coverflow' => esc_html__( 'Coverflow', 'bdthemes-element-pack' ),
				],
				'prefix_class' => 'bdt-custom-carousel-style-',
				'render_type'  => 'template',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'type',
			[
				'type'    => Controls_Manager::CHOOSE,
				'label'   => esc_html__( 'Type', 'bdthemes-element-pack' ),
				'default' => 'image',
				'options' => [
					'image' => [
						'title' => esc_html__( 'Image', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-image',
					],
					'video' => [
						'title' => esc_html__( 'Video', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-video-camera',
					],
				],
				'label_block' => false,
				'toggle'      => false,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'image_link_to_type',
			[
				'label'   => esc_html__( 'Link to', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''       => esc_html__( 'None', 'bdthemes-element-pack' ),
					'file'   => esc_html__( 'Media File', 'bdthemes-element-pack' ),
					'custom' => esc_html__( 'Custom URL', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'image_link_to',
			[
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'http://your-link.com', 'bdthemes-element-pack' ),
				'condition'   => [
					'type' => 'image',
					'image_link_to_type' => 'custom',
				],
				'separator' => 'none',
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'video',
			[
				'label'         => esc_html__( 'Video Link', 'bdthemes-element-pack' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'Enter your video link', 'bdthemes-element-pack' ),
				'description'   => esc_html__( 'Insert YouTube or Vimeo link', 'bdthemes-element-pack' ),
				'show_external' => false,
				'condition'     => [
					'type' => 'video',
				],
			]
		);

		$this->add_control(
			'slides',
			[
				'label' => esc_html__( 'Slides', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $this->get_repeater_defaults(),
			]
		);

		$slides_per_view = range( 1, 10 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_responsive_control(
			'slides_per_view',
			[
				'type'           => Controls_Manager::SELECT,
				'label'          => esc_html__( 'Slides Per View', 'bdthemes-element-pack' ),
				'options'        => $slides_per_view,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
			]
		);

		$this->add_control(
			'slides_to_scroll',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Slides to Scroll', 'bdthemes-element-pack' ),
				'options'   => $slides_per_view,
				'default'   => '1',
				'condition' => [
					'skin' => 'carousel',
				]
			]
		);

		$this->add_control(
			'slides_per_column',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Slides Per Column', 'bdthemes-element-pack' ),
				'options'   => $slides_per_view,
				'default'   => '1',
				'condition' => [
					'skin' => 'carousel',
				]
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Height', 'bdthemes-element-pack' ),
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'type'  => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Width', 'bdthemes-element-pack' ),
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1140,
					],
					'%' => [
						'min' => 50,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label' => __( 'Navigation', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'            => esc_html__( 'Arrows and Dots', 'bdthemes-element-pack' ),
					'arrows-fraction' => esc_html__( 'Arrows and Fraction', 'bdthemes-element-pack' ),
					'arrows'          => esc_html__( 'Arrows', 'bdthemes-element-pack' ),
					'dots'            => esc_html__( 'Dots', 'bdthemes-element-pack' ),
					'progressbar'     => esc_html__( 'Progress', 'bdthemes-element-pack' ),
					'none'            => esc_html__( 'None', 'bdthemes-element-pack' ),
				],
				'prefix_class' => 'bdt-navigation-type-',
				'render_type' => 'template',				
			]
		);
		
		$this->add_control(
			'both_position',
			[
				'label'     => __( 'Arrows and Dots Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => element_pack_navigation_position(),
				'condition' => [
					'navigation' => 'both',
				],
				
			]
		);

		$this->add_control(
			'arrows_fraction_position',
			[
				'label'     => __( 'Arrows and Fraction Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => element_pack_navigation_position(),
				'condition' => [
					'navigation' => 'arrows-fraction',
				],
				
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'     => __( 'Arrows Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => element_pack_navigation_position(),
				'condition' => [
					'navigation' => 'arrows',
				],
				
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'     => __( 'Dots Position', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-center',
				'options'   => element_pack_pagination_position(),
				'condition' => [
					'navigation' => 'dots',
				],
				
			]
		);

		$this->add_control(
			'progress_position',
			[
				'label'   => __( 'Progress Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'bottom' => esc_html__('Bottom', 'bdthemes-element-pack'),
					'top'    => esc_html__('Top', 'bdthemes-element-pack'),
				],
				'condition' => [
					'navigation' => 'progressbar',
				],
				
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => esc_html__( 'Transition Duration', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => esc_html__( 'Infinite Loop', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'centered_slides',
			[
				'label'   => esc_html__( 'Centered Slides', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'pause_on_interaction',
			[
				'label'     => esc_html__( 'Pause on Interaction', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);


		$this->add_control(
			'overlay',
			[
				'label' => esc_html__( 'Overlay', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''     => esc_html__( 'None', 'bdthemes-element-pack' ),
					'text' => esc_html__( 'Text', 'bdthemes-element-pack' ),
					'icon' => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'caption',
			[
				'label' => esc_html__( 'Caption', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'title',
				'options' => [
					'title' => esc_html__( 'Title', 'bdthemes-element-pack' ),
					'caption' => esc_html__( 'Caption', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'overlay' => 'text',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'plus-circle',
				'options' => [
					'search' => [
						'icon' => 'fa fa-search-plus',
					],
					'plus-circle' => [
						'icon' => 'fa fa-plus-circle',
					],
					'plus' => [
						'icon' => 'fa fa-plus',
					],
					'link' => [
						'icon' => 'fa fa-link',
					],
					'play-circle' => [
						'icon' => 'fa fa-play-circle-o',
					],
				],
				'condition' => [
					'overlay' => 'icon',
				],
			]
		);

		$this->add_control(
			'overlay_animation',
			[
				'label'     => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => element_pack_transition_options(),
				'condition' => [
					'overlay!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				'default'   => 'full',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label'   => esc_html__( 'Image Fit', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''        => esc_html__( 'Cover', 'bdthemes-element-pack' ),
					'contain' => esc_html__( 'Contain', 'bdthemes-element-pack' ),
					'auto'    => esc_html__( 'Auto', 'bdthemes-element-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container .bdt-custom-carousel-thumbnail' => 'background-size: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slides_style',
			[
				'label' => esc_html__( 'Slides', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'desktop_default' => [
					'size' => 10,
				],
				'tablet_default' => [
					'size' => 10,
				],
				'mobile_default' => [
					'size' => 10,
				],
				'render_type' => 'none',
			]
		);

		$this->add_control(
			'slide_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slide_border_size',
			[
				'label'     => esc_html__( 'Border Size', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'slide_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slide_padding',
			[
				'label'     => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'slide_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'%' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'shadow_mode',
			[
				'label'        => esc_html__( 'Shadow Mode', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-ep-shadow-mode-',
			]
		);

		$this->add_control(
			'shadow_color',
			[
				'label'     => esc_html__( 'Shadow Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'shadow_mode' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container:before' => 'background: linear-gradient(to right, {{VALUE}} 5%,rgba(255,255,255,0) 100%);',
					'{{WRAPPER}} .elementor-widget-container:after'  => 'background: linear-gradient(to right, rgba(255,255,255,0) 0%, {{VALUE}} 95%);',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both', 'arrows-fraction', 'progressbar' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev svg, {{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev, {{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev:hover, {{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev svg, {{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Arrows Hover Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev:hover svg, {{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_space',
			[
				'label' => __( 'Space', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label' => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev, {{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev, {{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'arrows-fraction', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'arrows-fraction', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Dots Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'arrows-fraction', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'fraction_color',
			[
				'label'     => __( 'Fraction Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-fraction' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'active_fraction_color',
			[
				'label'     => __( 'Active Fraction Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-current' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'fraction_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-fraction',
				'condition' => [
					'navigation!' => [ 'arrows', 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'progresbar_color',
			[
				'label'     => __( 'Bar Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-progressbar' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => 'progressbar',
				],
			]
		);

		$this->add_control(
			'progres_color',
			[
				'label'     => __( 'Progress Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-progressbar' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => 'progressbar',
				],
			]
		);

		$this->add_control(
			'arrows_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_acx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nnx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nny_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cx_position',
			[
				'label'   => __( 'Arrows Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cy_position',
			[
				'label'   => __( 'Dots Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-dots-container' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_fraction_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows-fraction',
						],
						[
							'name'     => 'arrows_fraction_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_fraction_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-arrows-dots-container' => 'transform: translate({{arrows_fraction_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows-fraction',
						],
						[
							'name'     => 'arrows_fraction_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_fraction_cx_position',
			[
				'label'   => __( 'Arrows Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-custom-carousel .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows-fraction',
						],
						[
							'name'  => 'arrows_fraction_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_fraction_cy_position',
			[
				'label'   => __( 'Fraction Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-fraction' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows-fraction',
						],
						[
							'name'  => 'arrows_fraction_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'progress_y_position',
			[
				'label'   => __( 'Progress Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel .swiper-pagination-progressbar' => 'transform: translateY({{SIZE}}px);',
				],
				'condition' => [
					'navigation' => 'progressbar',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'overlay!' => '',
				],
			]
		);

		$this->add_control(
			'overlay_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel-item .bdt-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel-item .bdt-overlay' => 'color: {{VALUE}};',
				],
				'condition' => [
					'overlay' => 'text',
				],
			]
		);

		$this->add_control(
			'overlay_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel-item .bdt-overlay' => 'color: {{VALUE}};',
				],
				'condition' => [
					'overlay' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-carousel-item .bdt-overlay svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'overlay' => 'icon',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'caption_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-custom-carousel-item .bdt-overlay',
				'condition' => [
					'overlay' => 'text',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_lightbox_style',
			[
				'label' => esc_html__( 'Lightbox', 'bdthemes-element-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lightbox_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#elementor-lightbox-slideshow-{{ID}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_ui_color',
			[
				'label'     => esc_html__( 'UI Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#elementor-lightbox-slideshow-{{ID}} .dialog-lightbox-close-button, #elementor-lightbox-slideshow-{{ID}} .elementor-swiper-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_ui_hover_color',
			[
				'label'     => esc_html__( 'UI Hover Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#elementor-lightbox-slideshow-{{ID}} .dialog-lightbox-close-button:hover, #elementor-lightbox-slideshow-{{ID}} .elementor-swiper-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_video_width',
			[
				'label'   => esc_html__( 'Video Width', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'units'   => [ '%' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 50,
					],
				],
				'selectors' => [
					'#elementor-lightbox-slideshow-{{ID}} .elementor-video-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function get_default_slides_count() {
		return 5;
	}

	protected function get_repeater_defaults() {
		$placeholder_image_src = Utils::get_placeholder_image_src();

		return array_fill( 0, $this->get_default_slides_count(), [
			'image' => [
				'url' => $placeholder_image_src,
			],
		] );
	}

	protected function get_image_caption( $slide ) {
		$caption_type = $this->get_settings( 'caption' );

		if ( empty( $caption_type ) ) {
			return '';
		}

		$attachment_post = get_post( $slide['image']['id'] );

		if ( 'caption' === $caption_type ) {
			return $attachment_post->post_excerpt;
		}

		if ( 'title' === $caption_type ) {
			return $attachment_post->post_title;
		}
	}

	protected function get_image_link_to( $slide ) {
		if ( $slide['video']['url'] ) {
			return $slide['image']['url'];
		}

		if ( ! $slide['image_link_to_type'] ) {
			return '';
		}

		if ( 'custom' === $slide['image_link_to_type'] ) {
			return $slide['image_link_to']['url'];
		}

		return $slide['image']['url'];
	}

	protected function print_slide( array $slide, array $settings, $element_key ) {
		if ( ! empty( $settings['thumbs_slider'] ) ) {
			$settings['video_play_icon'] = false;
			$this->add_render_attribute( $element_key . '-image', 'class', 'elementor-fit-aspect-ratio' );
		}

		$this->add_render_attribute( $element_key . '-image', [
			'class' => 'bdt-custom-carousel-thumbnail',
			'style' => 'background-image: url(' . $this->get_slide_image_url( $slide, $settings ) . ')',
		] );

		$image_link_to = $this->get_image_link_to( $slide );

		if ( $image_link_to ) {
			if ( ('video' !== $slide['type']) && ( '' !== $slide['video']['url']) ) {
				$this->add_render_attribute( $element_key . '_link', 'href', $image_link_to );
			}

			if ( 'custom' === $slide['image_link_to_type'] ) {
				if ( $slide['image_link_to']['is_external'] ) {
					$this->add_render_attribute( $element_key . '_link', 'target', '_blank' );
				}

				if ( $slide['image_link_to']['nofollow'] ) {
					$this->add_render_attribute( $element_key . '_link', 'nofollow', '' );
				}
			} else {
				$this->add_render_attribute( $element_key . '_link', [
					'class'                        => 'bdt-custom-carousel-lightbox-item',
					'data-elementor-open-lightbox' => 'no',
					'data-caption'                 => $this->get_image_caption( $slide ),
				] );
			}

			if ( 'video' === $slide['type'] && $slide['video']['url'] ) {
				$this->add_render_attribute( $element_key . '_link', 'href', $slide['video']['url'] );
			}

			echo '<a ' . $this->get_render_attribute_string( $element_key . '_link' ) . '>';
		}

		$this->render_slide_image( $slide, $element_key, $settings );

		if ( $image_link_to ) {
			echo '</a>';
		}
	}

	protected function render_slide_image( array $slide, $element_key, array $settings ) {

		$this->add_render_attribute(
			[
				'overlay-settings' => [
					'class' => [
						'bdt-overlay',
						'bdt-overlay-default',
						'bdt-position-cover',
						'bdt-position-small',
						'bdt-flex',
						'bdt-flex-center',
						'bdt-flex-middle',
						$settings['overlay_animation'] ? 'bdt-transition-' . $settings['overlay_animation'] : ''
					],
				],
			], '', '', true
		);

		?>
		<div <?php echo $this->get_render_attribute_string( $element_key . '-image' ); ?>></div>
		
		<?php if ( $settings['overlay'] ) : ?>
			<div <?php echo $this->get_render_attribute_string( 'overlay-settings' ); ?>>
				<?php if ( 'text' === $settings['overlay'] ) : ?>
					<?php echo $this->get_image_caption( $slide ); ?>
				<?php else : ?>
					<span class="bdt-icon" bdt-icon="icon: <?php echo esc_attr($settings['icon']); ?>"></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php
	}

	protected function render_navigation() {
		$settings = $this->get_settings();
		
		if ( 'arrows' == $settings['navigation'] ) : ?>
			<div class="bdt-position-z-index bdt-visible@m bdt-position-<?php echo esc_attr($settings['arrows_position']); ?>">
				<div class="bdt-arrows-container bdt-slidenav-container">
					<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9"></a>
					<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9"></a>
				</div>
			</div>
		<?php endif;
	}

	protected function render_pagination() {
		$settings = $this->get_settings();
		
		if ( 'dots' == $settings['navigation'] or 'arrows-fraction' == $settings['navigation'] ) : ?>
			<div class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['dots_position']); ?>">
				<div class="bdt-dots-container">
					<div class="swiper-pagination"></div>
				</div>
			</div>

		<?php elseif ( 'progressbar' == $settings['navigation'] ) : ?>
			<div class="swiper-pagination bdt-position-z-index bdt-position-<?php echo esc_attr($settings['progress_position']); ?>"></div>
		<?php endif;
	}

	protected function render_both_navigation() {
		$settings = $this->get_settings();
		
		?>
		<div class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="bdt-arrows-dots-container bdt-slidenav-container ">
				
				<div class="bdt-flex bdt-flex-middle">
					<div class="bdt-visible@m">
						<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9"></a>
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
					
					<div class="bdt-visible@m">
						<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9"></a>
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}


	protected function render_arrows_fraction() {
		$settings = $this->get_settings();
		
		?>
		<div class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['arrows_fraction_position']); ?>">
			<div class="bdt-arrows-dots-container bdt-slidenav-container ">
				
				<div class="bdt-flex bdt-flex-middle">
					<div class="bdt-visible@m">
						<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9"></a>
					</div>

					<?php if ('center' !== $settings['arrows_fraction_position']) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
					
					<div class="bdt-visible@m">
						<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9"></a>
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	protected function render_header() {
		$id       = $this->get_id();
		$settings = $this->get_settings();

		$this->add_render_attribute( 'custom-carousel', 'id', 'bdt-custom-carousel-' . $id );
		$this->add_render_attribute( 'custom-carousel', 'class', 'bdt-custom-carousel elementor-swiper' );
		$this->add_render_attribute( 'custom-carousel', 'bdt-lightbox', 'toggle: .bdt-custom-carousel-lightbox-item; animation: slide;');

		if ('arrows' == $settings['navigation']) {
			$this->add_render_attribute( 'custom-carousel', 'class', 'bdt-arrows-align-'. $settings['arrows_position'] );
		} elseif ('dots' == $settings['navigation']) {
			$this->add_render_attribute( 'custom-carousel', 'class', 'bdt-dots-align-'. $settings['dots_position'] );
		} elseif ('both' == $settings['navigation']) {
			$this->add_render_attribute( 'custom-carousel', 'class', 'bdt-arrows-dots-align-'. $settings['both_position'] );
		} elseif ('arrows-fraction' == $settings['navigation']) {
			$this->add_render_attribute( 'custom-carousel', 'class', 'bdt-arrows-dots-align-'. $settings['arrows_fraction_position'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'custom-carousel' ); ?>>
			<div class="swiper-container">
				<div class="swiper-wrapper">
		<?php
	}

	protected function render_footer() {
		$settings     = $this->get_settings();
		$slides_count = count( $settings['slides'] );

				?>
				</div> 
			</div>

			<?php if ( 1 < $slides_count ) : ?>
				
				<?php if ('both' == $settings['navigation']) : ?>
					<?php $this->render_both_navigation(); ?>
					<?php if ( 'center' === $settings['both_position'] ) : ?>
						<div class="bdt-dots-container">
							<div class="swiper-pagination"></div>
						</div>
					<?php endif; ?>
				<?php elseif ('arrows-fraction' == $settings['navigation']) : ?>
					<?php $this->render_arrows_fraction(); ?>
					<?php if ( 'center' === $settings['arrows_fraction_position'] ) : ?>
						<div class="bdt-dots-container">
							<div class="swiper-pagination"></div>
						</div>
					<?php endif; ?>
				<?php else : ?>			
					<?php $this->render_pagination(); ?>
					<?php $this->render_navigation(); ?>
				<?php endif; ?>

			<?php endif; ?>
			
		</div>
		<?php
	}

	protected function render_script() {
		$id       = 'bdt-custom-carousel-'.$this->get_id();
		$settings = $this->get_settings();

		if ('arrows-fraction' == $settings['navigation'] ) {
			$pagination_type = 'fraction';
		} elseif ('both' == $settings['navigation'] or 'dots' == $settings['navigation']) {
			$pagination_type = 'bullets';
		} elseif ('progressbar' == $settings['navigation'] ) {
			$pagination_type = 'progressbar';
		} else {
			$pagination_type = '';
		}
		
		$swiper_script = [
			'navigation' => [
				'nextEl' => '#' . esc_attr($id) . ' .bdt-navigation-next',
				'prevEl' => '#' . esc_attr($id) . ' .bdt-navigation-prev',
			],
			'pagination' => [
				'el'        => '#' . esc_attr($id) . ' .swiper-pagination',
				'type'      => $pagination_type,
				'clickable' => 'true',
			],
			'loop'           => ($settings['loop'] === 'yes') ? true : false,
			'speed'          => $settings['speed'],
			'slidesPerView'  => $settings['slides_per_view'],
			'grabCursor'     => 'true',
			'effect'         => $settings['skin'],
			'spaceBetween'   => $settings['space_between']['size'],
			'centeredSlides' => ($settings['centered_slides'] === 'yes') ? true : false,
		];

		if ($settings['autoplay'] === 'yes') {
			$swiper_script['autoplay'] = ['delay' => $settings['autoplay_speed'] ];
		}
		if ($settings['skin'] === 'carousel' and $settings['slides_per_column'] > 1) {
			$swiper_script['slidesPerColumn'] = $settings['slides_per_column'];
		}
		if ($settings['slides_to_scroll'] < 1) {
			$swiper_script['slidesPerGroup']  = $settings['slides_to_scroll'];
		}

		$swiper_script['breakpoints'] = [
		    '1024' => [
				'slidesPerView' => $settings['slides_per_view'],
				'spaceBetween'  => $settings['space_between']['size'],
		    ],
		    '768' => [
				'slidesPerView' => $settings['slides_per_view_tablet'],
				'spaceBetween'  => $settings['space_between']['size'],
		    ],
		    '640' => [
				'slidesPerView' => $settings['slides_per_view_mobile'],
				'spaceBetween'  => $settings['space_between']['size'],
		    ]
		];

		?>
		<script>
			jQuery(document).ready(function($) {
			    "use strict";				    
			    var swiper = new Swiper("#<?php echo $id;?> .swiper-container", 
			    	<?php echo wp_json_encode( $swiper_script ); ?>
			    );
			});
		</script>
		<?php 
	}

	protected function render_loop_slides( array $settings = null ) {

		if ( null === $settings ) {
			$settings = $this->get_active_settings();
		}

		$default_settings = [ 'video_play_icon' => true ];
		$settings         = array_merge( $default_settings, $settings );
		$slides_count     = count( $settings['slides'] );

		foreach ( $settings['slides'] as $index => $slide ) :
			$this->slide_prints_count++;
			?>
			<div class="swiper-slide bdt-custom-carousel-item bdt-transition-toggle">
				<?php $this->print_slide( $slide, $settings, 'slide-' . $index . '-' . $this->slide_prints_count ); ?>
			</div>
			<?php 
		endforeach;
	}

	protected function get_slide_image_url( $slide, array $settings ) {
		$image_url = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'image_size', $settings );

		if ( ! $image_url ) {
			$image_url = $slide['image']['url'];
		}

		return $image_url;
	}

	protected function render_slider( array $settings = null ) {
		$this->render_loop_slides( $settings );
	}

	protected function render() {
		$this->render_header();
		$this->render_slider();
		$this->render_footer();
		$this->render_script();		
	}
}
