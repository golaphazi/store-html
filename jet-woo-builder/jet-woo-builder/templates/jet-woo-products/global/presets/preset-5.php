<?php
/**
 * Products loop item layout 5
 */
?>
<div class="jet-woo-products__thumb-wrap"><?php include $this->get_template( 'item-thumb' ); ?>
	<div class="jet-woo-products__item-content hovered-content">
        <div class="jet-woo-products-cqw-wrapper">
            <?php include $this->get_template( 'item-compare' ); ?>
            <?php include $this->get_template( 'item-wishlist' ); ?>
            <?php include $this->get_template( 'item-quick-view' ); ?>
        </div> <?php
        include $this->get_template( 'item-categories' );
        include $this->get_template( 'item-title' );
		include $this->get_template( 'item-sku' );
		include $this->get_template( 'item-price' );
        include $this->get_template( 'item-content' );
        include $this->get_template( 'item-button' );
        include $this->get_template( 'item-rating' );
        include $this->get_template( 'item-tags' );
	  ?></div>
</div>