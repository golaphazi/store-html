<?php
/**
 * Admin View: Settings
*
* @package WooCommerce-Builder-Elementor 
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $tabs ) {
	wp_safe_redirect( admin_url( 'admin.php?page=woocommerce_builder_templates' ) );
	exit;
}

$dtwcbe_current_tab_label = isset( $tabs[ $dtwcbe_current_tab ] ) ? $tabs[ $dtwcbe_current_tab ] : '';

?>
<div class="wrap woocommerce-builder-elementor">
	<h2><?php echo esc_html__( 'WooCommerce Builder Templates', 'woocommerce-builder-elementor' ); ?></h2>
	<div>
		<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
			<?php
			foreach ( $tabs as $slug => $label ) {
				echo '<a href="' . esc_html( admin_url( 'edit.php?post_type=elementor_library&page=woocommerce_builder_templates&tab=' . esc_attr( $slug ) ) ) . '" class="nav-tab ' . ( $dtwcbe_current_tab === $slug ? 'nav-tab-active' : '' ) . '">' . esc_html( $label ) . '</a>';
			}
			do_action( 'woocommerce_builder_elementor_settings_tabs' );
			?>
		</nav>
		<h1 class="screen-reader-text"><?php echo esc_html( $dtwcbe_current_tab_label ); ?></h1>
		<?php
			do_action( 'woocommerce_builder_elementor_settings_' . $dtwcbe_current_tab );
			do_action( 'woocommerce_builder_elementor_settings_tabs_' . $dtwcbe_current_tab ); // @deprecated hook. @todo remove in 4.0.
		?>
	</div>
</div>
