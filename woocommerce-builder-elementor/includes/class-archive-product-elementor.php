<?php
/**
 * DTWCBE_Archive_Product_Elementor
 *
 * @package WooCommerce-Builder-Elementor
 *
 */

defined( 'ABSPATH' ) || exit;

class DTWCBE_Archive_Product_Elementor{

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
		
		// Custom Product Archive Pages
		add_action('template_redirect', array($this, 'register_product_archive_template'), 999999);
		add_filter('template_include', array($this, 'redirect_product_archive_template'), 999999);
		add_action( 'dtwcbe_archive_product_elementor', array($this, 'the_archive_product_page_content') );
	}
	
	public function register_product_archive_template() {
		
		$archive_template_id = 0;
			
		// Get All Template builder and check term in template
		$args = array(
			'post_status'=> 'publish',
			'meta_key' => '_dtwcbe_woo_template_type',
			'meta_value' => 'product-archive',
			'post_type' => DTWCBE_Post_Types::CPT,
			'posts_per_page' => -1,
			'order' => 'asc',
		);
		$product_archive_templates = get_posts($args);
		
		if (defined('WOOCOMMERCE_VERSION')) {
	
			global $wp_query;
	
			if (is_shop()) {
				$product_achive_custom_page_id = get_option('dtwcbe_shop_custom_page_id', '');
				if (!empty($product_achive_custom_page_id)) {
					$archive_template_id = $product_achive_custom_page_id;
				}
				return $archive_template_id;
	
			} elseif (is_tax('product_cat') && is_product_category()) {
	
				$product_cat_custom_page_id = 0;
	
				$term_slug = $wp_query->get_queried_object()->slug;
				
				foreach ( $product_archive_templates as $ap_template ){
					$dtwcbe_product_cat_in = get_post_meta($ap_template->ID, 'dtwcbe_condition_archive_product_in_cat', true);
					$dtwcbe_product_cat_in_arr = explode(',', $dtwcbe_product_cat_in);
					
					if(in_array('all', $dtwcbe_product_cat_in_arr)){
						$product_cat_custom_page_id = $ap_template->ID;
					}
					elseif( in_array($term_slug, $dtwcbe_product_cat_in_arr) ){
						$product_cat_custom_page_id = $ap_template->ID;
					}
				}
				
				if (!empty($product_cat_custom_page_id)) {
					$archive_template_id = $product_cat_custom_page_id;
				}
				return $archive_template_id;
	
			} elseif (is_tax('product_tag') && is_product_tag()) {
	
				$product_tag_custom_page_id = 0;
	
				$term_slug = $wp_query->get_queried_object()->slug;
				
				foreach ( $product_archive_templates as $ap_template ){
					$dtwcbe_product_tag_in = get_post_meta($ap_template->ID, 'dtwcbe_condition_archive_product_in_tag', true);
					$dtwcbe_product_tag_in_arr = explode(',', $dtwcbe_product_tag_in);
						
					if(in_array('all', $dtwcbe_product_tag_in_arr)){
						$product_tag_custom_page_id = $ap_template->ID;
					}
					elseif( in_array($term_slug, $dtwcbe_product_tag_in_arr) ){
						$product_tag_custom_page_id = $ap_template->ID;
					}
				}
				
				if (!empty($product_tag_custom_page_id)) {
					$archive_template_id = $product_tag_custom_page_id;
				}
				return $archive_template_id;
			}
		}
		
		return $archive_template_id;
	}
	
	public function redirect_product_archive_template($template){
		$archive_template_id = $this->register_product_archive_template();
		$find 	= array();
		$file 	= 'archive-product.php';
		$find[] = 'woocommerce-builder-elementor-templates/' . $file;
		if( $archive_template_id ){
			$template       = locate_template( $find );
			if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) )
				$template = DTWCBE_PATH . '/woocommerce-builder-elementor-templates/' . $file;
				
			// Select Page Template
			$page_template_slug = get_page_template_slug( $archive_template_id );
			
			if ( 'elementor_header_footer' === $page_template_slug ) {
				$template = DTWCBE_MODULES_PATH . '/archive-templates/header-footer.php';
			} elseif ( 'elementor_canvas' === $page_template_slug ) {
				$template = DTWCBE_MODULES_PATH . '/archive-templates/canvas.php';
			}
		}
		
		return $template;
	}
	
	public static function the_archive_product_page_content( $post ){
		$archive_template_id = $this->register_product_archive_template();
		if( $archive_template_id ){
			echo DTWCBE_WooCommerce_Builder_Elementor::$elementor_instance->frontend->get_builder_content_for_display( $archive_template_id );
		}else{
			the_content();
		}
	}
	
	public static function _render( $element = '', $settings = array()){
		global $wp_query;
		$term_id = 0; // View the Shop Page
		if( get_post_type() == DTWCBE_Post_Types::CPT ){
			$term_id = self::get_archive_page_id_in_condition();
		}
		
		switch ( $element ){
			
			case 'archive-description':
				ob_start();
					if( $term_id !== 0 && get_post_type() == DTWCBE_Post_Types::CPT ){
						$tax = get_post_meta(get_the_ID(), 'dtwcbe_condition_archive_product_is_tax', true);
						$term = get_term_by('term_id', $term_id, $tax);
						if ( $term && ! empty( $term->description ) ) {
							echo '<div class="term-description">' . wc_format_content( $term->description ) . '</div>'; // WPCS: XSS ok.
						}
					}else{
						do_action( 'woocommerce_archive_description' );
					}
				return ob_get_clean();
				break;
				
			case 'archive-products':
				$type = 'products';
				$settings['class'] = '';
				
				if( get_post_type() == DTWCBE_Post_Types::CPT ){
					$settings['query_post_type'] = 'preview';
					$settings['orderby'] = '';
					$settings['order'] = '';
				}
				
				$isTheme = wc_get_theme_slug_for_templates();
				
				if( $isTheme == 'shopme' ){
					$settings['class'] = '';
				}
				if( $isTheme == 'bridge' ){
					$settings['class'] = 'container_inner default_template_holder clearfix';
				}
				
				
				ob_start();
				
				if ( WC()->session ) {
					wc_print_notices();
				}
				// For Render.
				if ( ! isset( $GLOBALS['post'] ) ) {
					$GLOBALS['post'] = null; // WPCS: override ok.
				}

				$shortcode = new DTWCBE_Products_Renderer( $settings, $type );
				
				$content = $shortcode->get_content();
				
				if ( $content ) {
					echo ( $content );
				} elseif ( $settings['nothing_found_message'] ) {
					echo '<div class="elementor-nothing-found elementor-products-nothing-found">' . esc_html( $settings['nothing_found_message'] ) . '</div>';
				}
				
				return ob_get_clean();
				
				break;
				
			default: // archive-title
				ob_start();
				if( $term_id !== 0 && get_post_type() == DTWCBE_Post_Types::CPT ){
					$tax = get_post_meta(get_the_ID(), 'dtwcbe_condition_archive_product_is_tax', true);
					$term = get_term_by('term_id', $term_id, $tax);
					if ( $term && ! empty( $term->name ) ) {
						echo esc_html( $term->name ) ; // WPCS: XSS ok.
					}
				}else{
					woocommerce_page_title();
				}
					
				return ob_get_clean();
				break;
		}
	}
	
	public static function get_archive_page_id_in_condition(){
		$term_id = 0;
		
		$template_id = get_the_ID();
		$dtwcbe_shop_custom_page_id = get_option('dtwcbe_shop_custom_page_id', '');
		
		if( $dtwcbe_shop_custom_page_id == $template_id ){
			return $term_id;
		}else{
				
			$dtwcbe_condition_archive_product_is_tax = get_post_meta($template_id, 'dtwcbe_condition_archive_product_is_tax', true);
				
			if( $dtwcbe_condition_archive_product_is_tax == 'product_cat' ){
				$dtwcbe_condition_archive_product_in_cat = get_post_meta($template_id, 'dtwcbe_condition_archive_product_in_cat', true);
				if( !empty($dtwcbe_condition_archive_product_in_cat) ){
					$categories = explode(',',$dtwcbe_condition_archive_product_in_cat);
					if( $categories[0] == 'all' ){
						$term_id = self::get_newest_term_id_in_condition('product_cat');
					}else{
						$cat = get_term_by('slug', $categories[0], 'product_cat');
						$term_id = $cat->term_id;
					}
					
				}
			}elseif( $dtwcbe_condition_archive_product_is_tax == 'product_tag' ){
				$dtwcbe_condition_archive_product_in_tag = get_post_meta($template_id, 'dtwcbe_condition_archive_product_in_tag', true);
				if( !empty($dtwcbe_condition_archive_product_in_tag) ){
					$tags = explode(',',$dtwcbe_condition_archive_product_in_tag);
					if( $tags[0] == 'all' ){
						$term_id = self::get_newest_term_id_in_condition('product_tag');
					}else{
						$tag = get_term_by('slug', $tags[0], 'product_tag');
						$term_id = $tag->term_id;
					}
				}
			}else{}
		}
		
		return $term_id;
	}
	
	public static function get_newest_term_id_in_condition($tax = ''){
		if( $tax == '' )
			return;
		$terms = get_terms( array(
          'taxonomy' => $tax,
          'hide_empty' => false,
			)
		);
		if( is_array($terms) && isset($terms[0]) ){
			return $terms[0]->term_id;
		}
		return 0;
	}
	
	public function body_classes($classes){
		$post_type = get_post_type();
		if( is_cart() || $post_type == DTWCBE_Post_Types::CPT ){
			$classes[] = 'woocommerce-builder-elementor';
		}
		
		return $classes;
	}
}

DTWCBE_Archive_Product_Elementor::instance();