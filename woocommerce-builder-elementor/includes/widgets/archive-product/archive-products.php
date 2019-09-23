<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Product_Archive_Products_Widget extends DTWCBE_Product_Base {

	public function get_name() {
		return 'archive-products';
	}

	public function get_title() {
		return esc_html__( 'Woo Archive Products', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-product-archive' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'product', 'archive' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'prefix_class' => 'elementor-products-columns%s-',
				'default' => 4,
				'min' => 1,
				'max' => 12,
			]
		);
		
		$this->add_control(
			'rows',
			[
				'label' => esc_html__( 'Rows', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 4,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'max' => 20,
					],
				],
			]
		);
		
		$this->add_control(
			'paginate',
			[
				'label' => esc_html__( 'Pagination', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'allow_order',
			[
				'label' => esc_html__( 'Allow Order', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'show_result_count',
			[
				'label' => esc_html__( 'Show Result Count', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);
		
		
		$this->add_control(
			'nothing_found_message',
			[
				'label' => esc_html__( 'Nothing Found Message', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'No products were found matching your selection.', 'woocommerce-builder-elementor' ),
			]
		);
		
		$this->add_control(
			'query_post_type',
			[
				'type' => 'hidden',
				'default' => 'current_query',
			]
		);

		$this->end_controls_section();
		
		parent::_register_controls();
		
		$this->start_controls_section(
			'section_nothing_found_style',
			[
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Nothing Found Message', 'woocommerce-builder-elementor' ),
				'condition' => [
					'nothing_found_message!' => '',
				],
			]
		);
		
		$this->add_control(
			'nothing_found_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-products-nothing-found' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'nothing_found_typography',
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementor-products-nothing-found',
			]
		);
		
		$this->end_controls_section();
		
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		
		echo DTWCBE_Archive_Product_Elementor::_render( $this->get_name(), $settings);
	}
	

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Product_Archive_Products_Widget());