<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Upsells_Widget extends DTWCBE_Product_Base {

	public function get_name() {
		return 'single-product-upsells';
	}

	public function get_title() {
		return esc_html__( 'Woo Product Upsells', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-upsell';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'upsells' , 'product' , 'single product' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_upsells',
			[
				'label' => esc_html__( 'Upsells', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'prefix_class' => 'woocommerce-builder-elementorducts-columns%s-',
				'default' => 4,
				'min' => 1,
				'max' => 12,
			]
		);
		
		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Orderby', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'rand',
				'options' => [
					'date' => esc_html__( 'Date', 'woocommerce-builder-elementor' ),
					'title' => esc_html__( 'Title', 'woocommerce-builder-elementor' ),
					'price' => esc_html__( 'Price', 'woocommerce-builder-elementor' ),
					'popularity' => esc_html__( 'Popularity', 'woocommerce-builder-elementor' ),
					'rating' => esc_html__( 'Rating', 'woocommerce-builder-elementor' ),
					'rand' => esc_html__( 'Random', 'woocommerce-builder-elementor' ),
					'menu_order' => esc_html__( 'Menu Order', 'woocommerce-builder-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'desc' => esc_html__( 'DESC', 'woocommerce-builder-elementor' ),
					'asc' => esc_html__( 'ASC', 'woocommerce-builder-elementor' ),
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'show_heading',
			[
				'label' => esc_html__( 'Heading', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'woocommerce-builder-elementor' ),
				'label_on' => esc_html__( 'Show', 'woocommerce-builder-elementor' ),
				'default' => 'yes',
				'return_value' => 'yes',
				'prefix_class' => 'show-heading-',
			]
		);
		
		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}}.dtwcbe-elementor-wc-products .products > h2' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}.dtwcbe-elementor-wc-products .products > h2',
				'condition' => [
					'show_heading!' => '',
				],
			]
		);
		
		$this->add_responsive_control(
			'heading_text_align',
			[
				'label' => esc_html__( 'Text Align', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'woocommerce-builder-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'woocommerce-builder-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'woocommerce-builder-elementor' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}.dtwcbe-elementor-wc-products .products > h2' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);
		
		$this->add_responsive_control(
			'heading_spacing',
			[
				'label' => esc_html__( 'Spacing', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}.dtwcbe-elementor-wc-products .products > h2' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);
		
		$this->end_controls_section();
		
		parent::_register_controls();
		
	}
	
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$post_type = get_post_type();
			
		echo DTWCBE_Single_Product_Elementor::_render( $this->get_name(), $settings );
			
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Upsells_Widget());