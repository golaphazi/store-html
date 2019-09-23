<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce-page-builder-templates/cart/content-cart.php.
 * 
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce woocommerce-builder-elementor-cart">
	<?php
	wc_print_notices();
	
	do_action('dtwcbe_cart_content');
	?>
</div>