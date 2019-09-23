<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Payment_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'checkout-payment';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Checkout Payment', 'woocommerce-builder-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-woocommerce';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'dtwcbe-woo-checkout' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		// payment_methods
		$this->start_controls_section(
			'payment_style',
			array(
				'label' => esc_html__( 'Payment', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'payment_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} #payment',
			)
		);
		$this->add_control(
			'payment_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		
		// Place order
		$this->start_controls_section(
			'place_order_style',
			array(
				'label' => esc_html__( 'Button', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'place_order_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} #payment #place_order',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'place_order_border',
				'selector' => '{{WRAPPER}} #order_review #place_order',
				'exclude' => [ 'color' ],
			]
		);
		$this->add_responsive_control(
			'place_order_padding',
			[
				'label' => esc_html__( 'Padding', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #payment #place_order' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		/////
		$this->start_controls_tabs( 'place_order_style_tabs' );
		
		$this->start_controls_tab( 'place_order_style_normal',
			[
				'label' => esc_html__( 'Normal', 'woocommerce-builder-elementor' ),
			]
		);
		
		$this->add_control(
			'place_order_text_color',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment #place_order' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'place_order_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment #place_order' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'place_order_border_color',
			[
				'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment #place_order' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'place_order_box_shadow',
				'selector' => '{{WRAPPER}} #payment #place_order',
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'place_order_style_hover',
			[
				'label' => esc_html__( 'Hover', 'woocommerce-builder-elementor' ),
			]
		);
		
		$this->add_control(
			'place_order_text_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment #place_order:hover' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'place_order_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment #place_order:hover' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'place_order_border_color_hover',
			[
				'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment #place_order:hover' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'place_order_box_shadow_hover',
				'selector' => '{{WRAPPER}} #payment #place_order:hover',
			]
		);
		
		$this->add_control(
			'place_order_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.2,
				],
				'range' => [
					'px' => [
						'max' => 2,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} #payment #place_order' => 'transition: all {{SIZE}}s',
				],
			]
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$post_type = get_post_type();
		if( is_checkout() ){
			if ( ! is_ajax() ){
				do_action( 'woocommerce_review_order_before_payment' );
			}
			
				woocommerce_checkout_payment();
			
			if ( ! is_ajax() ){
				do_action( 'woocommerce_review_order_after_payment' );
			}
		}elseif( $post_type == DTWCBE_Post_Types::post_type() ){
			woocommerce_checkout_payment();
		}
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Payment_Widget());
