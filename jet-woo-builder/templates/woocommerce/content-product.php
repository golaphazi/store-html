<?php
/**
 * Archive item template
 */

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>
<li <?php wc_product_class( ' jet-woo-builder-product', $product ); ?> data-product-id="<?php echo $product->get_id(); ?>"><?php
	$template = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_archive_template() );

	echo jet_woo_builder()->parser->get_template_content( $template );
	?></li>
<?php  ?>
