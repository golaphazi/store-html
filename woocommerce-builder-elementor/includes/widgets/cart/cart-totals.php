<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Cart_Totals_Widget extends \Elementor\Widget_Base {

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
		return 'cart-totals';
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
		return esc_html__( 'Cart Totals', 'woocommerce-builder-elementor' );
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
		return [ 'dtwcbe-woo-cart' ];
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
		
		// Heading
		$this->start_controls_section(
			'heading_style',
			array(
				'label' => esc_html__( 'Heading', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'heading_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .cart_totals > h2',
			)
		);
		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart_totals > h2' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'heading_align',
			[
				'label'        => esc_html__( 'Alignment', 'woocommerce-builder-elementor' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'woocommerce-builder-elementor' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'woocommerce-builder-elementor' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'woocommerce-builder-elementor' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} .cart_totals > h2' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		
		// Cart Totals
		$this->start_controls_section(
			'cart_totals_table_style',
			array(
				'label' => esc_html__( 'Cart Totals Table', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'art_totals_table_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart_totals' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'cart_totals_table_border',
				'selector' => '{{WRAPPER}} .cart_totals .shop_table tr th, {{WRAPPER}} .cart_totals .shop_table tr td',
				'exclude' => [ 'color' ],
			]
		);
		
		$this->add_control(
			'cart_totals_table_border_color',
			[
				'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{WRAPPER}} .cart_totals .shop_table tr th, {{WRAPPER}} .cart_totals .shop_table tr td' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'cart_totals_table_padding',
			[
				'label' => esc_html__( 'Padding', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} {{WRAPPER}} .cart_totals .shop_table tr th, {{WRAPPER}} .cart_totals .shop_table tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'cart_totals_table_align',
			[
				'label'        => esc_html__( 'Alignment', 'woocommerce-builder-elementor' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'woocommerce-builder-elementor' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'woocommerce-builder-elementor' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'woocommerce-builder-elementor' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => 'left',
				'selectors' => [
					'{{WRAPPER}} .cart_totals .shop_table tr th, {{WRAPPER}} .cart_totals .shop_table tr td' => 'text-align: {{VALUE}}',
				],
			]
		);
		
		$this->start_controls_tabs( 'cart_totals_table_style_tabs' );
		
		$this->start_controls_tab( 'cart_totals_table_heading',
			[
				'label' => esc_html__( 'Heading', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'cart_totals_table_heading_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .cart_totals .shop_table tr th',
			)
		);
		$this->add_control(
			'cart_totals_table_heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart_totals .shop_table tr th' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'cart_totals_table_subtotal',
			[
				'label' => esc_html__( 'Subtotal', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'cart_totals_table_subtotal_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .cart_totals .shop_table tr.cart-subtotal td',
			)
		);
		$this->add_control(
			'cart_totals_table_subtotal_color',
			[
				'label' => esc_html__( 'Subtotal Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart_totals .shop_table tr.cart-subtotal td' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'cart_totals_table_total',
			[
				'label' => esc_html__( 'Total', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'cart_totals_table_total_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .cart_totals .shop_table tr.order-total th',
			)
		);
		$this->add_control(
			'cart_totals_table_total_color',
			[
				'label' => esc_html__( 'Total Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart_totals .shop_table tr.order-total td' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();
		
		
		// Checkout button
		$this->start_controls_section(
			'section_checkout_button_style',
			array(
				'label' => esc_html__( 'Checkout Button', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'checkout_button_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'checkout_button_border',
				'selector' => '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button',
				'exclude' => [ 'color' ],
			]
		);
		$this->add_responsive_control(
			'checkout_button_padding',
			[
				'label' => esc_html__( 'Padding', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		/////
		$this->start_controls_tabs( 'checkout_button_style_tabs' );
		
		$this->start_controls_tab( 'checkout_button_style_normal',
			[
				'label' => esc_html__( 'Normal', 'woocommerce-builder-elementor' ),
			]
		);
		
		$this->add_control(
			'checkout_button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'color: {{VALUE}}  !important',
				],
			]
		);
		
		$this->add_control(
			'checkout_button_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'checkout_button_border_color',
			[
				'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'checkout_button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'checkout_button_box_shadow',
				'selector' => '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button',
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'checkout_button_style_hover',
			[
				'label' => esc_html__( 'Hover', 'woocommerce-builder-elementor' ),
			]
		);
		
		$this->add_control(
			'checkout_button_text_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover' => 'color: {{VALUE}}  !important',
				],
			]
		);
		
		$this->add_control(
			'checkout_button_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'checkout_button_border_color_hover',
			[
				'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'checkout_button_border_radius_hover',
			[
				'label' => esc_html__( 'Border Radius', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'checkout_button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover',
			]
		);
		$this->add_control(
			'checkout_button_transition',
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
					'{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'transition: all {{SIZE}}s',
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
		woocommerce_cart_totals();
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Cart_Totals_Widget());
