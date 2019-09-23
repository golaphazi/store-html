<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Custom_Key_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'single-product-custom-key';
	}

	public function get_title() {
		return esc_html__( 'Woo Product Custom_Key', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'custom_key' , 'product' , 'single product' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_custom_key',
			[
				'label' => esc_html__( 'custom_key', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'custom_key_label',
			[
				'label' => esc_html__( 'Custom key lable', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Custom key lable', 'woocommerce-builder-elementor' ),
				'default' => 'Total Sales',
			]
		);
		
		$this->add_control(
			'custom_key',
			[
				'label' => esc_html__( 'Custom key', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter only the custom_key in Product > Custom Fields name. e.g. total_sales . Default value "0" will be shown', 'woocommerce-builder-elementor' ),
				'default' => 'total_sales',
			]
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
					'inline' => esc_html__( 'Inline', 'woocommerce-builder-elementor' ),
				],
				'prefix_class' => 'dtwcbe-product-custom-key--view-',
			]
		);
		
		$this->end_controls_section();
	}
	
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$post_type = get_post_type();
	
		$product_custom_value = ''; $settings['label_size'] = 'div';
		
		if ($post_type == 'product' || $post_type == DTWCBE_Post_Types::post_type() ){
			
			$product_custom_value = DTWCBE_Single_Product_Elementor::_render( $this->get_name(), $settings );
			
		}else{
			
			$product_custom_value = $settings['custom_key'];
			
		}
		
		echo '<div class="dtwcbe_woocommerce_product_custom_key">';
		echo (!empty($settings['custom_key_label'])) ? sprintf( '<%1$s class="%2$s">%3$s</%1$s>', $settings['label_size'], 'product_custom_key_label detail-container', esc_html($settings['custom_key_label']) ) : '';
		echo '<span class="product_custom_key_value detail-container">'.$product_custom_value.'</span>';
		echo '</div>';
		
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Custom_Key_Widget());