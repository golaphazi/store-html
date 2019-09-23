<?php
/**
 * Sale badge template
 */

global $post, $product;

$badge_text = jet_woo_builder()->macros->do_macros( $this->get_settings('single_badge_text') );

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . $badge_text . '</span>', $post, $product ); ?>

<?php endif;