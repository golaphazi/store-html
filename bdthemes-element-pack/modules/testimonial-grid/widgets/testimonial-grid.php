<?php
namespace ElementPack\Modules\TestimonialGrid\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Testimonial_Grid extends Widget_Base {

	public function get_name() {
		return 'bdt-testimonial-grid';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Grid', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'tilt', 'bdt-uikit-icons' ];
	}

	public function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Default', 'bdthemes-element-pack' ),
					'2' => esc_html__( 'Top Avatar', 'bdthemes-element-pack' ),
					'3' => esc_html__( 'Reverse', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '2',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid > .bdt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-testimonial-grid > .bdt-grid > *' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid > .bdt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-testimonial-grid > .bdt-grid > *' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'   => esc_html__( 'Testimonial Image', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_address',
			[
				'label'   => esc_html__( 'Address', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_text',
			[
				'label'   => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'text_limit',
			[
				'label'     => esc_html__( 'Text Limit', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 25,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'   => esc_html__( 'Rating', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_filter_bar',
			[
				'label' => esc_html__( 'Filter Bar', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'item_match_height',
			[
				'label' => esc_html__( 'Match Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'item_masonry',
			[
				'label' => esc_html__( 'Masonry', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
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
				'default' => 4,
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
			'section_style_item',
			[
				'label' => esc_html__( 'Item', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_item_style' );

		$this->start_controls_tab(
			'tab_item_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-item-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-item-inner',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-item-inner',
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'item_hover_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-item-inner:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-item-inner:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-item-inner:hover',
			]
		);
		
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label'     => esc_html__( 'Image', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-img-wrapper',
				'separator'   => 'before',
			]
		);
		
		$this->add_control(
			'image_hover_border_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'image_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-img-wrapper:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-img-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-img-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_address',
			[
				'label'     => esc_html__( 'Address', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_address' => 'yes',
				],
			]
		);

		$this->add_control(
			'address_color',
			[
				'label'     => esc_html__( 'Company Name/Address Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-address' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'address_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-address' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'address_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-address',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label'     => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-testimonial-grid .bdt-testimonial-grid-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_rating',
			[
				'label'     => esc_html__( 'Rating', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-rating .bdt-rating-item' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => esc_html__( 'Active Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-rating.bdt-rating-1 .bdt-rating-item:nth-child(1)'            => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-rating.bdt-rating-2 .bdt-rating-item:nth-child(-n+2)'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-rating.bdt-rating-3 .bdt-rating-item:nth-child(-n+3)'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-rating.bdt-rating-4 .bdt-rating-item:nth-child(-n+4)'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-rating.bdt-rating-5 .bdt-rating-item:nth-child(-n+5)'         => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-testimonial-grid .bdt-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_filter',
			[
				'label'     => esc_html__( 'Filter Bar', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter_bar' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'filter_align',
			[
				'label'        => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'center',
				'options'      => [
					'left'    => [
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
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'filter_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filter' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'active_filter_color',
			[
				'label'     => esc_html__( 'Active Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filter.bdt-active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filter_underline_color',
			[
				'label'     => esc_html__( 'Underline Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters .bdt-ep-grid-filter.bdt-active' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filter_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bdt-ep-grid-filter',
			]
		);

		$this->add_control(
			'filter_item_space',
			[
				'label'   => esc_html__( 'Space Between', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filter:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .bdt-ep-grid-filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_control(
			'filter_bottom_space',
			[
				'label'   => esc_html__( 'Bottom Space', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 80,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render_image( $image_id ) {
		$settings = $this->get_settings();
		
		if('yes' != $settings['show_image']) {
			return;
		}

		$testimonial_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $image_id ), 'medium' );

		?>
		<div>
			<div class="bdt-testimonial-grid-img-wrapper bdt-overflow-hidden bdt-border-circle bdt-background-cover">
				<img src="<?php echo esc_url($testimonial_thumb[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
			</div>
		</div>
		<?php
	}

	public function render_title( $post_id ) {
		$settings = $this->get_settings();

		if( 'yes' != $settings['show_title'] ) {
			return;
		}

		?>
		<h4 class="bdt-testimonial-grid-title bdt-margin-remove-bottom"><?php echo esc_attr(get_the_title( $post_id )); ?></h4>
		<?php
	}

	public function render_address( $post_id ) {
		$settings = $this->get_settings();

		if( 'yes' != $settings['show_address'] ) {
			return;
		}

		?>
        <p class="bdt-testimonial-grid-address bdt-text-meta bdt-margin-remove">
        	<?php echo get_post_meta( $post_id, 'bdthemes_tm_company_name', true ); ?>
    	</p>
		<?php
	}

	public function render_excerpt() {
		$settings = $this->get_settings();

		if( 'yes' != $settings['show_text'] ) {
			return;
		}

		?>
		<div class="bdt-testimonial-grid-text"><?php echo wp_kses_post(\element_pack_helper::custom_excerpt($settings['text_limit'])); ?></div>
		<?php
	}

	public function render_rating( $post_id ) {
		$settings = $this->get_settings();

		if( 'yes' != $settings['show_rating'] ) {
			return;
		}

		?>
		<div class="bdt-testimonial-grid-rating">
			<ul class="bdt-rating bdt-rating-<?php echo get_post_meta( $post_id, 'bdthemes_tm_rating', true ); ?> bdt-grid bdt-grid-collapse" bdt-grid>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
			</ul>
		</div>
		<?php
	}

	public function render_filter_menu() {
		$settings = $this->get_settings();
		global $post;

		if ('yes' !== $settings['show_filter_bar']) {
			return;
		}

		if ( !empty($settings['post_categories']) ) {
			$testimonial_categories = $settings['post_categories'];
		} else {					
			$testimonial_categories = get_terms( 'testimonial_categories' );
			$arraytostring = '';

			foreach( $testimonial_categories as $testimonial_categories ) :
				$arraytostring .= $testimonial_categories->slug . ',';
			endforeach;

			$arraytostring = rtrim( $arraytostring,',' ); // Remove last commata;
			$testimonial_categories = explode( ',', $arraytostring ); // Create array
		}
		
		?>
		<div class="bdt-ep-grid-filters-wrapper">
			<ul class="bdt-ep-grid-filters" bdt-margin>
				<li class="bdt-ep-grid-filter bdt-active" bdt-filter-control><?php esc_html_e( 'All', 'bdthemes-element-pack' ); ?></li>
		
				<?php foreach($testimonial_categories as $testimonial_categories => $value) : ?>
					<?php $filter_name = get_term_by('slug',$value,'testimonial_categories'); ?>
					<li class="bdt-ep-grid-filter" bdt-filter-control="[data-filter*='bdtf-<?php echo esc_attr(trim($value)); ?>']">
						<?php echo $filter_name->name; ?>
					</li>				
				<?php endforeach; ?>
			</ul>
		</div>
		<?php		
	}

	public function render_header() {
		$settings = $this->get_settings();

		$this->add_render_attribute('testimonial-grid-wrapper', 'class', ['bdt-testimonial-grid-layout-'.$settings['layout'], 'bdt-testimonial-grid', 'bdt-ep-grid-filter-container']);

		$this->add_render_attribute('testimonial-grid', 'bdt-grid', '');
		$this->add_render_attribute('testimonial-grid', 'class', 'bdt-grid');

		if ( 'yes' === $settings['show_filter_bar'] ) {
			$this->add_render_attribute('testimonial-grid-wrapper', 'bdt-filter', 'target: #bdt-testimonial-grid-' . $this->get_id());
		}

		if ( 'yes' === $settings['item_match_height'] ) {
			$this->add_render_attribute('testimonial-grid', 'bdt-height-match', 'div > .bdt-testimonial-grid-item-inner');
		}

		if ( 'yes' === $settings['item_masonry'] ) {
			$this->add_render_attribute('testimonial-grid', 'bdt-grid', 'masonry: true;');
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'testimonial-grid-wrapper' ); ?>>
	
		<?php $this->render_filter_menu(); ?>

		<div id="bdt-testimonial-grid-<?php echo $this->get_id(); ?>" <?php echo $this->get_render_attribute_string( 'testimonial-grid' ); ?>>
		<?php
	}

	public function render_footer() {
		$settings = $this->get_settings();

		?>
			</div>
		</div>
		<?php
	}

	public function render_query() {
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

		$wp_query = new \WP_Query($args);

		return $wp_query;
	}

	public function render_loop_item() {
		$settings = $this->get_settings();
		global $post;

		$wp_query = $this->render_query();

		if($wp_query->have_posts()) {			

			$this->add_render_attribute('testimonial-grid-item', 'class', 'bdt-testimonial-grid-item');

			$this->add_render_attribute('testimonial-grid-item', 'class', 'bdt-width-1-'. $settings['columns_mobile']);
			$this->add_render_attribute('testimonial-grid-item', 'class', 'bdt-width-1-'. $settings['columns_tablet'] .'@s');
			$this->add_render_attribute('testimonial-grid-item', 'class', 'bdt-width-1-'. $settings['columns'] .'@m');

			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

				<?php 

				if( $settings['show_filter_bar'] ) {
					$item_filters = get_the_terms( get_the_ID(), 'testimonial_categories' ); 
	    			foreach ($item_filters as $item_filter) {
	    				$this->add_render_attribute('testimonial-grid-item', 'data-filter', 'bdtf-' . $item_filter->slug, true);
	    			}
	    		}
	    		?>

		  		<div <?php echo $this->get_render_attribute_string( 'testimonial-grid-item' ); ?>>
	  				<?php if ('1' == $settings['layout']) : ?>
			  			<div class="bdt-testimonial-grid-item-inner">
				  			<div class="bdt-grid bdt-position-relative bdt-grid-small bdt-flex-middle" bdt-grid>
				               <?php $this->render_image( $post->ID ); ?>
			               		<?php if (( 'yes' == $settings['show_title'] ) || ( 'yes' == $settings['show_address'] )) : ?>
				           			<div class="bdt-testimonial-grid-title-address">
						               <?php
						               $this->render_title( $post->ID );
						               $this->render_address( $post->ID );
						              
						              if ('yes' == $settings['show_rating']) : ?>
					               			<?php if ('3' <= $settings['columns']) : ?>
						           				<?php $this->render_rating( $post->ID ); ?>
						                	<?php endif; ?>
					                	
					               			<?php if ('2' >= $settings['columns']) : ?>
									           	<div class="bdt-position-center-right">
								           			<?php $this->render_rating( $post->ID ); ?>
									           	</div>
						                	<?php endif; ?>
				                		<?php endif; ?>

						           	</div>
			                	<?php endif; ?>
			            	</div>
			          		<?php $this->render_excerpt(); ?>
						</div>
					<?php endif; ?>

					<?php if ('2' == $settings['layout']) : ?>
			  			<div class="bdt-testimonial-grid-item-inner bdt-position-relative bdt-text-center">
			               <div class=""><?php $this->render_image( $post->ID ); ?></div>
		               		<?php if (( 'yes' == $settings['show_title'] ) || ( 'yes' == $settings['show_address'] )) : ?>
			           			<div class="bdt-testimonial-grid-title-address">
					               <?php
					               $this->render_title( $post->ID );
					               $this->render_address( $post->ID );
					               ?>
					           	</div>
		                	<?php endif; ?>			          
		          			<?php $this->render_excerpt(); ?>
		           			<?php $this->render_rating( $post->ID ); ?>			            
						</div>
					<?php endif; ?>

					<?php if ('3' == $settings['layout']) : ?>
			  			<div class="bdt-testimonial-grid-item-inner">
			          		<?php $this->render_excerpt(); ?>
				  			<div class="bdt-grid bdt-position-relative bdt-grid-small bdt-flex-middle" bdt-grid>
				               <?php $this->render_image( $post->ID ); ?>
			               		<?php if (( 'yes' == $settings['show_title'] ) || ( 'yes' == $settings['show_address'] )) : ?>
				           			<div class="bdt-testimonial-grid-title-address">
						               <?php
						               $this->render_title( $post->ID );
						               $this->render_address( $post->ID );
						               
						               if ('yes' == $settings['show_rating']) : ?>
					               			<?php if ('3' <= $settings['columns']) : ?>
						           				<?php $this->render_rating( $post->ID ); ?>
						                	<?php endif; ?>

					               			<?php if ('2' >= $settings['columns']) : ?>
									           	<div class="bdt-position-center-right">
								           			<?php $this->render_rating( $post->ID ); ?>
									           	</div>
						                	<?php endif; ?>
					                	<?php endif; ?>

						           	</div>
			                	<?php endif; ?>
			            	</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endwhile;
			wp_reset_postdata();

		} else {
			echo '<div class="bdt-alert-warning" bdt-alert>Oppps!! There is no post, please select actual post or categories.<div>';
		}
	}

	public function render() {
		$this->render_header();
		$this->render_loop_item();
		$this->render_footer();
	}
}
