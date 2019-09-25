<?php
/**
 * DTWCBE_Single_Product_Elementor
 *
 * @package WooCommerce-Builder-Elementor
 *
 */

defined( 'ABSPATH' ) || exit;

class DTWCBE_Single_Product_Elementor{

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
		add_filter( 'post_class', array($this, 'post_class') );
		
		// Get template loader default file for content product in the single-product.php template
		//add_filter( 'template_include', array( $this, 'get_single_product_template_loader' ),999999 );
		// Custom product page
		//add_action('template_redirect', array($this, 'get_register_single_product_template'), 999999);
		
		add_filter('wc_get_template_part', array($this, 'wc_get_template_part'), 99, 3);
		
		add_action('dtwcbe_product_elementor', array($this, 'the_product_page_content'));
		add_action('dtwcbe_product_elementor', array($this, 'product_data' ), 30 );
	}
	
	public function get_single_product_template_loader( $template ){
		
		if (is_singular('product') || is_singular('dtwcbe_woo_library')) {
			$product_template_id = self::get_register_single_product_template();
			$theme = wc_get_theme_slug_for_templates();
			if ($theme == 'labomba' || $theme == 'mrtailor' || $theme == 'consultix') {
				$find 	= array();
				$file 	= 'single-product.php';
				$find[] = 'woocommerce-builder-elementor-templates/' . $file;
				if( $product_template_id ){
					$template       = locate_template( $find );
					if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) )
						$template = DTWCBE_PATH . '/woocommerce-builder-elementor-templates/' . $file;
						
					return $template;
				}
			}
			// Select Page Template
			if( $product_template_id ){
				$page_template_slug = get_page_template_slug( $product_template_id );
				
				if ( 'elementor_header_footer' === $page_template_slug ) {
					$template = DTWCBE_MODULES_PATH . '/product-templates/header-footer.php';
				} elseif ( 'elementor_canvas' === $page_template_slug ) {
					$template = DTWCBE_MODULES_PATH . '/product-templates/canvas.php';
				}
			}
		}
	
		return $template;
	}
	
	public static function get_register_single_product_template() {
		if (is_singular('product')) {
	
			global $post;
	
			$product_template_id = 0;
			
			// Get All Template builder and check term in template
			$args = array(
				'post_status'=> 'publish',
				'meta_key' => '_dtwcbe_woo_template_type',
				'meta_value' => 'product',
				'post_type' => DTWCBE_Post_Types::CPT,
				'posts_per_page' => -1,
				'order' => 'asc',
			);
			$product_templates = get_posts($args);
			
			
			$dtwcbe_condition_product_in = get_post_meta($post->ID, 'dtwcbe_condition_product_in', true);
			
			$single_product_in_template_builder = 0;
			
			foreach ( $product_templates as $p_template ){
				$dtwcbe_product_in = get_post_meta($p_template->ID, 'dtwcbe_product_in', true);
				$dtwcbe_product_in_arr = explode(',', $dtwcbe_product_in);
				
				if( in_array($post->post_name, $dtwcbe_product_in_arr) ){
					$single_product_in_template_builder = $p_template->ID;
				}
			}
			
			if ( $single_product_in_template_builder ):
				$product_template_id = $single_product_in_template_builder;
			else:
				$product_terms = array();
				$terms = wp_get_post_terms($post->ID, 'product_cat');
				foreach ($terms as $term):
					array_push( $product_terms, $term->slug );
				endforeach;
				
				foreach ( $product_templates as $p_template ){
					$dtwcbe_cat_in = get_post_meta($p_template->ID, 'dtwcbe_cat_in', true);
					$dtwcbe_cat_in_arr = explode(',', $dtwcbe_cat_in);
					
					$containsSearch = count(array_intersect($product_terms, $dtwcbe_cat_in_arr));
					if( $containsSearch ){
						$product_template_id = $p_template->ID;
					}
				}
			endif;
			
			// Get setting option
			if ($product_template_id == 0) {
				$product_template_id = get_option('dtwcbe_condition_product_all', '');
			}
			
			if (!empty($product_template_id)) {
				return $product_template_id;
			}
	
			return '';
	
		}
	}
	
	public function wc_get_template_part($template, $slug, $name) {
		
		if ($slug === 'content' && $name === 'single-product') {
			$product_template_id = self::get_register_single_product_template();
			$file = 'content-single-product.php';
			$find[] = 'woocommerce-builder-elementor-templates/' . $file;
			if( $product_template_id ){
				$template = '';
				if (!$template || (!empty($status_options['template_debug_mode']) && current_user_can('manage_options'))) {
					$template = DTWCBE_PATH . 'woocommerce-builder-elementor-templates/' . $file;
					return $template;
				}
			}
		}
		
		return $template;
	}
	
	public static function the_product_page_content( $post ){
		$product_template_id = self::get_register_single_product_template();
		if( $product_template_id ){
			echo DTWCBE_WooCommerce_Builder_Elementor::$elementor_instance->frontend->get_builder_content_for_display( $product_template_id );
		}else{
			the_content();
		}
	}
	
	/**
	 * Generates Product structured data.
	 *
	 * Hooked into `dtwcbe_product_elementor` action hook.
	 *
	 * @param WC_Product $product Product data (default: null).
	 */
	public function product_data() {
		WC()->structured_data->generate_product_data();
	}
	
	public static function _render( $element = '', $settings = array()){
		global $post, $product;
		
		if( get_post_type() == 'product' ){
			$product_id = $product->get_id();
		}else{
			$product_id = self::get_product_id_in_condition();
			$product = wc_get_product( $product_id );
		}
		
		if( $product_id == 0 ) return esc_html__('Not supported', 'woocommerce-builder-elementor');
		
		switch ( $element ){
			case 'single-product-images':
				ob_start();
				if ( $product->is_on_sale() ) : ?>
				
					<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce-builder-elementor' ) . '</span>', $post, $product ); ?>
				
				<?php endif;
				
				// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
				if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
					return;
				}
				$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
				$post_thumbnail_id = $product->get_image_id();
				$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
					'woocommerce-product-gallery',
					'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
					'woocommerce-product-gallery--columns-' . absint( $columns ),
					'images',
				) );
				?>
				<div class="product elementor">
					<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
						<figure class="woocommerce-product-gallery__wrapper">
							<?php
							if ( $product->get_image_id() ) {
								$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
							} else {
								$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
								$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce-builder-elementor' ) );
								$html .= '</div>';
							}
					
							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
							?>
						</figure>
					</div>
				</div>
				<?php
				// On render widget from Editor - trigger the init manually.
				if ( \Elementor\Utils::is_ajax() ) {
					?>
					<script>
						jQuery( '.woocommerce-product-gallery' ).each( function() {
							jQuery( this ).wc_product_gallery();
						} );
					</script>
					<?php
				}
				return ob_get_clean();
				break;
				
			case 'single-product-title':
				
				return get_the_title($product_id);
				break;
				
			case 'single-product-rating':
				
				if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
					return;
				}
				
				$rating_count = $product->get_rating_count();
				$review_count = $product->get_review_count();
				$average      = $product->get_average_rating();
				
				ob_start();
				
				if ( $rating_count > 0 ) : ?>
					<div class="product elementor">
						<div class="woocommerce-product-rating">
							<?php echo wc_get_rating_html( $average, $rating_count ); ?>
							<?php if ( comments_open($product_id) ) : ?><a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce-builder-elementor' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</a><?php endif ?>
						</div>
					</div>
				<?php endif;
				return ob_get_clean();
				break;
				
			case 'single-product-price':
				
				return $product->get_price_html();
				break;
				
			case 'single-product-short-description':
				
				$excerpt = get_the_excerpt($product_id);
				
				$short_description = apply_filters( 'woocommerce_short_description', $excerpt );

				if ( ! $short_description ) {
					return;
				}
				return $short_description;
				
				break;
				
			case 'single-product-add-to-cart':
				ob_start();
				
				do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' );
				
				// WooCommerce Subscriptions - Display a product's first payment date on the product's page to make sure it's obvious to the customer when payments will start
				if( class_exists('WC_Subscriptions_Synchroniser') ){
					WC_Subscriptions_Synchroniser::products_first_payment_date( true );
				}
				
				return ob_get_clean();
				
				break;
				
			case 'single-product-meta':
			
				ob_start();
				
				$sku = $product->get_sku();
				?>
				<div class="product_meta">

					<?php do_action( 'woocommerce_product_meta_start' ); ?>
				
					<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
				
						<span class="sku_wrapper detail-container"><?php esc_html_e( 'SKU:', 'woocommerce-builder-elementor' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce-builder-elementor' ); ?></span></span>
				
					<?php endif; ?>
				
					<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in detail-container">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce-builder-elementor' ) . ' ', '</span>' ); ?>
				
					<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as detail-container">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce-builder-elementor' ) . ' ', '</span>' ); ?>
				
					<?php do_action( 'woocommerce_product_meta_end' ); ?>
				
				</div>
				<?php
				return ob_get_clean();
				
				break;
				
			case 'single-product-share':
			
				ob_start();
				
				if( function_exists('acoda_share_post') ){
					echo acoda_share_post();
				}else{
					woocommerce_template_single_sharing ();
				}
				
				return ob_get_clean();
				
				break;
				
			case 'single-product-tabs':
				setup_postdata( $product->get_id() );
				ob_start();
				if( get_post_type() == DTWCBE_Post_Types::CPT ){
					add_filter('the_content', array( __CLASS__, 'product_tab_content_preview'));
				}
				wc_get_template( 'single-product/tabs/tabs.php' );
				
				// On render widget from Editor - trigger the init manually.
				if ( \Elementor\Utils::is_ajax() ) {
					?>
					<script>
						jQuery( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).trigger( 'init' );
					</script>
					<?php
				}
						
				return ob_get_clean();
				
				break;
				
			case 'single-product-additional-information':
				ob_start();
				
				wc_get_template( 'single-product/tabs/additional-information.php' );
				
				return ob_get_clean();
				
				break;
				
			case 'single-product-content':
				$get_product_content = get_post($product_id);
				$content = $get_product_content->post_content;
				if( is_product() ){
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
				}
				return $content;
				
				break;
				
			case 'single-product-reviews':
				ob_start();
				
				if(comments_open() ){
					comments_template();
				}
				
				return ob_get_clean();
				
				break;
				
			case 'single-product-related':
				ob_start();
				
				$product = wc_get_product( $product_id );
				
				if ( ! $product ) {
					return;
				}
				$args = [
					'posts_per_page' => 4,
					'columns' => 4,
					'orderby' => $settings['orderby'],
					'order' => $settings['order'],
				];
		
				if ( ! empty( $settings['posts_per_page'] ) ) {
					$args['posts_per_page'] = $settings['posts_per_page'];
				}
		
				if ( ! empty( $settings['columns'] ) ) {
					$args['columns'] = $settings['columns'];
				}
		
				// Get visible related products then sort them at random.
				$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
		
				// Handle orderby.
				$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
		
				wc_get_template( 'single-product/related.php', $args );
				
				return ob_get_clean();
				
				break;
				
			case 'single-product-upsells':
				ob_start();
				$limit = '-1';
				$columns = 4;
				$orderby = 'rand';
				$order = 'desc';
				
				if ( ! empty( $settings['columns'] ) ) {
					$columns = $settings['columns'];
				}
				
				if ( ! empty( $settings['orderby'] ) ) {
					$orderby = $settings['orderby'];
				}
				
				if ( ! empty( $settings['order'] ) ) {
					$order = $settings['order'];
				}
				
				woocommerce_upsell_display( $limit, $columns, $orderby, $order );
				
				return ob_get_clean();
				
				break;
				
			case 'single-product-custom-key':
				
				if( empty( $settings['custom_key'] ) )
					return '';
					
				return get_post_meta( $product_id, $settings['custom_key'], true );
				
				break;
				
			default: 
				return '';
				break;
		}
	}
	
	public static function product_tab_content_preview($content){
		$product_id = self::get_product_id_in_condition();
		$product = wc_get_product( $product_id );
		$get_product_content = get_post($product_id);
		$content = $get_product_content->post_content;
		return $content;
	}
	
	public static function get_product_id_in_condition(){
		// Default
		$product_id = self::get_newest_product_id_in_condition();
		$template_id = get_the_ID();
		$dtwcbe_condition_product_all = get_option('dtwcbe_condition_product_all', '');
		
		if( $dtwcbe_condition_product_all == $template_id ){
			return $product_id;
		}else{
			
			$dtwcbe_condition_product_in = get_post_meta($template_id, 'dtwcbe_condition_product_in', true);
			
			if( $dtwcbe_condition_product_in == 'in-cat' ){
				$dtwcbe_cat_in = get_post_meta($template_id, 'dtwcbe_cat_in', true);
				if( !empty($dtwcbe_cat_in) ){
					$categories = explode(',',$dtwcbe_cat_in);
					
					$cat = get_term_by('slug', $categories[0], 'product_cat');
					
					$product_id = self::get_newest_product_id_in_condition( $cat->term_id );
					
				}
			}elseif( $dtwcbe_condition_product_in == 'products' ){
				$dtwcbe_product_in = get_post_meta($template_id, 'dtwcbe_product_in', true);
				if( !empty($dtwcbe_product_in) ){
					$in_products = explode(',',$dtwcbe_product_in);
					$id_product = get_posts(array('post_type' => 'product', 'numberposts' => 1, 'post_name__in'  => array($in_products[0])));
					$product_id = $id_product[0]->ID;
				}
			}else{}
		}
		
		return $product_id;
		
	}
	public static function get_newest_product_id_in_condition( $product_category_id = '' ){
	
		// Return the newest product id
		$product_id = 0;
		$args = array(
			'posts_per_page'      => 1,
			'post_type'           => 'product',
			'post_status'         => 'publish',
		);
		if( !empty($product_category_id) ){
			$args['tax_query'] = array(
			        array(
			            'taxonomy'      => 'product_cat',
			            'field' 		=> 'term_id', //This is optional, as it defaults to 'term_id'
			            'terms'         => $product_category_id,
			            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
			        )
			    );
			$get_product_id_in_cat = 0;
			$products = new WP_Query($args);
				while ($products->have_posts()){ $products->the_post();
					$get_product_id_in_cat = get_the_ID();
				}
				if( !empty($get_product_id_in_cat) )
					$product_id = $get_product_id_in_cat;
				return $product_id;
			wp_reset_postdata();
		}
		
		$product = get_posts($args);
		
		if( !isset($product[0]) ){
			return $product_id;
		}
		
		$product_id = $product[0]->ID;
		
		return $product_id;
	}
	
	public function body_classes($classes){
		$post_type = get_post_type();
		if($post_type == 'product' || $post_type == DTWCBE_Post_Types::CPT ){
			$classes[] = 'woocommerce';
			$classes[] = 'woocommerce-builder-elementor';
			$classes[] = 'single-product';
		}
		
		return $classes;
	}
	
	public function post_class($classes){
		if( is_singular('dtwcbe_woo_library') )
		{
			$classes[] = 'product';
		}
		return $classes;
	}
}

DTWCBE_Single_Product_Elementor::instance();