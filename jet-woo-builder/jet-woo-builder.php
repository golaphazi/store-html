<?php
/**
 * Plugin Name: JetWooBuilder For Elementor
 * Plugin URI:  https://crocoblock.com/plugins/jetwoobuilder/
 * Description: Your perfect asset in creating WooCommerce page templates using loads of special widgets & stylish page layouts
 * Version:     1.4.2
 * Author:      Zemez
 * Author URI:  https://zemez.io/zemezjet/
 * Text Domain: jet-woo-builder
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 * WC tested up to: 3.5
 * WC requires at least: 3.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Jet_Woo_Builder` doesn't exists yet.
if ( ! class_exists( 'Jet_Woo_Builder' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 */
	class Jet_Woo_Builder {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Holder for base plugin URL
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_url = null;

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		private $version = '1.4.2';

		/**
		 * Plugin properties
		 */
		public $framework;
		public $documents;
		public $parser;
		public $macros;

		/**
		 * Holder for base plugin path
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_path = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {

			// Load the core functions/classes required by the rest of the plugin.
			add_action( 'after_setup_theme', array( $this, 'load_framework' ), - 20 );

			// Internationalize the text strings used.
			add_action( 'init', array( $this, 'lang' ), - 999 );
			// Load files.
			add_action( 'init', array( $this, 'init' ), - 999 );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, array( $this, 'activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
		}

		/**
		 * Load plugin framework
		 */
		public function load_framework() {

			require $this->plugin_path( 'framework/loader.php' );

			$this->framework = new Jet_Woo_Builder_CX_Loader(
				array(
					$this->plugin_path( 'framework/interface-builder/cherry-x-interface-builder.php' ),
					$this->plugin_path( 'framework/post-meta/cherry-x-post-meta.php' ),
					$this->plugin_path( 'framework/db-updater/cherry-x-db-updater.php' )
				)
			);

		}

		/**
		 * Returns plugin version
		 *
		 * @return string
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * Manually init required modules.
		 *
		 * @return void
		 */
		public function init() {

			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
				return;
			}
			add_action( 'plugins_loaded', array( $this, 'woocommerce_loaded' ) );

			if ( class_exists( 'WooCommerce' ) ) {

				$this->load_files();

				jet_woo_builder_assets()->init();
				jet_woo_builder_integration()->init();
				jet_woo_builder_integration_woocommerce()->init();
				jet_woo_builder_post_type()->init();

				jet_woo_builder_settings()->init();
				jet_woo_builder_shortocdes()->init();
				jet_woo_builder_shop_settings()->init();
				jet_woo_builder_compatibility()->init();

				$this->documents = new Jet_Woo_Builder_Documents();
				$this->parser    = new Jet_Woo_Builder_Parser();
				$this->macros    = new Jet_Woo_Builder_Macros();

				if ( is_admin() ) {
					// Init DB upgrader
					require $this->plugin_path( 'includes/class-jet-woo-builder-db-upgrader.php' );
					jet_woo_builder_db_upgrader()->init();

				}
			}

			if ( is_admin() ) {

				require $this->plugin_path( 'includes/updater/class-jet-woo-builder-plugin-update.php' );

				jet_woo_builder_updater()->init( array(
					'version' => $this->get_version(),
					'slug'    => 'jet-woo-builder',
				) );

				// Init plugin changelog
				require $this->plugin_path( 'includes/updater/class-jet-woo-builder-plugin-changelog.php' );

				jet_woo_builder_plugin_changelog()->init( array(
					'name'     => 'JetWooBuilder For Elementor',
					'slug'     => 'jet-woo-builder',
					'version'  => $this->get_version(),
					'author'   => '<a href="https://zemez.io/zemezjet/">Zemez</a>',
					'homepage' => 'https://crocoblock.com/plugins/jetwoobuilder/',
					'banners'  => array(
						'high' => $this->plugin_url( 'assets/images/banner.png' ),
						'low'  => $this->plugin_url( 'assets/images/banner.png' ),
					),
				) );

			}

		}

		/**
		 * Check that WooCommerce active
		 */
		function woocommerce_loaded() {
			if ( ! class_exists( 'WooCommerce' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_woocommerce_plugin' ] );
				return;
			}
		}

		/**
		 * [admin_notice_missing_main_plugin description]
		 * @return [type] [description]
		 */
		public function admin_notice_missing_main_plugin() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			$elementor_link = sprintf(
				'<a href="%1$s">%2$s</a>',
				admin_url() . 'plugin-install.php?s=elementor&tab=search&type=term',
				'<strong>' . esc_html__( 'Elementor', 'jet-woo-builder' ) . '</strong>'
			);
			$message = sprintf(
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'jet-woo-builder' ),
				'<strong>' . esc_html__( 'Jet Woo Builder', 'jet-woo-builder' ) . '</strong>',
				$elementor_link
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
			if ( ! class_exists( 'WooCommerce' ) ) {
				$woocommerce_link = sprintf(
					'<a href="%1$s">%2$s</a>',
					admin_url() . 'plugin-install.php?s=woocommerce&tab=search&type=term',
					'<strong>' . esc_html__( 'WooCommerce', 'jet-woo-builder' ) . '</strong>'
				);
				$message = sprintf(
					esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'jet-woo-builder' ),
					'<strong>' . esc_html__( 'Jet Woo Builder', 'jet-woo-builder' ) . '</strong>',
					$woocommerce_link
				);
				printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
			}
		}
		/**
		 * [admin_notice_missing_main_plugin description]
		 * @return [type] [description]
		 */
		public function admin_notice_missing_woocommerce_plugin() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			$woocommerce_link = sprintf(
				'<a href="%1$s">%2$s</a>',
				admin_url() . 'plugin-install.php?s=woocommerce&tab=search&type=term',
				'<strong>' . esc_html__( 'WooCommerce', 'jet-woo-builder' ) . '</strong>'
			);
			$message = sprintf(
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'jet-woo-builder' ),
				'<strong>' . esc_html__( 'Jet Woo Builder', 'jet-woo-builder' ) . '</strong>',
				$woocommerce_link
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * Check if theme has elementor
		 *
		 * @return boolean
		 */
		public function has_elementor() {
			return defined( 'ELEMENTOR_VERSION' );
		}

		/**
		 * Returns utility instance
		 *
		 * @return object
		 */
		public function utility() {
			$utility = $this->get_core()->modules['cherry-utility'];

			return $utility->utility;
		}

		/**
		 * Load required files.
		 *
		 * @return void
		 */
		public function load_files() {
			require $this->plugin_path( 'includes/class-jet-woo-builder-assets.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-tools.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-post-type.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-documents.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-parser.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-macros.php' );

			require $this->plugin_path( 'includes/integrations/base/class-jet-woo-builder-integration.php' );
			require $this->plugin_path( 'includes/integrations/base/class-jet-woo-builder-integration-woocommerce.php' );

			require $this->plugin_path( 'includes/class-jet-woo-builder-template-functions.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-shortcodes.php' );

			require $this->plugin_path( 'includes/settings/class-jet-woo-builder-settings.php' );
			require $this->plugin_path( 'includes/settings/class-jet-woo-builder-shop-settings.php' );

			require $this->plugin_path( 'includes/lib/compatibility/class-jet-woo-builder-compatibility.php' );
		}

		/**
		 * Returns path to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 *
		 * @return string
		 */
		public function plugin_path( $path = null ) {

			if ( ! $this->plugin_path ) {
				$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path . $path;
		}

		/**
		 * Returns url to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 *
		 * @return string
		 */
		public function plugin_url( $path = null ) {

			if ( ! $this->plugin_url ) {
				$this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
			}

			return $this->plugin_url . $path;
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function lang() {
			load_plugin_textdomain( 'jet-woo-builder', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'jet-woo-builder/template-path', 'jet-woo-builder/' );
		}

		/**
		 * Returns path to template file.
		 *
		 * @return string|bool
		 */
		public function get_template( $name = null ) {

			$template = locate_template( $this->template_path() . $name );

			if ( ! $template ) {
				$template = $this->plugin_path( 'templates/' . $name );
			}

			if ( file_exists( $template ) ) {
				return $template;
			} else {
				return false;
			}
		}

		/**
		 * Compare WooCommerce version with your version
		 *
		 * @param string $version
		 *
		 * @return bool
		 */
		public static function wc_version_check( $version = '3.6' ) {
			if ( class_exists( 'WooCommerce' ) ) {
				global $woocommerce;
				if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function activation() {
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function deactivation() {
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}
}

if ( ! function_exists( 'jet_woo_builder' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function jet_woo_builder() {
		return Jet_Woo_Builder::get_instance();
	}
}

jet_woo_builder();
