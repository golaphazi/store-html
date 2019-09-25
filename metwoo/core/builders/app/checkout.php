<?php
namespace MetWoo\Core\Builders\App;
defined( 'ABSPATH' ) || exit;

use \Elementor\Plugin as Plugin;
use \MetWoo\Core\Builders\Cpt as Cpt;
use \MetWoo\Core\Builders\Action as Action;
use \MetWoo\Core\Builders\Base as Base;

Class Checkout{

  use \MetWoo\Traits\Singleton;

  public $cpt;
  public $action;

  public $custom_post ;
  public $meta_key;

  public function Init(){
    $this->cpt = new Cpt();
    $this->action = new Action();
    $this->base = New Base();

    $this->custom_post = $this->cpt->get_name();
    $this->meta_key = $this->action->key_form_settings;

    add_filter( 'body_class', array($this, 'body_classes') );
    
    // cart content replace
    add_filter('wc_get_template', array($this, '__wc_get_template'), 99, 3);
    add_action('metwoo_checkout_elementor', array($this, 'the_checkout_page_content'));
    add_action( 'metwoo_thankyou_elementor', array($this,'the_thankyou_content') );
  }

  
    public function get_dir(){
        return $this->base->get_dir();
    }

    /**
     * Public function __wc_get_template .
     * Get template part
     *
     * @since 1.0.0
     */

    public function __wc_get_template( $template, $slug, $name ){
        if ($slug === 'checkout/form-checkout.php') {
            $product_template_id = $this->get_register_checkout_template();
			$file = 'content-checkout.php';
			if( !empty($product_template_id) ){
                $template = $this->get_dir() . '/views/woo/product-templates/'.$file;
            }
		} else  if ($slug === 'checkout/thankyou.php') {
            $product_template_id = $this->get_register_thankyou_template();
			$file = 'content-thankyou.php';
			if( !empty($product_template_id) ){
                $template = $this->get_dir() . '/views/woo/product-templates/'.$file;
            }
		}
        return $template;

    }

    /**
     * Public function the_cart_page_content .
     * Get checkout page
     *
     * @since 1.0.0
     */
    public static function the_checkout_page_content( ){
		$product_template_id = $this->get_register_checkout_template();
		if( !empty($product_template_id) ){
			echo Plugin::$instance->frontend->get_builder_content_for_display( $product_template_id );
		}else{
			the_content();
		}
	}

    /**
     * Public function the_thankyou_content .
     * Get thankyou page
     *
     * @since 1.0.0
     */
    public static function the_thankyou_content( ){
		$product_template_id = $this->get_register_thankyou_template();
		if( !empty($product_template_id) ){
			echo Plugin::$instance->frontend->get_builder_content_for_display( $product_template_id );
		}else{
			the_content();
		}
	}

    
     /**
     * Public function get_register_checkout_template .
     * Select Single Product Template
     *
     * @since 1.0.0
     */
    public function get_register_checkout_template() {
		if ( is_checkout() ) {
            $product_template_id = get_option($this->meta_key.'__checkout', 0);
            return $product_template_id;
        }
        return 0;
    }
    
    /**
     * Public function get_register_thankyou_template .
     * Select Single Product Template
     *
     * @since 1.0.0
     */
    public function get_register_thankyou_template() {
		return get_option($this->meta_key.'__order', 0);
	}

    /**
     * Public function body_classes .
     * Set body class
     *
     * @since 1.0.0
     */

    public function body_classes($classes){
		$post_type = get_post_type();
		if($post_type == 'product' || $this->custom_post ){
			$classes[] = 'woocommerce-builder-elementor metwoo-cart';
		}
		return $classes;
	}
	

}