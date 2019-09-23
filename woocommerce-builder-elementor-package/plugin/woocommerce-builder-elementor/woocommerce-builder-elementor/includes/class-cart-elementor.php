<?php
/**
 * DTWCBE_Cart_Elementor
 *
 * @package WooCommerce-Builder-Elementor
 *
 */

defined( 'ABSPATH' ) || exit;

class DTWCBE_Cart_Elementor{

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct(){
		add_action('init', array($this, 'init'));
	}
	
	public function init(){
		add_filter( 'body_class', array($this, 'body_classes') );
	}
	
	public static function _render( $element = '', $settings = array()){
		
		$cart_page_id = self::get_woocommerce_cart_page_id();
		
		switch ( $element ){
			
			case 'cross-sells':
				ob_start();
				if( is_cart() ):
				?>
				<div class="woocommerce dtwcbe_cross_sell">
				<?php woocommerce_cross_sell_display( $settings['limit'], $settings['columns'], $settings['orderby'], $settings['order'] ); ?>
				</div>
				<?php
				endif;
				return ob_get_clean();
				break;
				
			default: 
				return '';
				break;
		}
	}
	
	public static function get_woocommerce_cart_page_id(){
	
		return get_option('woocommerce_cart_page_id', '');
		
	}
	
	public function body_classes($classes){
		$post_type = get_post_type();
		if( is_cart() || $post_type == DTWCBE_Post_Types::CPT ){
			$classes[] = 'woocommerce-cart';
			$classes[] = 'woocommerce-builder-elementor';
		}
		
		return $classes;
	}
}

//DTWCBE_Cart_Elementor::instance();