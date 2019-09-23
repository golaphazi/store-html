!(function(jQuery){
	"use strict";
	jQuery(document).ready(function($) {
		// do something...
		var coupon_toggle = jQuery(".dtwcbe-woocommerce-checkout .woocommerce-form-coupon-toggle");
    	var coupon_form = jQuery(".dtwcbe-woocommerce-checkout form.woocommerce-form-coupon");
    	jQuery(".dtwcbe_woocommerce_checkout_coupon_form").append(coupon_toggle),coupon_toggle.show(),coupon_form.insertAfter(coupon_toggle);
	});
})(jQuery);