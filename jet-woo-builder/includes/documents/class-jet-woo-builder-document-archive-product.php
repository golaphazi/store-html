<?php

use Elementor\Controls_Manager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Jet_Woo_Builder_Archive_Document_Product extends Jet_Woo_Builder_Document_Base {

	/**
	 * @access public
	 */
	public function get_name() {
		return 'jet-woo-builder-archive';
	}

	/**
	 * @access public
	 * @static
	 */
	public static function get_title() {
		return __( 'Jet Woo Archive Template', 'jet-woo-builder' );
	}

	/**
	 * @since 2.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		parent::_register_controls();

		$this->start_controls_section(
			'section_template_settings',
			array(
				'label'      => esc_html__( 'Template Settings', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_SETTINGS,
				'show_label' => false,
			)
		);

		$this->add_control(
			'use_custom_template_columns',
			array(
				'label'        => esc_html__( 'Use custom columns count', 'jet-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_responsive_control(
			'template_columns_count',
			array(
				'label'           => esc_html__( 'Template Columns', 'jet-woo-builder' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 6,
				'step'            => 1,
				'condition'       => array(
					'use_custom_template_columns' => 'yes'
				)
			)
		);

		$this->add_responsive_control(
			'template_columns_horizontal_gutter',
			array(
				'label'      => esc_html__( 'Template Columns Horizontal Gutter (px)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'.woocommerce {{WRAPPER}} ' . '.products.jet-woo-builder-products--columns .product:not(.product-category)' => 'padding-left: calc({{SIZE}}{{UNIT}}/2); padding-right: calc({{SIZE}}{{UNIT}}/2);',
					'.woocommerce {{WRAPPER}} ' . '.products.jet-woo-builder-products--columns'                                 => 'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2);',
				),
				'condition'  => array(
					'use_custom_template_columns' => 'yes'
				)
			)
		);

		$this->add_responsive_control(
			'template_columns_vertical_gutter',
			array(
				'label'      => esc_html__( 'Template Columns Vertical Gutter (px)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'.woocommerce {{WRAPPER}} ' . '.products.jet-woo-builder-products--columns .product:not(.product-category)' => 'margin-bottom: {{SIZE}}{{UNIT}}!important;',
				),
				'condition'  => array(
					'use_custom_template_columns' => 'yes'
				)
			)
		);

		$this->end_controls_section();

	}

	/**
	 * @since 2.0.0
	 * @access public
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function save( $data = [] ) {
		return $this->save_archive_templates( $data );
	}

	/**
	 * @since 2.0.0
	 * @access public
	 *
	 * @param $data
	 *
	 * @return bool
	 */

	/**
	 * @access public
	 */
	public function get_wp_preview_url() {

		$main_post_id   = $this->get_main_id();
		$sample_product = get_post_meta( $main_post_id, '_sample_product', true );

		if ( ! $sample_product ) {
			$sample_product = $this->query_first_product();
		}

		$product_id = $sample_product;

		return add_query_arg(
			array(
				'preview_nonce'    => wp_create_nonce( 'post_preview_' . $main_post_id ),
				'jet_woo_template' => $main_post_id,
			),
			get_permalink( $product_id )
		);

	}

	/**
	 * Return preview query args
	 * @return array
	 */
	public function get_preview_as_query_args() {

		jet_woo_builder()->documents->set_current_type( $this->get_name() );

		$args    = array();
		$product = $this->query_first_product();

		if ( ! empty( $product ) ) {

			$args = array(
				'post_type' => 'product',
				'p'         => $product,
			);

		}

		return $args;
	}

}