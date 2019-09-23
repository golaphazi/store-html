<?php
namespace ElementPack\Modules\TestimonialSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

use ElementPack\Modules\TestimonialSlider\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonial_Slider extends Widget_Base {

	public function get_name() {
		return 'bdt-testimonial-slider';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Slider', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'bdt-uikit-icons' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Thumb( $this ) );
	}

	public function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'thumb',
			[
				'label'     => esc_html__( 'Testimonial Image', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'company_name',
			[
				'label'   => esc_html__( 'Company Name/Address', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'rating',
			[
				'label'   => esc_html__( 'Rating', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'   => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'left',
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'horizontal_spacing',
			[
				'label'   => esc_html__( 'Horizontal Space', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-thumbnav:not(:first-child)' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_spacing',
			[
				'label'   => esc_html__( 'Vertical Space', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-thumbnav-inner' => 'padding-top: calc({{SIZE}}{{UNIT}} + 20px);',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label' => esc_html__( 'Query', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => esc_html__( 'Show All', 'bdthemes-element-pack' ),
					'by_name' => esc_html__( 'Manual Selection', 'bdthemes-element-pack' ),
				],
				'label_block' => true,
			]
		);


		$post_categories = get_terms( 'testimonial_categories' );

		$post_options = [];
		foreach ( $post_categories as $category ) {
			$post_options[ $category->slug ] = $category->name;
		}

		$this->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $post_options,
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'posts',
			[
				'label'   => esc_html__( 'Posts Limit', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'     => esc_html__( 'Date', 'bdthemes-element-pack' ),
					'title'    => esc_html__( 'Title', 'bdthemes-element-pack' ),
					'category' => esc_html__( 'Category', 'bdthemes-element-pack' ),
					'rand'     => esc_html__( 'Random', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'bdthemes-element-pack' ),
					'ASC'  => esc_html__( 'Ascending', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider_settins',
			[
				'label' => esc_html__( 'Slider Settings', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Auto Play', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'     => esc_html__( 'Autoplay Interval', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 7000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'   => esc_html__( 'Pause on Hover', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => esc_html__( 'Loop', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label'     => __( 'Navigation', 'bdthemes-element-pack' ),
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'bdthemes-element-pack' ),
					'arrows' => __( 'Arrows', 'bdthemes-element-pack' ),
					'dots'   => __( 'Dots', 'bdthemes-element-pack' ),
					'none'   => __( 'None', 'bdthemes-element-pack' ),
				],
				'prefix_class' => 'bdt-navigation-type-',
				'render_type'  => 'template',				
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_style',
			[
				'label' => esc_html__( 'Style', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quatation_heading',
			[
				'label'     => esc_html__( 'Quatation', 'bdthemes-element-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'quatation_color',
			[
				'label'     => esc_html__( 'Quatation Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-text:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'quatation_typography',
				'label'    => esc_html__( 'Quatation Typo', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-testimonial-text:before',
			]
		);

		$this->add_control(
			'text_heading',
			[
				'label' => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'separator' => 'before',
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Text Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-testimonial-text',
			]
		);

		$this->add_responsive_control(
			'text_cite_space',
			[
				'label' => __( 'Text and Cite Space', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label'     => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
				'condition' => ['title' => 'yes'],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-meta .bdt-testimonial-title' => 'color: {{VALUE}};',
				],
				'condition' => ['title' => 'yes'],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-testimonial-meta .bdt-testimonial-title',
				'condition' => ['title' => 'yes'],
			]
		);

		$this->add_control(
			'address_heading',
			[
				'label'     => esc_html__( 'Name/Address', 'bdthemes-element-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'company_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'address_color',
			[
				'label'     => esc_html__( 'Company Name/Address Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-meta .bdt-testimonial-address' => 'color: {{VALUE}};',
				],
				'condition' => [
					'company_name' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'address_typography',
				'label'    => esc_html__( 'Address Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-testimonial-meta .bdt-testimonial-address',
				'condition' => [
					'company_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_heading',
			[
				'label'     => esc_html__( 'Rating', 'bdthemes-element-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => esc_html__( 'Rating Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating .bdt-rating-item' => 'color: {{VALUE}};',
				],
				'condition' => [
					'rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => esc_html__( 'Active Rating Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-1 .bdt-rating-item:nth-child(1)'            => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-2 .bdt-rating-item:nth-child(-n+2)'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-3 .bdt-rating-item:nth-child(-n+3)'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-4 .bdt-rating-item:nth-child(-n+4)'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-rating.bdt-rating-5 .bdt-rating-item:nth-child(-n+5)'         => 'color: {{VALUE}};',
				],
				'condition' => [
					'rating' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_thumb',
			[
				'label'     => __( 'Skin Style', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'heading_testimonial',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Testimonial', 'bdthemes-element-pack' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'testimonial_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-item-inner'                                     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-slider li.bdt-slider-thumbnav .bdt-slider-thumbnav-inner:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'testimonial_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-item-inner' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'testimonial_shadow',
				'label'       => esc_html__( 'Shadow', 'bdthemes-element-pack' ),
				'selector' => '{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-item-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'testimonial_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-item-inner',
			]
		);

		$this->add_control(
			'testimonial_border_radius',
			[
				'label'      => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_thumb',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Thumb', 'bdthemes-element-pack' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'hide_arrow_style',
			[
				'label'        => esc_html__( 'Hide Arrow Style', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-arrow-style-hide-',
			]
		);

		$this->add_control(
			'thumb_opacity',
			[
				'label' => __( 'Opacity', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.05,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.8,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-thumbnav-inner img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'thumb_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-thumbnav-inner img',
			]
		);

		$this->add_control(
			'thumb_border_radius',
			[
				'label'      => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-thumbnav-inner img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'active_thumb_opacity',
			[
				'label' => __( 'Active Opacity', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.05,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-active .bdt-slider-thumbnav-inner img' => 'opacity: {{SIZE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'active_thumb_border_color',
			[
				'label'     => __( 'Active Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-active .bdt-slider-thumbnav-inner img' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'thumb_border_border!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'      => __( 'Navigation', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => '_skin',
							'value' => '',
						],
						[
							'name'     => 'navigation',
							'operator' => '!=',
							'value'    => 'none',
						],
					],
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev svg, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev:hover, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev svg, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Arrows Hover Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev:hover svg, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'margin-left: {{SIZE}}px;',
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev, {{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-dotnav a' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-dotnav a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-slider-dotnav.bdt-active a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'right: {{SIZE}}px;',
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-navigation-next' => 'right: {{SIZE}}px;',
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
					'{{WRAPPER}} .bdt-testimonial-slider .bdt-dots-container' => 'transform: translateY({{SIZE}}px);',
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

		$this->end_controls_section();
	}

	public function query_posts() {

		$settings = $this->get_settings();

		$args = array(
			'post_type'      => 'bdthemes-testimonial',
			'posts_per_page' => $settings['posts'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'post_status'    => 'publish'
		);

		if ( 'by_name' === $settings['source'] and !empty($settings['post_categories']) ) {			  
			$args['tax_query'][] = array(
				'taxonomy' => 'testimonial_categories',
				'field'    => 'slug',
				'terms'    => $settings['post_categories'],
			);
		}

		$this->_query = new \WP_Query( $args );
	}

	public function get_query() {
		return $this->_query;
	}

	public function render_header($skin, $id, $settings) {
		
		$this->add_render_attribute( 'testimonial-slider', 'id', 'bdt-testimonial-slider-' . $id );
		$this->add_render_attribute( 'testimonial-slider', 'class', ['bdt-testimonial-slider', 'bdt-testimonial-slider-skin-' . esc_attr($skin)] );

		?>

		<div <?php echo $this->get_render_attribute_string( 'testimonial-slider' ); ?>>
		<?php


		$slider_settings['bdt-slider'] = json_encode(array_filter([
			'autoplay'          => $settings['autoplay'],
			'autoplay-interval' => $settings['autoplay_interval'],
			'finite'            => ('yes' === $settings['loop']) ? 'false' : 'true',
			'pause-on-hover'    => ('yes' === $settings['pause_on_hover']) ? 'true' : 'false',
	    ]));


	    if ('both' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'bdt-arrows-dots-align-'. $settings['both_position'];
		} elseif ('arrows' == $settings['navigation'] or 'arrows-thumbnavs' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'bdt-arrows-align-'. $settings['arrows_position'];
		} elseif ('dots' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'bdt-dots-align-'. $settings['dots_position'];
		}

		?>
		<div <?php echo \element_pack_helper::attrs($slider_settings); ?>>
			<ul class="bdt-slider-items bdt-child-width-1-1 bdt-grid bdt-grid-match" bdt-grid>
		<?php
	}

	public function render_footer($settings) {

		?>
			</ul>
			<?php if ('both' == $settings['navigation']) : ?>
				<?php $this->render_both_navigation($settings); ?>

				<?php if ( 'center' === $settings['both_position'] ) : ?>
					<?php $this->render_dotnavs($settings); ?>
				<?php endif; ?>

			<?php elseif ('arrows' == $settings['navigation']) : ?>
				<?php $this->render_navigation($settings); ?>
			<?php elseif ('dots' == $settings['navigation']) : ?>
				<?php $this->render_dotnavs($settings); ?>
			<?php endif; ?>
		</div>
	</div>
	<?php
	}

	public function render_navigation($settings) {

		if (('both' == $settings['navigation']) and ('center' == $settings['both_position'])) {
			$arrows_position = 'center';
		} else {
			$arrows_position = $settings['arrows_position'];
		}

		?>
		<div class="bdt-position-z-index bdt-visible@m bdt-position-<?php echo esc_attr($arrows_position); ?>">
			<div class="bdt-arrows-container bdt-slidenav-container">
				<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9" bdt-slider-item="previous"></a>
				<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9" bdt-slider-item="next"></a>
			</div>
		</div>
		<?php
	}

	public function render_dotnavs($settings) {

		if (('both' == $settings['navigation']) and ('center' == $settings['both_position'])) {
			$dots_position = 'bottom-center';
		} else {
			$dots_position = $settings['dots_position'];
		}

		?>
		<div class="bdt-position-z-index bdt-visible@m bdt-position-<?php echo esc_attr($dots_position); ?>">
			<div class="bdt-dotnav-wrapper bdt-dots-container">
				<ul class="bdt-dotnav bdt-flex-center">

				    <?php		
					$bdt_counter = 0;

					$this->query_posts();

					$wp_query = $this->get_query();

					while ( $wp_query->have_posts() ) : $wp_query->the_post();
					      
						echo '<li class="bdt-slider-dotnav bdt-active" bdt-slider-item="'.$bdt_counter.'"><a href="#"></a></li>';
						$bdt_counter++;

					endwhile;
					wp_reset_postdata(); ?>

				</ul>
			</div>
		</div>
		<?php
	}

	public function render_both_navigation($settings) {
		?>
		<div class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="bdt-arrows-dots-container bdt-slidenav-container ">
				
				<div class="bdt-flex bdt-flex-middle">
					<div>
						<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9" bdt-slider-item="previous"></a>						
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="bdt-dotnav-wrapper bdt-dots-container">
							<ul class="bdt-dotnav">
							    <?php		
								$bdt_counter = 0;

								$this->query_posts();

								$wp_query = $this->get_query();

								while ( $wp_query->have_posts() ) : $wp_query->the_post();								      
									echo '<li class="bdt-slider-dotnav bdt-active" bdt-slider-item="'.$bdt_counter.'"><a href="#"></a></li>';
									$bdt_counter++;
								endwhile; ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<div>
						<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9" bdt-slider-item="next"></a>						
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

    	$rating_align = ($settings['thumb']) ? '' : ' bdt-flex-center';

		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}
			$this->render_header('default', $id, $settings);
		?>
			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

		  		<li class="bdt-slider-item">

                	<div class="bdt-testimonial-text"><?php the_excerpt(); ?></div>
                	
                		<div class="bdt-flex bdt-flex-center bdt-flex-middle">

	                    <?php if('yes' == $settings['thumb']) : ?>
                        	<div><div class="bdt-testimonial-thumb"><?php echo  the_post_thumbnail('medium', array('class' => ''));  ?></div></div>
	                    <?php endif ?>

	                    <?php if (('yes' == $settings['title']) or ('yes' == $settings['company_name']) or ('yes' == $settings['rating'])) : ?>
						    <div class="bdt-testimonial-meta">
		                        <?php if ('yes' == $settings['title']) : ?>
		                            <div class="bdt-testimonial-title"><?php echo esc_attr(get_the_title()); ?></div>
		                        <?php endif ?>

		                        <?php if ( 'yes' == $settings['company_name']) : ?>
		                        	<?php $separator = (( 'yes' == $settings['title'] ) and ( 'yes' == $settings['company_name'] )) ? ', ' : ''?>
		                            <span class="bdt-testimonial-address"><?php echo esc_attr( $separator ).get_post_meta(get_the_ID(), 'bdthemes_tm_company_name', true); ?></span>
		                        <?php endif ?>
		                        
		                        <?php if ('yes' == $settings['rating']) : ?>
		                            <ul class="bdt-rating bdt-rating-<?php echo get_post_meta(get_the_ID(), 'bdthemes_tm_rating', true); ?> bdt-grid bdt-grid-collapse<?php echo esc_attr($rating_align); ?>">
					                    <li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
										<li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
										<li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
										<li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
										<li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
					                </ul>
		                        <?php endif ?>

		                    </div>
		                <?php endif ?>

	                </div>
                </li>
		  
			<?php endwhile;
			wp_reset_postdata();
			
		$this->render_footer($settings);
	}
}
