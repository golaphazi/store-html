<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$elementor = Elementor\Plugin::instance();

//
if ( $elementor->editor->is_edit_mode() ){
	if ( is_product() || ( ! empty( $post->post_content ) && strstr( $post->post_content, '[product_page' ) ) ) {
		printf(
			'<h5>%s</h5>',
			esc_html__( 'JetWooBuilder Template is enabled, however, it can&rsquo;t be displayed in shortcode when you&rsquo;re on Elementor editor page.', 'jet-woo-builder' )
		);
		return;
	}
}

/**
 * Hook Woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
 do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

?>
<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>><?php
	$template = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->current_single_template() );

	if ( class_exists( 'Elementor\Plugin' ) ) {
		echo $elementor->frontend->get_builder_content( $template, false );
	}
?></div>

<?php do_action( 'woocommerce_after_single_product' );?>