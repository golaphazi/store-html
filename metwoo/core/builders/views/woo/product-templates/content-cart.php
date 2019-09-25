<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce metwoo-elementor-cart">
	<?php
	wc_print_notices();
	
	do_action('metwoo_cart_elementor');
	?>
</div>