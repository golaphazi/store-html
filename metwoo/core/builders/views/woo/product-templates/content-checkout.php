<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="woocommerce metwoo-woocommerce-checkout">
<?php

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'woocommerce-builder-elementor' ) ) );
	return;
}
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout metwoo-woocommerce-checkout-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<?php 
	do_action('metwoo_checkout_elementor');
	?>
</form>
</div>