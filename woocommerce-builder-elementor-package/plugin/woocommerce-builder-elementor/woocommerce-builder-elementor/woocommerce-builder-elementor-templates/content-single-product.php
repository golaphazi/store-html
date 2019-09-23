<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce-builder-elementor-templates/content-single-product.php.
 *
 */

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
	 
	 $class = 'dtwcbe-product-page elementor summary';
	 if( $theme == 'jupiter' ){
	 	$class .=' mk-product style-default';
	 }
	 if( $theme == 'superfood' ){
	 	$class .=' eltdf-single-product-content';
	 }
	 
	 $class = apply_filters('dtwcbe_woocommerce_page_class',$class);
?>

<div id="product-<?php the_ID(); ?>" <?php post_class($class); ?>>
	<?php
	/**
	 * DTWCBE_Single_Product_Elementor Hooks
	 *
	 * @hooked DTWCBE_Single_Product_Elementor -> the_product_page_content() - 10.
	 * @hooked DTWCBE_Single_Product_Elementor -> product_data() - 30.
	 */
	do_action( 'dtwcbe_product_elementor' );
	?>
</div>