<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Order_Details_Widget extends \Elementor\Widget_Base {

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
		return 'order_details';
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
		return esc_html__( 'Order Details', 'woocommerce-builder-elementor' );
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
				'selector'  => '{{WRAPPER}} .woocommerce-order-details .woocommerce-order-details__title',
			)
		);
		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details .woocommerce-order-details__title' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .woocommerce-order-details .woocommerce-order-details__title' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		
		// order_item
		$this->start_controls_section(
			'order_item_style',
			array(
				'label' => esc_html__( 'Order Item', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->start_controls_tabs( 'order_item_style_tabs' );
		//product_name
		$this->start_controls_tab( 'product_name_style',
			[
				'label' => esc_html__( 'Product Name', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'product_name_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-table--order-details .order_item .product-name',
			)
		);
		$this->add_control(
			'product_name_color',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-table--order-details .order_item .product-name a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'product_quantity_color',
			[
				'label' => esc_html__( 'Quantity Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-table--order-details .order_item .product-name .product-quantity' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		//product_total
		$this->start_controls_tab( 'product_total_style',
			[
				'label' => esc_html__( 'Product Total', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'product_total_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-table--order-details .order_item .product-total',
			)
		);
		$this->add_control(
			'product_total_color',
			[
				'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-table--order-details .order_item .product-total' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		
		// Total
		$this->start_controls_section(
			'total_style_section',
			array(
				'label' => esc_html__( 'Total', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->start_controls_tabs( 'total_style_tabs' );
		//total label
		$this->start_controls_tab( 'total_label_style',
			[
				'label' => esc_html__( 'Label', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'total_label_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-table--order-details tfoot th',
			)
		);
		$this->add_control(
			'total_label_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-table--order-details tfoot th' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		//total
		$this->start_controls_tab( 'total_style',
			[
				'label' => esc_html__( 'Total', 'woocommerce-builder-elementor' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'total_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} tfoot td',
			)
		);
		$this->add_control(
			'total_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-table--order-details tfoot td' => 'color: {{VALUE}}',
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
		
			global $wp;
			
			if( isset($wp->query_vars['order-received']) ){
				$dtwcbe_order_received = $wp->query_vars['order-received'];
			}else{
				$dtwcbe_order_received = dtwcbe_get_last_order_id();
			}
			
			if( !$dtwcbe_order_received ){
				return;
			}
			
			$order = wc_get_order( $dtwcbe_order_received );
			$order_id = $order->get_id();
			
			
			if ( ! $order = wc_get_order( $order_id ) ) {
				return;
			}
			
			$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
			$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
			$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
			$downloads             = $order->get_downloadable_items();
			$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();
			
			if ( $show_downloads ) {
				wc_get_template( 'order/order-downloads.php', array( 'downloads' => $downloads, 'show_title' => true ) );
			}
			?>
			<section class="woocommerce-order-details">
				<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
			
				<h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Order details', 'woocommerce-builder-elementor' ); ?></h2>
			
				<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
			
					<thead>
						<tr>
							<th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocommerce-builder-elementor' ); ?></th>
							<th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce-builder-elementor' ); ?></th>
						</tr>
					</thead>
			
					<tbody>
						<?php
						do_action( 'woocommerce_order_details_before_order_table_items', $order );
			
						foreach ( $order_items as $item_id => $item ) {
							$product = $item->get_product();
			
							wc_get_template( 'order/order-details-item.php', array(
								'order'			     => $order,
								'item_id'		     => $item_id,
								'item'			     => $item,
								'show_purchase_note' => $show_purchase_note,
								'purchase_note'	     => $product ? $product->get_purchase_note() : '',
								'product'	         => $product,
							) );
						}
			
						do_action( 'woocommerce_order_details_after_order_table_items', $order );
						?>
					</tbody>
			
					<tfoot>
						<?php
							foreach ( $order->get_order_item_totals() as $key => $total ) {
								?>
								<tr>
									<th scope="row"><?php echo $total['label']; ?></th>
									<td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : $total['value']; ?></td>
								</tr>
								<?php
							}
						?>
						<?php if ( $order->get_customer_note() ) : ?>
							<tr>
								<th><?php esc_html_e( 'Note:', 'woocommerce-builder-elementor' ); ?></th>
								<td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
							</tr>
						<?php endif; ?>
					</tfoot>
				</table>
			
				<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
			</section>
			
			<?php
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Order_Details_Widget());
