<?php
/**
 * DT WooCommerce Page Builder for Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_MyAccount_Memberships_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'myaccount_wc_memberships';
	}

	public function get_title() {
		return esc_html__( 'WC Memberships: My Account Memberships', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-myacount' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'Memberships' , 'My Account' , 'Account' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		if( is_account_page() && class_exists('WC_Memberships_Members_Area') ){
			ob_start();
			require_once DTWCBE_PATH . '/includes/plugins-support/woocommerce-memberships/class-wc-memberships-members-area.php';
			$output_members_area = new DTWCBE_WC_Memberships_Members_Area();
			$output_members_area->output_members_area();
			echo ob_get_clean();
		}
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_MyAccount_Memberships_Widget());