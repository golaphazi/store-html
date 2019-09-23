<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce-page-builder-templates/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$theme = wc_get_theme_slug_for_templates();

get_header( 'shop' );

if( $theme == 'Impreza' ){
	echo '<div class="l-main">';
	echo '<div class="l-main-h i-cf">';
	echo '<main class="l-content">';
}

if( $theme == 'storefront' ):?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
<?php
endif;
?>
<?php
if( $theme == 'dt-the7' ):?>
<div id="content" class="content" role="main">
<?php
endif;
?>
<?php
if( $theme == 'kuteshop' ):?>
<div class="main-container shop-page full-sidebar">
<div class="container">
<?php
endif;
?>
<div class="dtwcbe-woocommerce-product-achive <?php echo esc_attr( $theme );?>">
	<?php 
	if( $theme == 'woodmart' ):
	?>
	<div class="shop-loop-head">
		<div class="woodmart-woo-breadcrumbs">
			<?php woodmart_current_breadcrumbs( 'shop' ); ?>
			<?php woocommerce_result_count(); ?>
		</div>
		<div class="woodmart-shop-tools">
			<?php
				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
		</div>
	</div>
	<?php endif; ?>
	<?php
	if( $theme == 'shopme' ){
		woocommerce_output_content_wrapper();
	}
	?>

	<?php
	/**
	 * dtwcbe_archive_product_elementor Hooks
	 *
	 * @hooked DTWCBE_Archive_Product_Elementor -> the_archive_product_page_content() - 10.
	 * 
	 */
	do_action( 'dtwcbe_archive_product_elementor' );
	?>
	
	<?php 
	if( $theme == 'shopme' ){
		woocommerce_output_content_wrapper_end();
	}
	?>
</div>
<?php
if( $theme == 'kuteshop' ):?>
</div></div>
<?php
endif;
?>
<?php
if( $theme == 'dt-the7' ):?>
</div>
<?php
endif;
?>
<?php
if( $theme == 'Impreza' ){
	echo '</div></div></main>';
}

if( $theme == 'storefront' ):?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
endif;
?>
<?php 
get_footer( 'shop' ); ?>
