<?php
/**
 * Products loop item template
 */

global $product;

$product = wc_get_product();
$product_id = $product->get_id();

$classes = array(
	jet_woo_builder_tools()->col_classes( array(
		'desk' => $this->get_attr( 'columns' ),
		'tab'  => $this->get_attr( 'columns_tablet' ),
		'mob'  => $this->get_attr( 'columns_mobile' ),
	) ),
	'jet-woo-builder-product'
);

$enable_thumb_effect = filter_var( jet_woo_builder_settings()->get( 'enable_product_thumb_effect' ), FILTER_VALIDATE_BOOLEAN );

if ( $enable_thumb_effect ){
	array_push( $classes, 'jet-woo-thumb-with-effect' );
}
?>
<div class="jet-woo-products__item <?php echo implode( ' ', $classes ); ?>" data-product-id="<?php echo $product_id ?>">
	<div class="jet-woo-products__inner-box"><?php include $this->get_product_preset_template(); ?></div>
</div>