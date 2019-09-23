<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Thankyou_Widget extends \Elementor\Widget_Base {

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
		return 'thankyou';
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
		return esc_html__( 'Thank You Order', 'woocommerce-builder-elementor' );
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
		return [ 'dtwcbe-woo-thankyou' ];
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
		$this->start_controls_section(
			'order_received_section',
			[
				'label' => esc_html__( 'Order Received', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'order_received_text',
			[
				'label'     => esc_html__( 'Order Received Text', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Thank you. Your order has been received.', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'order_received_text_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-thankyou-order-received',
			)
		);
		$this->add_control(
			'order_received_text_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-thankyou-order-received' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'order_received_text_align',
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
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-thankyou-order-received' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		
		// order_received style
		$this->start_controls_section(
			'order_received_overview_style',
			array(
				'label' => esc_html__( 'Label', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'order_received_overview_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} ul.order_details li',
			)
		);
		$this->add_control(
			'order_received_overview_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.order_details li' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'order_received_overview_align',
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
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} ul.order_details li' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'order_received_details_style',
			array(
				'label' => esc_html__( 'Details', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'order_received_details_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} ul.order_details li strong',
			)
		);
		$this->add_control(
			'order_received_details_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.order_details li strong' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'order_received_details_align',
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
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} ul.order_details li strong' => 'text-align: {{VALUE}};',
				],
			]
		);
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
		global $wp;
		
		$settings = $this->get_settings_for_display();
		$order_received_text = $settings['order_received_text'];
		
		if( isset($wp->query_vars['order-received']) ){
			$dtwcbe_order_received = $wp->query_vars['order-received'];
		}else{
			$dtwcbe_order_received = dtwcbe_get_last_order_id();
		}
		
		$order = wc_get_order( $dtwcbe_order_received );
		?>
		
		<?php if ( $order ) : ?>

			<?php if ( $order->has_status( 'failed' ) ) : ?>
		
				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce-builder-elementor' ); ?></p>
		
				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce-builder-elementor' ) ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce-builder-elementor' ); ?></a>
					<?php endif; ?>
				</p>
		
			<?php else : ?>
		
				<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', $order_received_text, $order ); ?></p>
		
				<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
		
					<li class="woocommerce-order-overview__order order">
						<?php esc_html_e( 'Order number:', 'woocommerce-builder-elementor' ); ?>
						<strong><?php echo $order->get_order_number(); ?></strong>
					</li>
		
					<li class="woocommerce-order-overview__date date">
						<?php esc_html_e( 'Date:', 'woocommerce-builder-elementor' ); ?>
						<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
					</li>
		
					<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
						<li class="woocommerce-order-overview__email email">
							<?php esc_html_e( 'Email:', 'woocommerce-builder-elementor' ); ?>
							<strong><?php echo $order->get_billing_email(); ?></strong>
						</li>
					<?php endif; ?>
		
					<li class="woocommerce-order-overview__total total">
						<?php esc_html_e( 'Total:', 'woocommerce-builder-elementor' ); ?>
						<strong><?php echo $order->get_formatted_order_total(); ?></strong>
					</li>
		
					<?php if ( $order->get_payment_method_title() ) : ?>
						<li class="woocommerce-order-overview__payment-method method">
							<?php esc_html_e( 'Payment method:', 'woocommerce-builder-elementor' ); ?>
							<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
						</li>
					<?php endif; ?>
		
				</ul>
		
			<?php endif; ?>
		
			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		
		<?php else : ?>
		
			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', $order_received_text, null ); ?></p>
		
		<?php endif; ?>
		
		<?php
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Thankyou_Widget());
