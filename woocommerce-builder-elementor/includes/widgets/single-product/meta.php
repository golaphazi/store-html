<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Meta_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'single-product-meta';
	}

	public function get_title() {
		return esc_html__( 'Woo Product Meta', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-meta';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'meta' , 'product' , 'single product' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' => false,
				'default' => 'inline',
				'options' => [
					'table' => esc_html__( 'Table', 'woocommerce-builder-elementor' ),
					'stacked' => esc_html__( 'Stacked', 'woocommerce-builder-elementor' ),
					'inline' => esc_html__( 'Inline', 'woocommerce-builder-elementor' ),
				],
				'prefix_class' => 'woocommerce-builder-elementor-woo-meta--view-',
			]
		);
		
		$this->add_control(
			'heading_text_style',
			[
				'label' => esc_html__( 'Text', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}}',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_link_style',
			[
				'label' => esc_html__( 'Link', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'selector' => '{{WRAPPER}} a',
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();
		$post_type = get_post_type();
	
		if ( $post_type == 'product' || $post_type == DTWCBE_Post_Types::post_type() ){
			
			echo DTWCBE_Single_Product_Elementor::_render( $this->get_name() );
			
		}else{
			
			esc_html_e('Product Meta', 'woocommerce-builder-elementor' );
			
		}
		
	}
	

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Meta_Widget());