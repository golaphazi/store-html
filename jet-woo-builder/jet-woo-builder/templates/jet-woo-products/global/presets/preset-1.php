<?php
/**
 * Products loop item layout 1
 */
?>

<?php
	include $this->get_template( 'item-thumb' );
	include $this->get_template( 'item-categories' );
	include $this->get_template( 'item-sku' );
	include $this->get_template( 'item-title' );
	include $this->get_template( 'item-price' );
	include $this->get_template( 'item-content' );
	include $this->get_template( 'item-button' ); ?>
	<div class="jet-woo-products-cqw-wrapper">
		<?php include $this->get_template( 'item-compare' ); ?>
		<?php include $this->get_template( 'item-wishlist' ); ?>
		<?php include $this->get_template( 'item-quick-view' ); ?>
	</div> <?php
	include $this->get_template( 'item-rating' );
	include $this->get_template( 'item-tags' );
?>