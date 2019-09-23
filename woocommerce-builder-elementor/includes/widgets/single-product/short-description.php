<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Short_Description_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'single-product-short-description';
	}

	public function get_title() {
		return esc_html__( 'Woo Product Short Description', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-description';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'description' , 'product' , 'single product' ];
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
			'short_description_color',
			[
				'label'     => esc_html__( 'Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-details__short-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'short_description_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-product-details__short-description',
			)
		);
		
		$this->add_responsive_control(
			'text_align',
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
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();
		$post_type = get_post_type();
	
		$excerpt = '';
		
		if ( $post_type == 'product'  ) {
			global $product;
			$product = wc_get_product();
			
			if ( empty( $product ) ) {
				return;
			}
			woocommerce_template_single_excerpt();
			return;
			
		}elseif ($post_type == DTWCBE_Post_Types::post_type() ){
			
			$excerpt = DTWCBE_Single_Product_Elementor::_render( $this->get_name() );
			
		}else{
			
			$excerpt = esc_html__('Product Short Description', 'woocommerce-builder-elementor' );
			
		}
		
		echo sprintf( '<div class="%1$s">%2$s</div>', 'woocommerce-product-details__short-description', $excerpt );
		
	}
	

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Short_Description_Widget());