<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

\Elementor\Plugin::$instance->frontend->add_body_class( 'elementor-template-full-width' );
$theme = wc_get_theme_slug_for_templates();
get_header('shop');
/**
 * Before Header-Footer page template content.
 *
 * Fires before the content of Elementor Header-Footer page template.
 *
 * @since 2.0.0
 */
do_action( 'elementor/page_templates/header-footer/before_content' );


?>
<div class="dtwcbe-woocommerce-product-achive <?php echo esc_attr( $theme );?>">
	<?php
	/**
	 * dtwcbe_archive_product_elementor Hooks
	 *
	 * @hooked DTWCBE_Archive_Product_Elementor -> the_archive_product_page_content() - 10.
	 * 
	 */
	do_action( 'dtwcbe_archive_product_elementor' );
	?>
</div>
<?php

/**
 * After Header-Footer page template content.
 *
 * Fires after the content of Elementor Header-Footer page template.
 *
 * @since 2.0.0
 */
do_action( 'elementor/page_templates/header-footer/after_content' );

get_footer('shop');
