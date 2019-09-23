<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Form_Shipping_Widget extends \Elementor\Widget_Base {

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
		return 'form-shipping';
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
		return esc_html__( 'Checkout Form Shipping', 'woocommerce-builder-elementor' );
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
				'selector'  => '{{WRAPPER}} .woocommerce-shipping-fields #ship-to-different-address',
			)
		);
		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-shipping-fields #ship-to-different-address' => 'color: {{VALUE}}',
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
				'prefix_class' => '',
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-shipping-fields #ship-to-different-address' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		
		// label
		$this->start_controls_section(
			'label_style',
			array(
				'label' => esc_html__( 'Label', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'label_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper .form-row label',
			)
		);
		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper .form-row label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'label_required_color',
			[
				'label' => esc_html__( 'Required Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper .form-row label abbr' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'label_align',
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
				'prefix_class' => '',
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper .form-row label' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		
		// Input Fields
		$this->start_controls_section(
			'input_style',
			array(
				'label' => esc_html__( 'Input', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'input_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input , {{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper textarea',
			)
		);
		$this->add_responsive_control(
			'input_padding',
			[
				'label' => esc_html__( 'Padding', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input, {{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->start_controls_tabs( 'tabs_input_style' );
		$this->start_controls_tab(
			'tab_input_normal',
			[
				'label' => esc_html__( 'Normal', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_control(
			'input_color',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'input_border',
				'selector' => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text',
				'exclude' => [ 'color' ],
			]
		);
		
		$this->add_control(
			'input_border_color',
			[
				'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'input_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_box_shadow',
				'selector' => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text',
			]
		);
		$this->end_controls_tab();
		// Focus
		$this->start_controls_tab(
			'tab_input_focus',
			[
				'label' => esc_html__( 'Focus', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_control(
			'input_focus_color',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text:focus' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'input_focus_border',
				'selector' => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text:focus',
				'exclude' => [ 'color' ],
			]
		);
		
		$this->add_control(
			'input_focus_border_color',
			[
				'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text:focus' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'input_focus_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_focus_box_shadow',
				'selector' => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper input.input-text:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		
		
		// Select style
		$this->start_controls_section(
			'select_style',
			array(
				'label' => esc_html__( 'Select', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'select_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select',
			)
		);
		$this->add_responsive_control(
			'select_padding',
			[
				'label' => esc_html__( 'Padding', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->start_controls_tabs( 'tabs_select_style' );
		$this->start_controls_tab(
			'tab_select_normal',
			[
				'label' => esc_html__( 'Normal', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_control(
			'select_color',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'select_border',
				'selector' => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select',
				'exclude' => [ 'color' ],
			]
		);
		
		$this->add_control(
			'select_border_color',
			[
				'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'select_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'select_box_shadow',
				'selector' => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select',
			]
		);
		$this->end_controls_tab();
		// Focus
		$this->start_controls_tab(
			'tab_select_focus',
			[
				'label' => esc_html__( 'Focus', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_control(
			'select_focus_color',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select:focus' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'select_focus_border',
				'selector' => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select:focus',
				'exclude' => [ 'color' ],
			]
		);
		
		$this->add_control(
			'select_focus_border_color',
			[
				'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select:focus' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'select_focus_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'select_focus_box_shadow',
				'selector' => '{{WRAPPER}} .shipping_address .woocommerce-shipping-fields__field-wrapper select:focus',
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
		if( $post_type == DTWCBE_Post_Types::post_type() ) {
			$checkout = WC()->checkout();
			if ( sizeof( $checkout->checkout_fields ) > 0 ) { ?>
			<div class="woocommerce-shipping-fields">
					<h3 id="ship-to-different-address">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
							<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></span>
						</label>
					</h3>
			
					<div class="shipping_address">
			
						<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>
			
						<div class="woocommerce-shipping-fields__field-wrapper">
							<?php
								$fields = $checkout->get_checkout_fields( 'shipping' );
			
								foreach ( $fields as $key => $field ) {
									if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
										$field['country'] = $checkout->get_value( $field['country_field'] );
									}
									woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
								}
							?>
						</div>
			
						<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
			
					</div>
			</div>
			<?php
			}
		}elseif ( is_checkout() ){
			$checkout = WC()->checkout();
			if ( sizeof( $checkout->checkout_fields ) > 0 ) { ?>
			<div class="woocommerce-shipping-fields">
				<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
			
					<h3 id="ship-to-different-address">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
							<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></span>
						</label>
					</h3>
			
					<div class="shipping_address">
			
						<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>
			
						<div class="woocommerce-shipping-fields__field-wrapper">
							<?php
								$fields = $checkout->get_checkout_fields( 'shipping' );
			
								foreach ( $fields as $key => $field ) {
									if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
										$field['country'] = $checkout->get_value( $field['country_field'] );
									}
									woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
								}
							?>
						</div>
			
						<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
			
					</div>
			
				<?php endif; ?>
			</div>
			<?php
			}
		}
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Form_Shipping_Widget());
