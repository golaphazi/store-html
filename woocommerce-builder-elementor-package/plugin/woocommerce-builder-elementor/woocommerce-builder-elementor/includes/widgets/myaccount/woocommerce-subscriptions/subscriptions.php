<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_MyAccount_Subscriptions_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'myaccount_wc_subscriptions';
	}

	public function get_title() {
		return esc_html__( 'My Account WC Subscriptions', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-myacount' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'Subscriptions' , 'My Account' , 'Account' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		if ( ! is_user_logged_in() ) { return ''; }
		ob_start();
		if( isset($wp->query_vars['subscriptions']) ){
			$value = $wp->query_vars['subscriptions'];
			do_action( 'woocommerce_account_subscriptions_endpoint', $value );
				
		}elseif( isset($wp->query_vars['view-subscription']) ){
			$value = $wp->query_vars['view-subscription'];
			?>
			<h2><a href="<?php echo esc_url($myaccount_url); ?>" title="<?php echo apply_filters('woocommerce_account_view_subscription_backorder', esc_html__('Back to Subscriptions list', 'woocommerce-builder-elementor')); ?>"><?php echo apply_filters('woocommerce_account_view_order_backorder', esc_html__('Back to Subscriptions list', 'woocommerce-builder-elementor')); ?></a></h2>
			<?php
			do_action( 'woocommerce_account_view-subscription_endpoint', $value );
				
		}elseif( isset($wp->query_vars['payment-methods']) ){
			$value = $wp->query_vars['payment-methods'];
			do_action( 'woocommerce_account_view-subscription_endpoint', $value );
				
		}elseif( isset($wp->query_vars['add-payment-method']) ){
			$value = $wp->query_vars['add-payment-method'];
			do_action( 'woocommerce_account_view-subscription_endpoint', $value );
				
		}else{
			$value = '';
			do_action( 'woocommerce_account_subscriptions_endpoint', $value );
		}
		echo ob_get_clean();
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_MyAccount_Subscriptions_Widget());