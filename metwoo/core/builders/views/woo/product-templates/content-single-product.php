<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$theme = wc_get_theme_slug_for_templates();
?>

<?php
	/**
	 * Hook: woocommerce_before_single_product.
	 *
	 * @hooked wc_print_notices - 10
	 */
	do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 
	 $class = 'metwoo-product-page elementor summary';
	 if( $theme == 'jupiter' ){
	 	$class .=' mk-product style-default';
	 }
	 if( $theme == 'superfood' ){
	 	$class .=' eltdf-single-product-content';
	 }
	 
	 $class = apply_filters('metwoo_woocommerce_page_class', $class);
?>

<div id="product-<?php the_ID(); ?>" <?php post_class($class); ?>>
	<?php
	do_action( 'metwoo_single_product_elementor' );
	?>
</div>