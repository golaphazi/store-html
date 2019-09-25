<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

?>
<div class="woocommerce metwoo-woocommerce-myaccount-login-page">
	<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
	<div id="customer_login">
	<?php 
	do_action( 'metwoo_login_elementor' );
	?>
	</div>
	<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
</div>
