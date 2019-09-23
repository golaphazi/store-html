<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

\Elementor\Plugin::$instance->frontend->add_body_class( 'elementor-template-canvas' );
$theme = wc_get_theme_slug_for_templates();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title><?php echo wp_get_document_title(); ?></title>
	<?php endif; ?>
	<?php wp_head(); ?>
	<?php
	// Keep the following line after `wp_head()` call, to ensure it's not overridden by another templates.
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
</head>
<body <?php body_class(); ?>>
	<?php
	/**
	 * Before canvas page template content.
	 *
	 * Fires before the content of Elementor canvas page template.
	 *
	 * @since 1.0.0
	 */
	do_action( 'elementor/page_templates/canvas/before_content' );
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
	 * After canvas page template content.
	 *
	 * Fires after the content of Elementor canvas page template.
	 *
	 * @since 1.0.0
	 */
	do_action( 'elementor/page_templates/canvas/after_content' );

	wp_footer();
	?>
	</body>
</html>
