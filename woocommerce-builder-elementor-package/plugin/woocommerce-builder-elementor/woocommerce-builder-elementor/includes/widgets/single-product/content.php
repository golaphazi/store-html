<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Content_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'single-product-content';
	}

	public function get_title() {
		return esc_html__( 'Woo Product Content', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-content';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'content' , 'product' , 'single product' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'content_style_section',
			array(
				'label' => esc_html__( 'Style', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'content_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .dtwcbe-single-product-content',
			)
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dtwcbe-single-product-content' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'content_align',
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'woocommerce-builder-elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => '',
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} .dtwcbe-single-product-content' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();
		$post_type = get_post_type();
		
		echo '<div class="dtwcbe-single-product-content">';
		
		if ($post_type == 'product' || $post_type == DTWCBE_Post_Types::post_type() ){
			
			echo DTWCBE_Single_Product_Elementor::_render( $this->get_name() );
			
		}else{
			
			echo esc_html__('Product Content', 'woocommerce-builder-elementor' );
			
		}
		echo '</div>';
		
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Content_Widget());