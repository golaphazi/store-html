<?php
namespace MetWoo;
defined( 'ABSPATH' ) || exit;
/**
 * Plugin final Class.
 * Handles dynamically loading classes only when needed. Check Elementor Plugin, Woocomerce Plugin Loaded or Install.
 *
 * @since 1.0.0
 */
final class Plugin{

    private static $instance;

    private $entries;

    private $forms;

    /**
     * __construct function
     * @since 1.0.0
     */
    public function __construct(){
        
        // load autoload method 
        Autoloader::run(); 
    }
    /**
     * Public function init.
     * call function for all
     *
     * @since 1.0.0
     */
    public function init(){

        // check woocommerce plugin
        if ( ! did_action( 'woocommerce_loaded' ) ) {
            add_action( 'admin_notices', array( $this, 'missing_woocommerce' ) );
            return;
        }

        // Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'missing_elementor' ) );
			return;
		}
		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'failed_elementor_version' ) );
			return;
        }
        
        // check permission for manage user
        if(current_user_can('manage_options')){
            add_action( 'admin_menu', [$this, 'admin_menu']);
        }
        
        add_action('admin_enqueue_scripts', [$this,'js_css_admin']);
      //  add_action('wp_enqueue_scripts', [$this,'js_css_public']);
        add_action( 'elementor/frontend/before_enqueue_scripts', [$this, 'elementor_js'] );

       // working builder module
        Core\Builders\Base::instance()->init();

       // $this->entries = Core\Entries\Init::instance();

       // working get instance of elementor widget
       // Widgets\Manifest::get_instance()->init();
    }

     /**
     * Public function version.
     * set for plugin version 
     *
     * @since 1.0.0
     */
    public function version(){
        return '1.0.0';
    }
    /**
     * Public function package_type.
     * set for plugin package type 
     *
     * @since 1.0.0
     */
    public function package_type(){
        return 'free';
    }

     /**
     * Public function plugin_url.
     * set for plugin url 
     *
     * @since 1.0.0
     */
    public function plugin_url(){
        return trailingslashit(plugin_dir_url( __FILE__ ));
    }

    /**
     * Public function plugin_dir.
     * set for plugin dir 
     *
     * @since 1.0.0
     */
    public function plugin_dir(){
        return trailingslashit(plugin_dir_path( __FILE__ ));
    }

     /**
     * Public function core_url .
     * set for plugin  core folder url 
     *
     * @since 1.0.0
     */
    public function core_url(){
        return $this->plugin_url() . 'core/';
    }

     /**
     * Public function core_dir .
     * set for plugin  core folder dir 
     *
     * @since 1.0.0
     */
    public function core_dir(){
        return $this->plugin_dir() . 'core/';
    }

    /**
     * Public function base_url .
     * set for plugin  base folder url 
     *
     * @since 1.0.0
     */
    public function base_url(){
        return $this->plugin_url() . 'base/';
    }

    /**
     * Public function base_dir .
     * set for plugin  base folder dir 
     *
     * @since 1.0.0
     */
    public function base_dir(){
        return $this->plugin_dir() . 'base/';
    }

    /**
     * Public function utils_url .
     * set for plugin  utils folder url 
     *
     * @since 1.0.0
     */
    public function utils_url(){
        return $this->plugin_url() . 'utils/';
    }

    /**
     * Public function utils_dir .
     * set for plugin  utils folder dir 
     *
     * @since 1.0.0
     */
    public function utils_dir(){
        return $this->plugin_dir() . 'utils/';
    }

     /**
     * Public function widgets_url .
     * set for plugin  widget folder url 
     *
     * @since 1.0.0
     */
    public function widgets_url(){
        return $this->plugin_url() . 'widgets/';
    }

    /**
     * Public function widgets_dir .
     * set for plugin  widget folder dir 
     *
     * @since 1.0.0
     */
    public function widgets_dir(){
        return $this->plugin_dir() . 'widgets/';
    }

    public function text_domain(){
        return 'metwoo';
    }

     /**
     * Public function js_css_public .
     * Include public function
     *
     * @since 1.0.0
     */
    public function js_css_public(){

        wp_enqueue_style('asRange', plugin_dir_url(__FILE__). 'libs/assets/css/asRange.min.css', false, $this->version());
        wp_enqueue_style('select2', plugin_dir_url(__FILE__). 'libs/assets/css/select2.min.css', false, $this->version());
        wp_enqueue_style('flatpickr', plugin_dir_url(__FILE__). 'libs/assets/css/flatpickr.min.css', false, $this->version());
        wp_enqueue_style('metform-ui', plugin_dir_url(__FILE__). 'libs/assets/css/metform-ui.css', false, $this->version());
        wp_enqueue_style('font-awesome', plugin_dir_url(__FILE__). 'libs/assets/css/font-awesome.min.css', false, $this->version());
        wp_enqueue_style('metform-style', plugin_dir_url(__FILE__). 'libs/assets/css/style.css', false, $this->version());
        
        wp_enqueue_script('asRange', plugin_dir_url(__FILE__) . 'libs/assets/js/jquery-asRange.min.js', array(), $this->version(), true);
        wp_enqueue_script('select2', plugin_dir_url(__FILE__) . 'libs/assets/js/select2.min.js', array(), $this->version(), true);
        wp_enqueue_script('flatpickr', plugin_dir_url(__FILE__) . 'libs/assets/js/flatpickr.js', array(), $this->version(), true);
       
        wp_register_script('recaptcha', 'https://www.google.com/recaptcha/api.js?onload=onloadMetFormCallback&render=explicit', array(), $this->version(), true);
        wp_enqueue_script('metform-submission', plugin_dir_url(__FILE__) . 'libs/assets/js/submission.js', array(), $this->version(), true);
        

    }

    public function elementor_js() {
        //wp_enqueue_script('metform-inputs', plugin_dir_url(__FILE__) . 'assets/js/inputs.js', array('elementor-frontend'), $this->version(), true);
    }

    public function js_css_admin(){

        // get screen id
        $screen = get_current_screen();
        
        // call Cpt class - Path: Core/Builders/ cpt.php
        $form_cpt = new Core\Builders\Cpt();
        
        if(in_array($screen->id, ['edit-'.$form_cpt->get_name(), 'metwoo_page_mt-form-settings'])){

            wp_enqueue_style('metwoo-ui', plugin_dir_url(__FILE__). 'assets/css/metwoo-ui.css', false, $this->version());
            wp_enqueue_style('metwoo-admin-style', plugin_dir_url(__FILE__). 'assets/css/admin-style.css', false, $this->version());
            
            wp_enqueue_script('metwoo-ui', plugin_dir_url(__FILE__) . 'assets/js/ui.min.js', array(), $this->version(), true);
            wp_enqueue_script('metwoo-admin-script', plugin_dir_url(__FILE__) . 'assets/js/admin-script.js', array(), $this->version(), true);
            wp_localize_script('metwoo-admin-script', 'metwoo_api', array( 'resturl' => get_rest_url(), 'siteurl' => get_option('siteurl'), 'nonce' =>  wp_create_nonce( 'wp_rest' )));
            
        }
        
        if($screen->id == 'edit-metwoo-entry' || $screen->id == 'metwoo-entry'){
            wp_enqueue_style('metwoo-ui', plugin_dir_url(__FILE__). 'assets/css/metwoo-ui.css', false, $this->version());
            wp_enqueue_script('metwoo-entry-script', plugin_dir_url(__FILE__) . 'assets/js/admin-entry-script.js', array(), $this->version(), true);
        }
    
    }

    function admin_menu() {

        add_menu_page(
            esc_html__('MetWoo', 'metwoo'),
            esc_html__('MetWoo', 'metwoo'),
            'read',
            'metwoo-menu',
            '',
            'dashicons-feedback',
            5
        );
    
    }

    public function missing_woocommerce() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		if ( file_exists( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php' ) ) {
			$btn['label'] = esc_html__('Activate Woocommerce', 'metwoo');
			$btn['url'] = wp_nonce_url( 'plugins.php?action=activate&plugin=woocommerce/woocommerce.php&plugin_status=all&paged=1', 'activate-plugin_woocommerce/woocommerce.php' );
		} else {
			$btn['label'] = esc_html__('Install Woocommerce', 'metwoo');
			$btn['url'] = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
		}

		Utils\Notice::push(
			[
				'id'          => 'unsupported-elementor-version',
				'type'        => 'error',
				'dismissible' => true,
				'btn'		  => $btn,
				'message'     => sprintf( esc_html__( 'MetWoo requires woocommerce Plugin, which is currently NOT RUNNING.', 'metwoo' ), '2.6.0' ),
			]
		);
    }

	public function missing_elementor() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		if ( file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' ) ) {
			$btn['label'] = esc_html__('Activate Elementor', 'metwoo');
			$btn['url'] = wp_nonce_url( 'plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php' );
		} else {
			$btn['label'] = esc_html__('Install Elementor', 'metwoo');
			$btn['url'] = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		}

		Utils\Notice::push(
			[
				'id'          => 'unsupported-elementor-version',
				'type'        => 'error',
				'dismissible' => true,
				'btn'		  => $btn,
				'message'     => sprintf( esc_html__( 'MetWoo requires Elementor version %1$s+, which is currently NOT RUNNING.', 'metwoo' ), '2.6.0' ),
			]
		);
    }


    public function failed_elementor_version(){
        
        $btn['label'] = esc_html__('Update Elementor', 'metwoo');
        $btn['url'] = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=elementor' ), 'upgrade-plugin_elementor' );
        
        Utils\Notice::push(
			[
				'id'          => 'unsupported-elementor-version',
				'type'        => 'error',
				'dismissible' => true,
				'btn'		  => $btn,
				'message'     => sprintf( esc_html__( 'MetWoo requires Elementor version %1$s+, which is currently NOT RUNNING.', 'metwoo' ), '2.6.0' ),
			]
		);
    }
    
	public function flush_rewrites(){
        $form_cpt = new Core\Builders\Cpt();
        $form_cpt->flush_rewrites();
	}

    public static function instance(){
        if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

}