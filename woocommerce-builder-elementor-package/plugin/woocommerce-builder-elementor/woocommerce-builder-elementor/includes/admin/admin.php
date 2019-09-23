<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DTWCBE_Admin{
	
	/**
	* @var null
	*/
	private static $_instance = null;
	
	/**
	 * Elementor template-library post-type slug.
	 */
	const CPT = 'dtwcbe_woo_library';
	
	/**
	 * Elementor template-library taxonomy slug.
	 */
	const TAXONOMY_TYPE_SLUG = 'dtwcbe_woo_library_type';
	
	/**
	 * Elementor template-library category slug.
	 */
	const TAXONOMY_CATEGORY_SLUG = 'elementor_library_category';
	
	const TYPE_META_KEY = '_dtwcbe_woo_template_type';
	
	const INSTANCES_META_KEY = '_dtwcbe_woo_instance_type';
	
	const ADMIN_SUBMENU_PAGE = 'edit.php?post_type=elementor_library';
	
	const ADMIN_MENU_SLUG = 'edit.php?post_type=dtwcbe_woo_library';
	
	const ADMIN_SCREEN_ID = 'edit-dtwcbe_woo_library';
	
	private static $template_types = [];
	
	private $post_type_object;
	
	private static $properties = [];
	
	private $main_id;
	
	protected $post;
	
	public $post_type;
	
	protected $cpt = [];
	
	protected $types = [];
	
	public static function get_template_types() {
		return self::$template_types;
	}
	
	public static function get_template_type( $template_id ) {
		return get_post_meta( $template_id, self::TYPE_META_KEY, true );
	}
	
	public static function is_base_templates_screen() {
		global $current_screen;
	
		if ( ! $current_screen ) {
			return false;
		}
	
		return 'edit' === $current_screen->base && self::CPT === $current_screen->post_type;
	}
	
	public static function add_template_type( $type ) {
		self::$template_types[ $type ] = $type;
	}
	
	public static function remove_template_type( $type ) {
		if ( isset( self::$template_types[ $type ] ) ) {
			unset( self::$template_types[ $type ] );
		}
	}
	
	/**
	* Instance Control
	*/
	public static function instance() {
		if ( is_null(  self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	

	private function is_current_screen() {
		global $pagenow, $typenow;
	
		return 'edit.php' === $pagenow && self::CPT === $typenow;
	}
	
	public function output_filter_for( $taxonomy ){
		$taxonomy = 'product';
	}
	
	
	public function add_actions() {
		// Add WooCommerce Builder Templates
		add_action( 'admin_menu', [ $this, 'admin_menu' ], 201 );
		add_filter( 'post_row_actions', [ $this, 'filter_post_row_actions' ], 12, 2 );
		add_action( 'save_post', [ $this, 'on_save_post' ], 10, 2 );
		add_filter( 'display_post_states', [ $this, 'remove_elementor_post_state_from_library' ], 11, 2 );
		
		// Template type column.
		add_action( 'manage_' . self::CPT . '_posts_columns', [ $this, 'admin_columns_headers' ] );
		add_action( 'manage_' . self::CPT . '_posts_custom_column', [ $this, 'admin_columns_content' ], 10, 2 );
		
		add_action ('admin_enqueue_scripts',array($this,'enqueue_styles'));
		add_action ('admin_enqueue_scripts',array($this,'enqueue_scripts'));
		
		// Print template library tabs.
		add_filter( 'views_edit-' . self::CPT, [ $this, 'admin_print_tabs' ] );
		
		// Admin Actions
		add_action( 'admin_action_dtwcbe_woo_new_post', [ $this, 'admin_action_new_post' ] );
		add_action( 'admin_action_dtwcbe_woo_options', [ $this, 'admin_action_woo_options' ] );
		
		add_action( 'current_screen', [ $this, 'init_new_template' ] );
		
		// Show blank state.
		add_action( 'manage_posts_extra_tablenav', [ $this, 'maybe_render_blank_state' ] );
		
		
		// Product, checkout page meta data
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'), 5);
		add_action('save_post', array($this, 'save_product_meta_data'), 1, 2 );
	}
	
	public function includes(){
	}
	
	/**
	 * Register Elementor WooCommerce Builder sub-menu.
	 *
	 * Add new Elementor WooCommerce Builder sub-menu under the main Templates menu.
	 *
	 * Fired by `admin_menu` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_menu() {
		add_submenu_page(
			self::ADMIN_SUBMENU_PAGE,
			esc_html__( 'WooCommerce Builder', 'woocommerce-builder-elementor' ),
			esc_html__( 'WooCommerce Builder', 'woocommerce-builder-elementor' ),
			'edit_posts',
			self::ADMIN_MENU_SLUG
		);
	}

	
	private function get_current_tab_group( $default = '' ) {
		$current_tabs_group = $default;
	
		if ( ! empty( $_REQUEST['tabs_group'] ) ) {
			$current_tabs_group = $_REQUEST['tabs_group'];
		}
	
		return $current_tabs_group;
	}
	
	final protected static function get_items( array $haystack, $needle = null ) {
		if ( $needle ) {
			return isset( $haystack[ $needle ] ) ? $haystack[ $needle ] : null;
		}

		return $haystack;
	}
	
	public static function get_property( $key ) {
	
		if ( ! isset( self::$properties[ $id ] ) ) {
			self::$properties[ $id ] = static::get_properties();
		}
	
		return self::get_items( self::$properties[ $id ], $key );
	}
	
	public static function get_properties() {
		return [
			'is_editable' => true,
		];
	}
	
	public function filter_post_row_actions( $actions, \WP_Post $post ) {
		if ( get_post_type( $post->ID ) == self::CPT && $this->is_built_with_elementor() && $this->is_editable_by_current_user() ) {
			$actions['edit_with_elementor'] = sprintf(
				'<a href="%1$s">%2$s</a>',
				$this->get_edit_url( get_post_meta( $post->ID, self::TYPE_META_KEY, true), $post->ID ),
				esc_html__( 'Edit with Elementor', 'woocommerce-builder-elementor' )
			);
		}
		
		return $actions;
	}
	
	/**
	 * Is built with Elementor.
	 *
	 * Check whether the post was built with Elementor.
	 *
	 * @access public
	 *
	 * @return bool Whether the post was built with Elementor.
	 */
	
	public function is_built_with_elementor() {
		return  ! ! get_post_meta( $this->post->ID, '_elementor_edit_mode', true );
	}
	
	public function is_editable_by_current_user() {
		$post_type = self::CPT;
		
		$post_type_object = get_post_type_object( $post_type );
		
		return current_user_can( $post_type_object->cap->edit_posts );
	}
	/**
	 * Remove Elementor post state.
	 *
	 * Remove the 'elementor' post state from the display states of the post.
	 *
	 * Used to remove the 'elementor' post state from the template library items.
	 *
	 * Fired by `display_post_states` filter.
	 *
	 * @access public
	 *
	 * @param array    $post_states An array of post display states.
	 * @param \WP_Post $post        The current post object.
	 *
	 * @return array Updated array of post display states.
	 */
	public function remove_elementor_post_state_from_library( $post_states, $post ) {
		if ( self::CPT === $post->post_type && isset( $post_states['elementor'] ) ) {
			unset( $post_states['elementor'] );
		}
		return $post_states;
	}
	
	/**
	 * On template save.
	 *
	 * Run this method when template is being saved.
	 *
	 * Fired by `save_post` action.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    The current post object.
	 */
	public function on_save_post( $post_id, \WP_Post $post ) {
		if ( self::CPT !== $post->post_type ) {
			return;
		}
	
		if ( self::get_template_type( $post_id ) ) { // It's already with a type
			return;
		}
	
		// Don't save type on import, the importer will do it.
		if ( did_action( 'import_start' ) ) {
			return;
		}
	
		$this->save_item_type( $post_id, 'page' );
	}
	
	/**
	 * Save item type.
	 *
	 * When saving/updating templates, this method is used to update the post
	 * meta data and the taxonomy.
	 *
	 * @since 1.0.1
	 * @access private
	 *
	 * @param int    $post_id Post ID.
	 * @param string $type    Item type.
	 */
	private function save_item_type( $post_id, $type ) {
		update_post_meta( $post_id, self::TYPE_META_KEY, $type );
	
		wp_set_object_terms( $post_id, $type, self::TAXONOMY_TYPE_SLUG );
	}
	
	/**
	 * Print admin tabs.
	 *
	 * Used to output the template library tabs with their labels.
	 *
	 * Fired by `views_edit-elementor_library` filter.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param array $views An array of available list table views.
	 *
	 * @return array An updated array of available list table views.
	 */
	public function admin_print_tabs( $views ) { 
		$current_type = '';
		$active_class = ' nav-tab-active';
		
		$current_tabs_group = $this->get_current_tab_group();
	
		if ( ! empty( $_REQUEST[ self::TAXONOMY_TYPE_SLUG ] ) ) {
			$current_type = $_REQUEST[ self::TAXONOMY_TYPE_SLUG ];
			$active_class = '';
		}
	
		$url_args = [
			'post_type' => self::CPT,
		];
	
		$baseurl = add_query_arg( $url_args, admin_url( 'edit.php' ) );
		
		$doc_types = self::get_document_types();
		
		?>
			<div id="woocomerce-builder-template-library-tabs-wrapper" class="nav-tab-wrapper">
				<a class="nav-tab<?php echo esc_attr( $active_class ); ?>" href="<?php echo esc_url( $baseurl ); ?>">
					<?php
					esc_html_e( 'All', 'woocommerce-builder-elementor' );
					?>
				</a>
				<?php
				foreach ( $doc_types as $type ) :
					$active_class = '';
	
					if ( $current_type === $type ) {
						$active_class = ' nav-tab-active';
					}
	
					$type_url = add_query_arg( self::TAXONOMY_TYPE_SLUG, $type, $baseurl );
					$type_label = self::get_template_label_by_type( $type );
					
					echo "<a class='nav-tab{$active_class}' href='{$type_url}'>{$type_label}</a>";
				endforeach;
				?>
			</div>
			<?php
			if( !empty($current_type) ): ?>
				<div id="woocomerce-builder-options">
					<?php
					switch ( $current_type ):
					
						case 'my-account':
							?>
							<div class="woocomerce-builder-options-content">
							<h3><?php esc_html_e('Page Setup', 'woocommerce-builder-elementor') ?></h3>
							<form id="woocomerce-builder-options__form" action="<?php esc_url( admin_url( '/edit.php' ) ); ?>">
								<input type="hidden" name="action" value="dtwcbe_woo_options">
								<input type="hidden" name="current_url" value="<?php echo esc_url("//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>">
								<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce( 'dtwcbe_woo_action_options' ); ?>">
								
								<table class="form-table">
									<tbody>
										<tr valign="top">
											<th scope="row"><label for="dtwcbe_myaccount_page_id"><?php esc_html_e('My account page', 'woocommerce-builder-elementor') ?></label></th>
											<td>
											<?php
											$dtwcbe_myaccount_page_id = get_option('dtwcbe_myaccount_page_id', '');
											
											$myaccount_tpls = get_posts( 
												array(
													'post_type'=> self::CPT,
													'post_status'=> 'publish,private',
													'meta_key' => self::TYPE_META_KEY,
													'meta_value' => 'my-account',
													'posts_per_page'=>-1
												)
											);
											echo '<select name="dtwcbe_myaccount_page_id" id="dtwcbe_myaccount_page_id" class="" data-placeholder="'.esc_attr__( 'Select a template&hellip;','woocommerce-builder-elementor').'">';
											echo '<option value = "" >'. esc_html__( '-- None (Use theme layout) --','woocommerce-builder-elementor') . '</option>';
											foreach ($myaccount_tpls as $c_tpl) {
												echo '<option value="'. $c_tpl->ID .'" '. selected( $dtwcbe_myaccount_page_id, $c_tpl->ID, false ) .'>'. $c_tpl->post_title. '</option>';
											}
											echo '</select>';
											?>
											<p class="description"><?php esc_html_e('Select a Template for My account page.', 'woocommerce-builder-elementor');
												echo '<br/>';
												if( !empty($dtwcbe_myaccount_page_id) ){
													echo '<a href="'.esc_url( $this->get_edit_url('my-account', $dtwcbe_myaccount_page_id) ).'"> '.esc_html__('Edit with Elementor', 'woocommerce-builder-elementor').'</a>';
												}?>
											</p>
											</td>
										</tr>
										<tr valign="top">
											<th scope="row"><label for="dtwcbe_myaccount_login_page_id"><?php esc_html_e('My account login', 'woocommerce-builder-elementor') ?></label></th>
											<td>
											<?php
											$dtwcbe_myaccount_login_page_id = get_option('dtwcbe_myaccount_login_page_id', '');
											
											$myaccount_login_tpls = get_posts( 
												array(
													'post_type'=> self::CPT,
													'post_status'=> 'publish,private',
													'meta_key' => self::TYPE_META_KEY,
													'meta_value' => 'my-account',
													'posts_per_page'=>-1
												)
											);
											echo '<select name="dtwcbe_myaccount_login_page_id" id="dtwcbe_myaccount_login_page_id" class="" data-placeholder="'.esc_attr__( 'Select a template&hellip;','woocommerce-builder-elementor').'">';
											echo '<option value = "" >'. esc_html__( '-- None (Use theme layout) --','woocommerce-builder-elementor') . '</option>';
											foreach ($myaccount_login_tpls as $c_tpl) {
												echo '<option value="'. $c_tpl->ID .'" '. selected( $dtwcbe_myaccount_login_page_id, $c_tpl->ID, false ) .'>'. $c_tpl->post_title. '</option>';
											}
											echo '</select>';
											?>
											<p class="description"><?php esc_html_e('Select a Template for My account login page.', 'woocommerce-builder-elementor');
												echo '<br/>';
												if( !empty($dtwcbe_myaccount_login_page_id) ){
													echo '<a href="'.esc_url( $this->get_edit_url('my-account', $dtwcbe_myaccount_login_page_id) ).'"> '.esc_html__('Edit with Elementor', 'woocommerce-builder-elementor').'</a>';
												}?>
											</p>
											</td>
										</tr>
									</tbody>
								</table>
								<button id="woocomerce-builder-elementor-options__form__submit" class="elementor-button elementor-button-success"><?php esc_html_e('Save Changes', 'woocommerce-builder-elementor')?></button>
							</form>
							</div>
							<?php
						break;

						case 'thankyou':
							?>
							<div class="woocomerce-builder-options-content">
							<h3><?php esc_html_e('Page Setup', 'woocommerce-builder-elementor') ?></h3>
							<form id="woocomerce-builder-options__form" action="<?php esc_url( admin_url( '/edit.php' ) ); ?>">
								<input type="hidden" name="action" value="dtwcbe_woo_options">
								<input type="hidden" name="current_url" value="<?php echo esc_url("//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>">
								<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce( 'dtwcbe_woo_action_options' ); ?>">
								
								<table class="form-table">
									<tbody>
										<tr valign="top">
											<th scope="row"><label for="dtwcbe_thankyou_page_id"><?php esc_html_e('Thank You Page', 'woocommerce-builder-elementor') ?></label></th>
											<td>
											<?php
											$thankyou_page_id = get_option('dtwcbe_thankyou_page_id', '');
											
											$thankyou_tpls = get_posts( 
												array(
													'post_type'=> self::CPT,
													'post_status'=> 'publish,private',
													'meta_key' => self::TYPE_META_KEY,
													'meta_value' => 'thankyou',
													'posts_per_page'=>-1
												)
											);
											echo '<select name="dtwcbe_thankyou_page_id" id="dtwcbe_thankyou_page_id" class="" data-placeholder="'.esc_attr__( 'Select a template&hellip;','woocommerce-builder-elementor').'">';
											echo '<option value = "" >'. esc_html__( '-- None (Use theme layout) --','woocommerce-builder-elementor') . '</option>';
											foreach ($thankyou_tpls as $tpl) {
												echo '<option value="'. $tpl->ID .'" '. selected( $thankyou_page_id, $tpl->ID, false ) .'>'. $tpl->post_title. '</option>';
											}
											echo '</select>';
											?>
											<p class="description"><?php esc_html_e('Select a Template for Thank You page.', 'woocommerce-builder-elementor');
												echo '<br/>';
												if( !empty($thankyou_page_id) ){
													echo '<a href="'.esc_url( $this->get_edit_url('thankyou', $thankyou_page_id) ).'"> '.esc_html__('Edit with Elementor', 'woocommerce-builder-elementor').'</a>';
												}?>
											</p>
											</td>					
										</tr>
									</tbody>
								</table>
								<button id="woocomerce-builder-elementor-options__form__submit" class="elementor-button elementor-button-success"><?php esc_html_e('Save Changes', 'woocommerce-builder-elementor')?></button>
							</form>
							</div>
							<?php
						break;
						
						case 'checkout-page':
							?>
							<div class="woocomerce-builder-options-content">
							<h3><?php esc_html_e('Page Setup', 'woocommerce-builder-elementor') ?></h3>
							<form id="woocomerce-builder-options__form" action="<?php esc_url( admin_url( '/edit.php' ) ); ?>">
								<input type="hidden" name="action" value="dtwcbe_woo_options">
								<input type="hidden" name="current_url" value="<?php echo esc_url("//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>">
								<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce( 'dtwcbe_woo_action_options' ); ?>">
								
								<table class="form-table">
									<tbody>
										<tr valign="top">
											<th scope="row"><label for="dtwcbe_checkout_page_id"><?php esc_html_e('Checkout Page', 'woocommerce-builder-elementor') ?></label></th>
											<td>
											<?php
											$checkout_page_id = get_option('dtwcbe_checkout_page_id', '');
											
											$checkout_tpls = get_posts( 
												array(
													'post_type'=> self::CPT,
													'post_status'=> 'publish,private',
													'meta_key' => self::TYPE_META_KEY,
													'meta_value' => 'checkout-page',
													'posts_per_page'=>-1
												)
											);
											echo '<select name="dtwcbe_checkout_page_id" id="dtwcbe_checkout_page_id" class="" data-placeholder="'.esc_attr__( 'Select a template&hellip;','woocommerce-builder-elementor').'">';
											echo '<option value = "" >'. esc_html__( '-- None (Use theme layout) --','woocommerce-builder-elementor') . '</option>';
											foreach ($checkout_tpls as $c_tpl) {
												echo '<option value="'. $c_tpl->ID .'" '. selected( $checkout_page_id, $c_tpl->ID, false ) .'>'. $c_tpl->post_title. '</option>';
											}
											echo '</select>';
											?>
											<p class="description"><?php esc_html_e('Select a Template for Checkout page.', 'woocommerce-builder-elementor');
												echo '<br/>';
												if( !empty($checkout_page_id) ){
													echo '<a href="'.esc_url( $this->get_edit_url('checkout-page', $checkout_page_id) ).'"> '.esc_html__('Edit with Elementor', 'woocommerce-builder-elementor').'</a>';
												}?>
											</p>
											</td>					
										</tr>
									</tbody>
								</table>
								<button id="woocomerce-builder-elementor-options__form__submit" class="elementor-button elementor-button-success"><?php esc_html_e('Save Changes', 'woocommerce-builder-elementor')?></button>
							</form>
							</div>
							<?php
						break;
						
						case 'cart-page':
							?>
							<div class="woocomerce-builder-options-content">
							<h3><?php esc_html_e('Page Setup', 'woocommerce-builder-elementor') ?></h3>
								<form id="woocomerce-builder-options__form" action="<?php esc_url( admin_url( '/edit.php' ) ); ?>">
									<input type="hidden" name="action" value="dtwcbe_woo_options">
									<input type="hidden" name="current_url" value="<?php echo esc_url("//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>">
									<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce( 'dtwcbe_woo_action_options' ); ?>">
									
									<table class="form-table">
										<tbody>
											<tr valign="top">
												<th scope="row"><label for="dtwcbe_cart_page_id"><?php esc_html_e('Cart Page', 'woocommerce-builder-elementor') ?></label></th>
												<td>
												<?php
												$cart_page_id = get_option('dtwcbe_cart_page_id', '');
												
												$carts_tpl = get_posts( 
													array(
														'post_type'=> self::CPT,
														'post_status'=> 'publish,private',
														'meta_key' => self::TYPE_META_KEY,
														'meta_value' => 'cart-page',
														'posts_per_page'=>-1
													)
												);
												echo '<select name="dtwcbe_cart_page_id" id="dtwcbe_cart_page_id" class="" data-placeholder="'.esc_attr__( 'Select a template&hellip;','woocommerce-builder-elementor').'">';
												echo '<option value = "" >'. esc_html__( '-- None (Use theme layout) --','woocommerce-builder-elementor') . '</option>';
												foreach ($carts_tpl as $c_tpl) {
													echo '<option value="'. $c_tpl->ID .'" '. selected( $cart_page_id, $c_tpl->ID, false ) .'>'. $c_tpl->post_title. '</option>';
												}
												echo '</select>';
												?>
												<p class="description"><?php esc_html_e('Select a Template for Cart page.', 'woocommerce-builder-elementor');
													echo '<br/>';
													if( !empty($cart_page_id) ){
														echo '<a href="'.esc_url( $this->get_edit_url( 'cart-page', $cart_page_id) ).'"> '.esc_html__('Edit with Elementor', 'woocommerce-builder-elementor').'</a>';
													}?>
												</p>
												</td>					
											</tr>
										</tbody>
									</table>
									<button id="woocomerce-builder-elementor-options__form__submit" class="elementor-button elementor-button-success"><?php esc_html_e('Save Changes', 'woocommerce-builder-elementor')?></button>
								</form>
								</div>
							<?php
							break;
							
						default: break;
						
					endswitch;
				?>
				</div>
			<?php
			endif;
			
			return $views;
	}
	
	public function admin_columns_headers( $posts_columns ) {
		// Replace original column that bind to the taxonomy - with another column.
		unset( $posts_columns['taxonomy-dtwcbe_woo_library_type'] );
	
		$offset = 2;
	
		$posts_columns = array_slice( $posts_columns, 0, $offset, true ) + [
			'dtwcbe_woo_library_type' => esc_html__( 'Type', 'woocommerce-builder-elementor' ),
		] + array_slice( $posts_columns, $offset, null, true );
	
	
		$offset = 3;
	
		$posts_columns = array_slice( $posts_columns, 0, $offset, true ) + [
			'instances' => esc_html__( 'Instances', 'woocommerce-builder-elementor' ),
		] + array_slice( $posts_columns, $offset, null, true );
	
		return $posts_columns;
	}
	
	public function admin_columns_content( $column_name, $post_id ) {
		if ( 'dtwcbe_woo_library_type' === $column_name ) {
			
			$document = array();
			
			$post_id = absint( $post_id );
			
			if ( ! $post_id || ! get_post( $post_id ) ) {
				return false;
			}
			
			if ( ! isset( $document[ $post_id ] ) ) {
			
				if ( wp_is_post_autosave( $post_id ) ) {
					$post_type = get_post_type( wp_get_post_parent_id( $post_id ) );
				} else {
					$post_type = get_post_type( $post_id );
				}
				
				$doc_type = 'post';
			
				if ( isset( $this->cpt[ $post_type ] ) ) {
					$doc_type = $this->cpt[ $post_type ];
				}
				
				$meta_type = get_post_meta( $post_id, self::TYPE_META_KEY, true );
				
				if ( $meta_type && isset( $this->types[ $meta_type ] ) ) {
					$doc_type = $meta_type;
				}
			
				$doc_type_class = $this->get_document_type( $doc_type );
				$document[ $post_id ] = $post_id;
			}
			
			if ( $document && $meta_type) {
				$this->print_admin_column_type($meta_type);
			}
		}
		
		if ( 'instances' === $column_name ) {
			
			$document = array();
				
			$post_id = absint( $post_id );
				
			if ( ! $post_id || ! get_post( $post_id ) ) {
				return false;
			}
				
			if ( ! isset( $document[ $post_id ] ) ) {
					
				if ( wp_is_post_autosave( $post_id ) ) {
					$post_type = get_post_type( wp_get_post_parent_id( $post_id ) );
				} else {
					$post_type = get_post_type( $post_id );
				}
			
				$doc_type = 'post';
					
				if ( isset( $this->cpt[ $post_type ] ) ) {
					$doc_type = $this->cpt[ $post_type ];
				}
			
				$meta_type = get_post_meta( $post_id, self::TYPE_META_KEY, true );
			
				if ( $meta_type && isset( $this->types[ $meta_type ] ) ) {
					$doc_type = $meta_type;
				}
					
				$doc_type_class = $this->get_document_type( $doc_type );
				$document[ $post_id ] = $post_id;
			}
			
			$instance = esc_html__('None', 'woocommerce-builder-elementor');
			
			if ( $document && $meta_type) {
				switch ( $meta_type ){
					
					case 'product':
						$dtwcbe_condition_product_all = get_option('dtwcbe_condition_product_all', '');
						if( $dtwcbe_condition_product_all == $post_id ){
							$instance = esc_html__('All Products', 'woocommerce-builder-elementor');
						}else{
							$dtwcbe_condition_product_in = get_post_meta($post_id, 'dtwcbe_condition_product_in', true);
							if( $dtwcbe_condition_product_in == 'in-cat' ){
								$dtwcbe_cat_in = get_post_meta($post_id, 'dtwcbe_cat_in', true);
								if( !empty($dtwcbe_cat_in) ){
									$instance = esc_html__('In Categories ', 'woocommerce-builder-elementor');
									$categories = explode(',',$dtwcbe_cat_in);
									foreach ($categories as $cate){
										$cat = get_term_by('slug', $cate, 'product_cat');
										$instance .= '#'.$cat->term_id . ' ';
									}
								}
							}elseif( $dtwcbe_condition_product_in == 'products' ){
								$dtwcbe_product_in = get_post_meta($post_id, 'dtwcbe_product_in', true);
								if( !empty($dtwcbe_product_in) ){
									$instance = esc_html__('In Products ', 'woocommerce-builder-elementor');
									$in_products = explode(',',$dtwcbe_product_in);
									foreach ($in_products as $product_e){
										$id_product = get_posts(array('post_type' => 'product', 'numberposts' => 1, 'post_name__in'  => array($product_e)));
										if( isset($id_product[0]) )
											$instance .= '#'.$id_product[0]->ID . ' ';
									}
								}
							}else{}
						}
						
						break;
					
					case 'product-archive':
						$dtwcbe_shop_custom_page_id = get_option('dtwcbe_shop_custom_page_id', '');
						if( $dtwcbe_shop_custom_page_id == $post_id ){
							$instance = esc_html__('Shop Page', 'woocommerce-builder-elementor');
						}else{
							$dtwcbe_condition_archive_product_is_tax = get_post_meta($post_id, 'dtwcbe_condition_archive_product_is_tax', true);
							if( $dtwcbe_condition_archive_product_is_tax == 'product_cat' ){
								$dtwcbe_condition_archive_product_in_cat = get_post_meta($post_id, 'dtwcbe_condition_archive_product_in_cat', true);
								if( !empty($dtwcbe_condition_archive_product_in_cat) ){
									$instance = esc_html__('In Categories ', 'woocommerce-builder-elementor');
									$categories = explode(',',$dtwcbe_condition_archive_product_in_cat);
									foreach ($categories as $cate){
										if( $cate === 'all' ){
											$instance = esc_html__('In All Categories ', 'woocommerce-builder-elementor');
											break;
										}
										$cat = get_term_by('slug', $cate, 'product_cat');
										$instance .= '#'.$cat->term_id . ' ';
									}
								}
							}elseif( $dtwcbe_condition_archive_product_is_tax == 'product_tag' ){
								$dtwcbe_condition_archive_product_in_tag = get_post_meta($post_id, 'dtwcbe_condition_archive_product_in_tag', true);
								if( !empty($dtwcbe_condition_archive_product_in_tag) ){
									$instance = esc_html__('In Tags ', 'woocommerce-builder-elementor');
									$tags = explode(',',$dtwcbe_condition_archive_product_in_tag);
									foreach ($tags as $tag){
										if( $tag === 'all' ){
											$instance = esc_html__('In All Tags ', 'woocommerce-builder-elementor');
											break;
										}
										$tag = get_term_by('slug', $tag, 'product_tag');
										$instance .= '#'.$tag->term_id . ' ';
									}
								}
							}else{}
						}
						
						break;
						
					case 'cart-page':
						$dtwcbe_cart_page_id = get_option('dtwcbe_cart_page_id', '');
						if( $dtwcbe_cart_page_id == $post_id ){
							$instance = esc_html__('Cart Page', 'woocommerce-builder-elementor');
						}
						break;
						
					case 'checkout-page':
						$dtwcbe_checkout_page_id = get_option('dtwcbe_checkout_page_id', '');
						if( $dtwcbe_checkout_page_id == $post_id ){
							$instance = esc_html__('Checkout Page', 'woocommerce-builder-elementor');
						}
						break;

					case 'thankyou':
						$dtwcbe_thankyou_page_id = get_option('dtwcbe_thankyou_page_id', '');
						if( $dtwcbe_thankyou_page_id == $post_id ){
							$instance = esc_html__('Thank You Page', 'woocommerce-builder-elementor');
						}
						break;
						
					case 'my-account':
						$dtwcbe_myaccount_page_id = get_option('dtwcbe_myaccount_page_id', '');
						if( $dtwcbe_myaccount_page_id == $post_id ){
							$instance = esc_html__('My Account', 'woocommerce-builder-elementor');
						}
						$dtwcbe_myaccount_login_page_id = get_option('dtwcbe_myaccount_login_page_id', '');
						if( $dtwcbe_myaccount_login_page_id == $post_id ){
							$instance = esc_html__('My Account Login', 'woocommerce-builder-elementor');
						}
						break;
						
					default: break;
				}
				
				$this->print_admin_column_instance( $instance );
			}else{
				$this->print_admin_column_instance( $instance );
			}
		}
	
	}
	
	public function print_admin_column_type( $type ) {
		
		$admin_filter_url = admin_url( self::ADMIN_MENU_SLUG . '&dtwcbe_woo_library_type=' . $type );
	
		printf( '<a href="%s">%s</a>', $admin_filter_url, self::get_template_label_by_type($type) );
	}
	
	public function print_admin_column_instance( $instance ) {
		echo esc_html($instance);
	}
	
	public static function get_document_types(){
		return array(
			'product',
			'product-archive',
			'cart-page',
			'checkout-page',
			'thankyou',
			'my-account',
		);
	}
	
	public static function get_template_label_by_type($template_type){
		$templates = array(
			'product' => esc_html__( 'Single Product', 'woocommerce-builder-elementor' ),
			'product-archive' => esc_html__( 'Product Archive', 'woocommerce-builder-elementor' ),
			'cart-page' => esc_html__( 'Cart', 'woocommerce-builder-elementor' ),
			'checkout-page' => esc_html__( 'Checkout', 'woocommerce-builder-elementor' ),
			'thankyou' => esc_html__( 'Thank You', 'woocommerce-builder-elementor' ),
			'my-account' => esc_html__( 'My Account', 'woocommerce-builder-elementor' ),
		);
		
		if( $template_type == 'get_types' )
			return $templates;
		
		if ( isset( $templates[ $template_type ] ) ) {
			$template_label = $templates[ $template_type ];
		} else {
			$template_label = ucwords( str_replace( [ '_', '-' ], ' ', $template_type ) );
		}
		
		return $template_label;
	}
	
	public function enqueue_styles(){
		wp_enqueue_style('dtwcbe-admin', DTWCBE_ASSETS_URL . 'css/admin.css');
	}
	
	public function enqueue_scripts(){
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');
		wp_register_script( 'dtwcbe-admin',DTWCBE_ASSETS_URL. 'js/admin.js', array('jquery'),DTWCBE_VERSION,false);
		wp_enqueue_script( 'dtwcbe-admin' );
		wp_enqueue_style('jquery-chosen', DTWCBE_ASSETS_URL. 'css/chosen/chosen.css');
		wp_enqueue_script( 'jquery-chosen', DTWCBE_ASSETS_URL . 'js/chosen/chosen.jquery.js', array( 'jquery' ), '1.1.0', true );
	}
	
	public function add_new_template_template() {
		include DTWCBE_PATH . 'includes/admin/admin-templates/new-template.php';
	}
	
	public function enqueue_new_template_scripts(){
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		wp_enqueue_script(
		'dtwcbe-new-template',
		DTWCBE_ASSETS_URL . 'js/new-template' . $suffix . '.js',
		[],
		DTWCBE_VERSION,
		true
		);
	}
	
	/**
	 * Admin action new post.
	 *
	 * When a new post action is fired the title is set to 'Elementor' and the post ID.
	 *
	 * Fired by `admin_action_dtwcbe_woo_new_post` action.
	 *
	 * @access public
	 */
	public function admin_action_new_post() {
		check_admin_referer( 'dtwcbe_woo_action_new_post' );
	
		if ( empty( $_GET['post_type'] ) ) {
			$post_type = 'post';
		} else {
			$post_type = $_GET['post_type'];
		}
		
		$post_type_object = get_post_type_object( $post_type );
		
		if ( ! $post_type_object )
			wp_die( esc_html__( 'Invalid post type.', 'woocommerce-builder-elementor' ) );
		
		if ( ! current_user_can( $post_type_object->cap->edit_posts ) ) {
			wp_die(
			'<h1>' . esc_html__( 'You need a higher level of permission.', 'woocommerce-builder-elementor' ) . '</h1>' .
			'<p>' . esc_html__( 'Sorry, you are not allowed to edit posts in this post type.', 'woocommerce-builder-elementor' ) . '</p>',
			403
			);
		}
	
		if ( empty( $_GET['template_type'] ) ) {
			$type = 'post';
		} else {
			$type = $_GET['template_type']; // XSS ok.
		}
	
		$post_data = isset( $_GET['post_data'] ) ? $_GET['post_data'] : [];
	
		$meta = [];
	
		/**
		 * Create new post meta data.
		 *
		 * Filters the meta data of any new post created.
		 *
		 * @since 2.0.0
		 *
		 * @param array $meta Post meta data.
		*/
		$meta = apply_filters( 'dtwcbe_create_new_post_meta', $meta );
	
		$post_data['post_type'] = $post_type;
		
		$this->create_post( $type, $post_data, $meta );
		
		wp_redirect( $this->get_edit_url( $type ) );
	
		die;
	}
	
	public function admin_action_woo_options(){
		check_admin_referer( 'dtwcbe_woo_action_options' );
		
		$options = array();
		$current_url= $_GET['current_url'];
		
		if ( isset( $_GET['dtwcbe_cart_page_id'] ) ) {
			$options['dtwcbe_cart_page_id'] = $_GET['dtwcbe_cart_page_id'];
		}
		
		if ( isset( $_GET['dtwcbe_checkout_page_id'] ) ) {
			$options['dtwcbe_checkout_page_id'] = $_GET['dtwcbe_checkout_page_id'];
		}

		if ( isset( $_GET['dtwcbe_thankyou_page_id'] ) ) {
			$options['dtwcbe_thankyou_page_id'] = $_GET['dtwcbe_thankyou_page_id'];
		}
		
		if ( isset( $_GET['dtwcbe_myaccount_page_id'] ) ) {
			$options['dtwcbe_myaccount_page_id'] = $_GET['dtwcbe_myaccount_page_id'];
		}
		
		if ( isset( $_GET['dtwcbe_myaccount_login_page_id'] ) ) {
			$options['dtwcbe_myaccount_login_page_id'] = $_GET['dtwcbe_myaccount_login_page_id'];
		}
		
		$this->update_woo_options( $options );
		
		wp_redirect( $current_url );
		
		die;
	}
	
	public function update_woo_options( $options = '' ){
		
		if( is_array($options) ){
			foreach ($options as $option => $value){
				update_option($option, $value);
			}
		}
		
	}
	
	/**
	 * Create a document.
	 *
	 * Create a new document using any given parameters.
	 *
	 * @access public
	 *
	 * @param string $type      Document type.
	 * @param array  $post_data An array containing the post data.
	 * @param array  $meta_data An array containing the post meta data.
	 *
	 * @return Document The type of the document.
	 */
	public function create_post( $type, $post_data = [], $meta_data = [] ) {
		$class = $this->get_document_type( $type, false );
		
		if ( ! $class ) {
			wp_die( sprintf( 'Type %s does not exist.', $type ) );
		}
		
		$post_title = '';
	
		if ( empty( $post_data['post_title'] ) ) {
			$post_data['post_title'] = esc_html__( 'WooCommerce Elementor', 'woocommerce-builder-elementor' );
			if ( 'post' !== $type ) {
				$post_data['post_title'] = sprintf(
					/* translators: %s: Document title */
					esc_html__( 'WooCommerce Elementor %s', 'woocommerce-builder-elementor' ),
					self::get_template_label_by_type($type)
				);
			}
			$update_title = true; $post_title = $post_data['post_title'];
		}
	
		$meta_data['_dtwcbe_edit_mode'] = 'builder';
	
		// Save the type as-is for plugins that hooked at `wp_insert_post`.
		$meta_data[ self::TYPE_META_KEY ] = $type;
	
		$post_data['meta_input'] = $meta_data;
	
		$post_id = wp_insert_post( $post_data );
	
		if ( ! empty( $update_title ) ) {
			$post_data['ID'] = $post_id;
			$post_data['post_title'] .= ' #' . $post_id;
	
			// The meta doesn't need update.
			unset( $post_data['meta_input'] );
	
			wp_update_post( $post_data );
		}
	
		// Let the $document to re-save the template type by his way.
		$document = $this->save_template_type($type);
		
		wp_set_object_terms( $post_id, $type, self::TAXONOMY_TYPE_SLUG );
		
		return $document;
	}
	
	/**
	 * Get document type.
	 *
	 * Retrieve the type of any given document.
	 *
	 * @access public
	 *
	 * @param string $type
	 *
	 * @param string $fallback
	 *
	 * @return Document|bool The type of the document.
	 */
	public function get_document_type( $type, $fallback = 'post' ) {
		$types = self::get_document_types();
	
		if ( isset( $types[ $type ] ) ) {
			return $types[ $type ];
		}
	
		if ( isset( $types[ $fallback ] ) ) {
			return $types[ $fallback ];
		}
	
		return false;
	}
	
	/**
	 * @since 2.3.0
	 * @access public
	 */
	public function save_template_type($type) {
		return $this->update_main_meta( self::TYPE_META_KEY, $type );
	}
	
	/**
	 * @access public
	 *
	 * @param string $key   Meta data key.
	 * @param string $value Meta data value.
	 *
	 * @return bool|int
	 */
	public function update_main_meta( $key, $value ) {
		return update_post_meta( $this->get_main_id(), $key, $value );
	}
	
	public function get_main_id() {
		if ( ! $this->main_id ) {
			
			$_this_post = $this->get_post();
			
			$post_id = $_this_post->ID;

			$parent_post_id = wp_is_post_revision( $post_id );

			if ( $parent_post_id ) {
				$post_id = $parent_post_id;
			}

			$this->main_id = $post_id;
		}
		
		return $this->main_id;
	}
	
	/**
	 * @access public
	 * @static
	 *
	 * @return mixed
	 */
	public function get_edit_url( $template_type = '', $postID = '' ) {
		$post_id = (empty($postID)) ? $this->get_main_id() : $postID;
		$url = add_query_arg(
			[
				'post' => $post_id,
				'action' => 'elementor',
				'woocommerce_builder_template_type' => $template_type,
			],
			admin_url( 'post.php' )
		);
	
		return $url;
	}
	
	public function init_new_template() {
		if ( self::ADMIN_SCREEN_ID !== get_current_screen()->id ) {
			return;
		}
	
		// Allow plugins to add their templates on admin_head.
		add_action( 'admin_head', [ $this, 'add_new_template_template' ] );
	
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_new_template_scripts' ] );
	}
	
	/**
	 * Maybe render blank state.
	 *
	 * When the template library has no saved templates, display a blank admin page offering
	 * to create the very first template.
	 *
	 * Fired by `manage_posts_extra_tablenav` action.
	 *
	 * @param string $which The location of the extra table nav markup: 'top' or 'bottom'.
	 */
	public function maybe_render_blank_state( $which ) {
		global $post_type;
	
		if ( self::CPT !== $post_type || 'bottom' !== $which ) {
			return;
		}
	
		global $wp_list_table;
	
		$total_items = $wp_list_table->get_pagination_arg( 'total_items' );
	
		if ( ! empty( $total_items ) || ! empty( $_REQUEST['s'] ) ) {
			return;
		}
	
		$inline_style = '#posts-filter .wp-list-table, #posts-filter .tablenav.top, .tablenav.bottom .actions, .wrap .subsubsub { display:none;}';
	
		$current_type = get_query_var( 'dtwcbe_woo_library_type' );
	
		// TODO: Better way to exclude widget type.
		if ( 'widget' === $current_type ) {
			return;
		}
	
		if ( empty( $current_type ) ) {
			$counts = (array) wp_count_posts( self::CPT );
			unset( $counts['auto-draft'] );
			$count  = array_sum( $counts );
	
			if ( 0 < $count ) {
				return;
			}
	
			$current_type = 'template';
	
			$inline_style .= '#woocomerce-template-library-tabs-wrapper {display: none;}';
		}
	
		$current_type_label = self::get_template_label_by_type( $current_type );
		?>
			<style type="text/css"><?php echo ($inline_style); ?></style>
			<div class="elementor-template_library-blank_state">
				<div class="elementor-blank_state">
					<i class="eicon-folder"></i>
					<h2>
						<?php
						/* translators: %s: Template type label. */
						printf( esc_html__( 'Create Your First %s', 'woocommerce-builder-elementor' ), $current_type_label );
						?>
					</h2>
					<p><?php echo esc_html__( 'Add templates and reuse them across your website. Easily export and import them to any other project, for an optimized workflow.', 'woocommerce-builder-elementor' ); ?></p>
					<a id="dtwcbe-elementor-template-library-add-new" class="elementor-button elementor-button-success" href="#">
						<?php
						/* translators: %s: Template type label. */
						printf( esc_html__( 'Add New %s', 'woocommerce-builder-elementor' ), $current_type_label );
						?>
					</a>
				</div>
			</div>
			<?php
	}
	
	public function get_post(){
		$args = array(
			'post_type' => self::CPT,
			'posts_per_page' => 1
		);
		
		$_this_post = wp_get_recent_posts($args, OBJECT);
		
		return $_this_post[0];
		
	}
	
	/**
	 * Add WE Meta boxes.
	 */
	public function add_meta_boxes() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';
		$post_id = get_the_ID();
		if( get_post_meta($post_id, self::TYPE_META_KEY, true) == 'product' )
			add_meta_box( 'dtwcbe-product-condition', esc_html__( 'Display Conditions', 'woocommerce-builder-elementor' ), array($this, 'add_meta_box_product_condition_output'), self::CPT, 'normal' );
		
		if( get_post_meta($post_id, self::TYPE_META_KEY, true) == 'product-archive' )
			add_meta_box( 'dtwcbe-archive-product-condition', esc_html__( 'Display Conditions', 'woocommerce-builder-elementor' ), array($this, 'add_meta_box_archive_product_condition_output'), self::CPT, 'normal' );
	}
	
	public function add_meta_box_product_condition_output( $post ){
		$template_id = get_the_ID();
		$condition_product_all = get_option('dtwcbe_condition_product_all', '');
		// Check status of condition_product_all
		if ( $condition_product_all && get_post_status ( $condition_product_all ) !== 'publish' ){
			$condition_product_all = '';
			update_option('dtwcbe_condition_product_all', '');
		}
		$condition_product_include = get_post_meta($template_id, 'dtwcbe_condition_product_all', true);
		$dtwcbe_condition_product_in = get_post_meta($template_id, 'dtwcbe_condition_product_in', true);
		
		$dtwcbe_cat_in = get_post_meta($template_id, 'dtwcbe_cat_in', true);
		$dtwcbe_product_in = get_post_meta($template_id, 'dtwcbe_product_in', true);
		
		$condition_product_all_disabled = '';
		if( $condition_product_all == '' ){
			$condition_product_all_disabled = '';
		}else{
			if( $condition_product_all != $template_id )
				$condition_product_all_disabled = 'disabled';
		}
		?>
		<div class="dtwcbe-product-condition">
			<div class="dtwcbe-product-condition-content">
				<div class="dtwcbe-elementor-template-library-blank-title"><?php esc_html_e('Where Do You Want to Display Your Single Product?', 'woocommerce-builder-elementor');?></div>
				<div class="dtwcbe-product-condition-builder">
					<table>
<!-- 						<tr> -->
<!-- 					    	<td>All Product (Selected) | Include</td> -->
<!-- 					    	<td>In Categories/Products</td> -->
<!-- 					    	<td>Multiselect Category | Products</td> -->
<!-- 					  </tr>  -->
						<tr>
					    	<td>
					    		<select name="dtwcbe_condition_product_all" id="dtwcbe_condition_product_all">
					    			<option value="include" <?php selected( $condition_product_include, 'include' );?>><?php esc_html_e('Include', 'woocommerce-builder-elementor');?></option>
					    			<option value="<?php echo absint($template_id); ?>" <?php selected( $condition_product_all, absint($template_id) ); echo esc_attr( $condition_product_all_disabled );?>>
					    				<?php esc_html_e('All Products', 'woocommerce-builder-elementor');?>
					    				<?php if( $condition_product_all_disabled == 'disabled' ) echo ' - #' . absint($condition_product_all); ?>
					    			</option>
					    		</select>
					    	</td>
					    	<td>
					    		<select name="dtwcbe_condition_product_in" id="dtwcbe_condition_product_in">
					    			<option value="in-cat" <?php selected( $dtwcbe_condition_product_in, 'in-cat' );?>><?php esc_html_e('In Categories', 'woocommerce-builder-elementor');?></option>
					    			<option value="products" <?php selected( $dtwcbe_condition_product_in, 'products' );?>><?php esc_html_e('Products', 'woocommerce-builder-elementor');?></option>
					    		</select>
					    	</td>
					    	<td>
					    		<div id="condition_product_in">
						    		<div class="cat_in">
						    			<?php $this->condition_categories( $dtwcbe_cat_in );?>
						    		</div>
						    		<div class="product_in">
						    			<?php $this->condition_product( $dtwcbe_product_in );?>
						    		</div>
					    		</div>
					    	</td>
					  </tr>
					</table>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					$dtwcbe_condition_product_all = jQuery('#dtwcbe_condition_product_all').val();

					is_condition_product_all( $dtwcbe_condition_product_all, '#dtwcbe_condition_product_in' );
					
					jQuery('#dtwcbe_condition_product_all').on('change', function(){
						var $_v = $(this).val();
						is_condition_product_all( $_v, '#dtwcbe_condition_product_in' );
					});

					function is_condition_product_all( $is_all = 'include', $_selector ){
						if( $is_all == 'include' ){
							jQuery($_selector).prop('disabled', false);
							jQuery('#condition_product_in').removeClass('hidden');
						}else{
							jQuery($_selector).prop('disabled', true);
							jQuery('#condition_product_in').addClass('hidden');
							jQuery('#condition_product_in').find('input').attr('value', '');
						}
					}

					
					$dtwcbe_condition_product_in = jQuery('#dtwcbe_condition_product_in').val();
					console.log($dtwcbe_condition_product_in);
					is_condition_product_in( $dtwcbe_condition_product_in, '#condition_product_in' );
					
					jQuery('#dtwcbe_condition_product_in').on('change', function(){
						var $_v = $(this).val();
						is_condition_product_in( $_v, '#condition_product_in' );
					});

					function is_condition_product_in( $is_cat = 'in-cat', $_selector ){
						if( $is_cat == 'in-cat' ){
							jQuery($_selector).find('.cat_in').show();
							jQuery($_selector).find('.product_in').hide();
						}else{
							jQuery($_selector).find('.cat_in').hide();
							jQuery($_selector).find('.product_in').show();
						}
					}
				});
			</script>
		</div>
		<?php
	}
	
	public function condition_categories( $value ){
		$category_ids = explode(',',$value);
		$args = array(
			'hide_empty' => 0,
		);
		$categories = get_terms( 'product_cat', $args );
		?>

		<select id="cat_in" multiple="multiple" class="cat_in dtwcbe-woo-select chosen_select_nostd" data-placeholder="<?php echo esc_attr__( 'Search for a category&hellip;', 'woocommerce-builder-elementor' );?>">
			<option value=""><?php echo esc_html__('-- Select --','woocommerce-builder-elementor'); ?></option>
		<?php if( ! empty($categories)){
			foreach ($categories as $cat): ?>
				<option value="<?php echo esc_attr( $cat->slug ); ?>" <?php selected( in_array( $cat->slug, $category_ids ) ); ?>><?php echo esc_html( $cat->name ); ?></option>
			<?php
			endforeach;
			}?>
		</select>
		<input id="cat_in" type="hidden" class="" name="dtwcbe_cat_in" value="<?php echo esc_attr($value)?>" />

		<?php
	}
	
	public function condition_product( $value ){
		$args = array(
			'numberposts'    => '-1',
			'post_status'    => 'publish',
			'posts_per_page' => '-1',
		);
		$get_products = wc_get_products($args);
		
		$dtwcbe_product_ins = explode(',',$value);
		$output = ''; 
		ob_start();
		?>
		<select id="dtwcbe_product_in" class="dtwcbe_product_in dtwcbe-woo-select chosen_select_nostd" multiple="multiple"  data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce-builder-elementor' ); ?>">
		<?php
		if(!empty($get_products)){
			foreach ( $get_products as $product ) {
				$product = wc_get_product( $product->get_id() );
				if ( is_object( $product ) ) {
					echo '<option value="' . esc_attr( $product->get_slug() ) . '"' . selected( in_array( $product->get_slug(), $dtwcbe_product_ins ) ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
				}
			}
		}
		?>
		</select>
		<input id="dtwcbe_product_in" type="hidden" name="dtwcbe_product_in" value="<?php echo esc_attr($value); ?>" />
		<?php
		echo ob_get_clean();
		
	}
	
	public function add_meta_box_archive_product_condition_output( $post ){
		$template_id = get_the_ID(); 
		$condition_shop_custom_page_id = get_option('dtwcbe_shop_custom_page_id', ''); 
		// Check status of condition_product_all
		if ( $condition_shop_custom_page_id && get_post_status ( $condition_shop_custom_page_id ) !== 'publish' ){
			$condition_shop_custom_page_id = '';
			update_option('dtwcbe_shop_custom_page_id', '');
		}
		$condition_archive_product_is_tax = get_post_meta($template_id, 'dtwcbe_condition_archive_product_is_tax', true);
		$condition_archive_product_in_cat = get_post_meta($template_id, 'dtwcbe_condition_archive_product_in_cat', true);
		$condition_archive_product_in_tag = get_post_meta($template_id, 'dtwcbe_condition_archive_product_in_tag', true);
		
		$condition_shop_custom_page_id_disabled = '';
		if( $condition_shop_custom_page_id == '' ){
			$condition_shop_custom_page_id_disabled = '';
		}else{
			if( $condition_shop_custom_page_id != $template_id )
				$condition_shop_custom_page_id_disabled = 'disabled';
		}
		?>
		<div class="dtwcbe-product-condition">
			<div class="dtwcbe-product-condition-content">
				<div class="dtwcbe-elementor-template-library-blank-title"><?php esc_html_e('Where Do You Want to Display Your Archive Product?', 'woocommerce-builder-elementor');?></div>
				<div class="dtwcbe-product-condition-builder">
					<table>
						<tr>
					    	<td>
					    		<select name="dtwcbe_condition_archive_product_is_tax" id="dtwcbe_condition_archive_product_is_tax">
					    			<option value="product_cat" <?php selected( $condition_archive_product_is_tax, 'product_cat' );?>><?php esc_html_e('Product Categories', 'woocommerce-builder-elementor');?></option>
					    			<option value="product_tag" <?php selected( $condition_archive_product_is_tax, 'product_tag' );?>><?php esc_html_e('Product Tags', 'woocommerce-builder-elementor');?></option>
					    			<option value="<?php echo absint($template_id); ?>" <?php selected( $condition_shop_custom_page_id, absint($template_id) ); echo esc_attr( $condition_shop_custom_page_id_disabled );?>>
					    				<?php esc_html_e('Shop Page', 'woocommerce-builder-elementor');?>
					    				<?php if( $condition_shop_custom_page_id_disabled == 'disabled' ) echo ' - #' . absint($condition_shop_custom_page_id); ?>
					    			</option>
					    		</select>
					    	</td>
					    	<td>
					    		<div id="condition_archive_product_in">
						    		<div class="product_cat_in">
						    			<?php $this->condition_archive_product_cat( $condition_archive_product_in_cat );?>
						    		</div>
						    		<div class="product_tag_in">
						    			<?php $this->condition_archive_product_tag( $condition_archive_product_in_tag );?>
						    		</div>
					    		</div>
					    	</td>
					  </tr>
					</table>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					$dtwcbe_condition_archive_product_is_tax = jQuery('#dtwcbe_condition_archive_product_is_tax').val();

					is_condition_archive_product_tax( $dtwcbe_condition_archive_product_is_tax, '#condition_archive_product_in' );
					
					jQuery('#dtwcbe_condition_archive_product_is_tax').on('change', function(){
						var $_v = $(this).val();
						is_condition_archive_product_tax( $_v, '#condition_archive_product_in' );
					});

					function is_condition_archive_product_tax( $is_tax = 'product_cat', $_selector ){
						if( $is_tax == 'product_cat' ){
							jQuery($_selector).find('.product_cat_in').show();
							jQuery($_selector).find('.product_tag_in').hide();
						}else if( $is_tax == 'product_tag' ){
							jQuery($_selector).find('.product_cat_in').hide();
							jQuery($_selector).find('.product_tag_in').show();
						}else{
							jQuery($_selector).find('.product_cat_in').hide();
							jQuery($_selector).find('.product_tag_in').hide();
							jQuery('#condition_archive_product_in').find('input').attr('value', '');
						}
					}
				});
			</script>
		</div>
		<?php
	}
	
	public function condition_archive_product_cat( $value ){
		$category_ids = explode(',',$value);
		$args = array(
			'hide_empty' => 0,
		);
		$categories = get_terms( 'product_cat', $args );
		?>
		<select id="dtwcbe_condition_archive_product_in_cat" multiple="multiple" class="dtwcbe_condition_archive_product_in_cat dtwcbe-woo-select chosen_select_nostd" data-placeholder="<?php echo esc_attr__( 'Search for a category&hellip;', 'woocommerce-builder-elementor' ); ?>">
			<option value="all" <?php selected( in_array( 'all', $category_ids ) ); ?>><?php echo esc_html__('All','woocommerce-builder-elementor') ; ?></option>
		<?php
		if( ! empty($categories)){
			foreach ($categories as $cat):
		?>
			<option value="<?php echo esc_attr( $cat->slug ); ?>" <?php selected( in_array( $cat->slug, $category_ids ) ); ?>><?php echo esc_html( $cat->name ); ?></option>
		<?php
			endforeach;
		} ?>
		</select>
		<input id="dtwcbe_condition_archive_product_in_cat" type="hidden" class="" name="dtwcbe_condition_archive_product_in_cat" value="<?php echo esc_attr($value );?>"/>
		<?php
	}
	
	public function condition_archive_product_tag( $value ){
		$tag_ids = explode(',',$value);
		$args = array(
			'hide_empty' => 0,
		);
		$tags = get_terms( 'product_tag', $args );
		?>
		<select id="dtwcbe_condition_archive_product_in_tag" multiple="multiple" class="dtwcbe_condition_archive_product_in_tag dtwcbe-woo-select chosen_select_nostd" data-placeholder="<?php echo esc_attr__( 'Search for a tag&hellip;', 'woocommerce-builder-elementor' ); ?>">
			<option value="all" <?php selected( in_array( 'all', $tag_ids ) ); ?>><?php echo esc_html__('All','woocommerce-builder-elementor'); ?></option>
		<?php
		if( ! empty($tags)){
			foreach ($tags as $tag): ?>
			<option value="<?php echo esc_attr( $tag->slug ); ?>" <?php selected( in_array( $tag->slug, $tag_ids ) ); ?>><?php echo esc_html( $tag->name ); ?></option>
		<?php
			endforeach;
		} ?>
		</select>
		<input id="dtwcbe_condition_archive_product_in_tag" type="hidden" class="" name="dtwcbe_condition_archive_product_in_tag" value="<?php echo esc_attr( $value ); ?>" />
		<?php
	}
		
	
	public function save_product_meta_data($post_id,$post){
		if( empty($post_id) || empty($post) )
			return;
	
		// Dont' save meta boxes for revisions or autosaves
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}
	
		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}
	
		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	
		if(!empty($_POST['dtwcbe_condition_product_all'])){
			update_post_meta( $post_id, 'dtwcbe_condition_product_all', $_POST['dtwcbe_condition_product_all'] );
		}else{
			delete_post_meta( $post_id, 'dtwcbe_condition_product_all');
		}
		
		if( !empty($_POST['dtwcbe_condition_product_all']) && $_POST['dtwcbe_condition_product_all'] !== 'include' ){
			update_option('dtwcbe_condition_product_all', $post_id);
		}
		
		if( !empty($_POST['dtwcbe_condition_product_all']) && $_POST['dtwcbe_condition_product_all'] == 'include' && $post_id == get_option('dtwcbe_condition_product_all') ){
			update_option('dtwcbe_condition_product_all', '');
		}
		
		if( !empty($_POST['dtwcbe_condition_product_all']) && $_POST['dtwcbe_condition_product_all'] == 'include' ){
			if( !empty($_POST['dtwcbe_condition_product_in']) ){
				update_post_meta($post_id, 'dtwcbe_condition_product_in', $_POST['dtwcbe_condition_product_in'] );
			}
			if( !empty($_POST['dtwcbe_cat_in']) ){
				update_post_meta($post_id, 'dtwcbe_cat_in', $_POST['dtwcbe_cat_in'] );
			}else{
				delete_post_meta( $post_id, 'dtwcbe_cat_in');
			}
			
			if( !empty($_POST['dtwcbe_product_in']) ){
				update_post_meta($post_id, 'dtwcbe_product_in', $_POST['dtwcbe_product_in'] );
			}else{
				delete_post_meta( $post_id, 'dtwcbe_product_in');
			}
		}else{
			delete_post_meta( $post_id, 'dtwcbe_condition_product_in');
			delete_post_meta( $post_id, 'dtwcbe_cat_in');
			delete_post_meta( $post_id, 'dtwcbe_product_in');
		}
		
		// Save Product Archive Condition
		if(!empty($_POST['dtwcbe_condition_archive_product_is_tax'])){
			update_post_meta( $post_id, 'dtwcbe_condition_archive_product_is_tax', $_POST['dtwcbe_condition_archive_product_is_tax'] );
		}else{
			delete_post_meta( $post_id, 'dtwcbe_condition_archive_product_is_tax');
		}
		
		if( !empty($_POST['dtwcbe_condition_archive_product_is_tax']) && $_POST['dtwcbe_condition_archive_product_is_tax'] !== 'product_cat' && $_POST['dtwcbe_condition_archive_product_is_tax'] !== 'product_tag' ){
			update_option('dtwcbe_shop_custom_page_id', $post_id);
		}else{
			update_option('dtwcbe_shop_custom_page_id', '');
		}
		
		if( $_POST['dtwcbe_condition_archive_product_is_tax'] == 'product_cat' ){
			
			if( !empty($_POST['dtwcbe_condition_archive_product_in_cat']) ){
				update_post_meta($post_id, 'dtwcbe_condition_archive_product_in_cat', $_POST['dtwcbe_condition_archive_product_in_cat'] );
			}else{
				delete_post_meta( $post_id, 'dtwcbe_condition_archive_product_in_cat');
			}
			
			delete_post_meta( $post_id, 'dtwcbe_condition_archive_product_in_tag');
			
		}elseif( $_POST['dtwcbe_condition_archive_product_is_tax'] == 'product_tag'){
			if( !empty($_POST['dtwcbe_condition_archive_product_in_tag']) ){
				update_post_meta($post_id, 'dtwcbe_condition_archive_product_in_tag', $_POST['dtwcbe_condition_archive_product_in_tag'] );
			}else{
				delete_post_meta( $post_id, 'dtwcbe_condition_archive_product_in_tag');
			}
			
			delete_post_meta( $post_id, 'dtwcbe_condition_archive_product_in_cat');
			
		}else{
			delete_post_meta( $post_id, 'dtwcbe_condition_archive_product_in_cat');
			delete_post_meta( $post_id, 'dtwcbe_condition_archive_product_in_tag');
		}
	}
	
	public function __construct(){
		
		$this->post = $this->get_post();
		
		$this->includes();
		$this->add_actions();
	}
	// End Class
}

DTWCBE_Admin::instance();