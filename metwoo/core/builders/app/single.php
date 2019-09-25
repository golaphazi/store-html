<?php
namespace MetWoo\Core\Builders\App;
defined( 'ABSPATH' ) || exit;

use \Elementor\Plugin as Plugin;
use \MetWoo\Core\Builders\Cpt as Cpt;
use \MetWoo\Core\Builders\Action as Action;
use \MetWoo\Core\Builders\Base as Base;

Class Single{

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
    add_filter( 'post_class', array($this, 'post_class') );
   
    // sigle product content replace
    add_filter('wc_get_template_part', array($this, 'wc_get_template_part'), 99, 3);
    add_action('metwoo_single_product_elementor', array($this, 'the_product_page_content'));
    add_action('metwoo_single_product_elementor', array($this, 'product_data' ), 30 );
    
  }

  
    public function get_dir(){
        return $this->base->get_dir();
    }

    /**
     * Public function wc_get_template_part .
     * Get template part
     *
     * @since 1.0.0
     */

    public function wc_get_template_part( $template, $slug, $name ){
        if ($slug === 'content' && $name === 'single-product') {
            $product_template_id = $this->get_register_single_product_template();
            $file = 'content-single-product.php';
            $find[] = $this->get_dir() . '/views/woo/product-templates/'.$file;
            if( !empty($product_template_id) ){
              $template = '';
              if (!$template || (!empty($status_options['template_debug_mode']) && current_user_can('manage_options'))) {
                $template = $this->get_dir() . '/views/woo/product-templates/'.$file;
                return $template;
              }
            }
        }
      return $template;
    }

    /**
     * Public function the_product_page_content .
     * Get content page
     *
     * @since 1.0.0
     */
    public static function the_product_page_content( $post ){
      $product_template_id = $this->get_register_single_product_template();
      if( !empty($product_template_id) ){
        echo Plugin::$instance->frontend->get_builder_content_for_display( $product_template_id );
      }else{
        the_content();
      }
	}

    /**
     * Public function product_data .
     * Get woo Product Data
     *
     * @since 1.0.0
     */
    public function product_data() {
		  WC()->structured_data->generate_product_data();
    }
     /**
     * Public function get_register_single_product_template .
     * Select Single Product Template
     *
     * @since 1.0.0
     */
    public function get_register_single_product_template() {
      if (is_singular('product')) {
        global $post;
        if( !property_exists($post, 'ID')){
            return 0;
        }
        
        $product_template_id = get_post_meta(  $post->ID,  $this->meta_key.'__template',  true );
        if($product_template_id == 0 ){
            $product_template_id = get_option($this->meta_key.'__single', 0);       
         }
        return $product_template_id;
      }
      return 0;
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
          $classes[] = 'woocommerce';
          $classes[] = 'woocommerce-builder-elementor';
          $classes[] = 'single-product';
      }
		return $classes;
	}
	/**
     * Public function post_class .
     * Set post class
     *
     * @since 1.0.0
     */

	public function post_class($classes){
		if( is_singular($this->custom_post) )
		{
		  $classes[] = 'product';
		}
		return $classes;
	}

}