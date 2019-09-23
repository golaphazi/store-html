<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Archive_Description_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'archive-description';
	}

	public function get_title() {
		return esc_html__( 'Woo Archive Description', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-description';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-product-archive' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'shop' , 'archive' , 'description', 'archive description' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Archive Description', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_control(
			'archive_description_color',
			[
				'label'     => esc_html__( 'Description Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-archive_description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'archive_description_typography',
				'label'     => esc_html__( 'Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-archive_description',
			)
		);
		
		$this->add_responsive_control(
			'archive_description_align',
			[
				'label'        => esc_html__( 'Alignment', 'woocommerce-builder-elementor' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'description' => esc_html__( 'Left', 'woocommerce-builder-elementor' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'description' => esc_html__( 'Center', 'woocommerce-builder-elementor' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'description' => esc_html__( 'Right', 'woocommerce-builder-elementor' ),
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
		echo '<div class="woocommerce-archive_description">';
			echo DTWCBE_Archive_Product_Elementor::_render( $this->get_name() );
		echo '</div>';
		
	}
	

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Archive_Description_Widget());