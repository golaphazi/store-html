<?php
/**
 * Initialize Epic Dashboard
 *
 * @author Jegstudio
 * @license https://opensource.org/licenses/MIT
 * @package epic-dashboard
 */

namespace EPIC\Dashboard;

/**
 * Class Init
 *
 * @package EPIC\Dashboard
 */
class Init {

	/**
	 * Plugins instance
	 *
	 * @var Plugins Instance
	 */
	private $plugin;

	/**
	 * Theme instance
	 *
	 * @var Theme Instance
	 */
	private $theme;

	/**
	 * Init constructor.
	 */
	public function __construct() {
		$this->plugin = Plugins::get_instance();
		$this->theme  = Theme::get_instance();
		$this->tgm    = Tgm::get_instance();
		$this->initialize();
	}

	/**
	 * Initialize
	 */
	public function initialize() {
		add_filter( 'epic_get_admin_menu', array( &$this, 'get_admin_menu' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		add_action( 'admin_menu', array( $this, 'parent_menu' ) );
		add_action( 'admin_menu', array( $this, 'child_menu' ) );

		add_action( 'parse_request', array( $this, 'parse_request' ) );
		add_filter( 'query_vars', array( $this, 'query_vars' ) );
	}

	/**
	 * Additional query var for Epic System
	 *
	 * @param array $vars The array of whitelisted query variables.
	 *
	 * @return array
	 */
	public function query_vars( $vars ) {
		$vars[] = 'epic-system';
		return $vars;
	}

	/**
	 * Parse request for epic system
	 *
	 * @param \WP $wp Current WordPress environment instance (passed by reference).
	 */
	public function parse_request( $wp ) {
		if ( array_key_exists( 'epic-system', $wp->query_vars ) ) {
			$system = new System_Dashboard();
			$system->backend_status();
			exit;
		}
	}

	/**
	 * Load Asset
	 */
	public function load_assets() {
		wp_enqueue_style( 'epic-dashboard', EPIC_DASHBOARD_URL . '/assets/css/dashboard.css', null, EPIC_DASHBOARD_VERSION );
		wp_enqueue_style( 'font-awesome', EPIC_DASHBOARD_URL . '/assets/fonts/font-awesome/font-awesome.css', null, EPIC_DASHBOARD_VERSION );
		wp_enqueue_script( 'epic-admin', EPIC_DASHBOARD_URL . '/assets/js/epic.admin.js', null, EPIC_DASHBOARD_VERSION, true );
	}

	/**
	 * Parent Menu
	 */
	public function parent_menu() {
		$args = array(
			'page_title' => esc_html__( 'Epic', 'epic' ),
			'menu_title' => esc_html__( 'Epic', 'epic' ),
			'capability' => 'edit_theme_options',
			'menu_slug'  => 'epic',
			'function'   => null,
			'icon_url'   => 'dashicons-screenoptions',
			'position'   => 76
		);

		$args = apply_filters( 'epic_parent_menu', $args );

		add_menu_page( $args['page_title'], $args['menu_title'], $args['capability'], $args['menu_slug'], $args['function'], $args['icon_url'], $args['position'] );
	}

	/**
	 * Child Menu
	 */
	public function child_menu() {
		$self  = $this;
		$menus = $this->get_admin_menu();

		foreach ( $menus as $menu ) {
			if ( $menu['show_on_menu'] ) {
				if ( $menu['action'] ) {
					add_submenu_page(
						'epic', $menu['title'], $menu['menu'], 'edit_theme_options', $menu['slug'], function () use ( $self, $menu ) {
							$self->render_header();
							call_user_func( $menu['action'] );
						}
					);
				} else {
					add_submenu_page(
						'epic', $menu['title'], $menu['menu'], 'edit_theme_options', $menu['slug']
					);
				}
			}
		}
	}

	/**
	 * Admin Menu
	 *
	 * @return array
	 */
	public function get_admin_menu() {
		$menu[] = array(
			'title'        => esc_html__( 'Dashboard', 'epic' ),
			'menu'         => esc_html__( 'Dashboard', 'epic' ),
			'slug'         => 'epic',
			'action'       => array( &$this, 'landing' ),
			'priority'     => 51,
			'show_on_menu' => true,
		);

		if ( apply_filters( 'epic_dashboard_import_enable', false ) ) {
			$menu[] = array(
				'title'        => esc_html__( 'Import Demo & Style', 'epic' ),
				'menu'         => esc_html__( 'Import Demo & Style', 'epic' ),
				'slug'         => 'epic_import',
				'action'       => array( $this, 'import' ),
				'priority'     => 52,
				'show_on_menu' => true,
			);
		}

		if ( apply_filters( 'epic_dashboard_plugin_enable', false ) ) {
			$menu[] = array(
				'title'        => esc_html__( 'Manage Plugin', 'epic' ),
				'menu'         => esc_html__( 'Manage Plugin', 'epic' ),
				'slug'         => 'epic_plugin',
				'action'       => array( $this, 'plugin' ),
				'priority'     => 52,
				'show_on_menu' => true,
			);
		}

		$menu[] = array(
			'title'        => esc_html__( 'Setting', 'epic' ),
			'menu'         => esc_html__( 'Setting', 'epic' ),
			'slug'         => 'customize.php',
			'action'       => false,
			'priority'     => 55,
			'show_on_menu' => true,
		);

		$menu[] = array(
			'title'        => esc_html__( 'System Status', 'epic' ),
			'menu'         => esc_html__( 'System Status', 'epic' ),
			'slug'         => 'epic_system',
			'action'       => array( &$this, 'system_status' ),
			'priority'     => 57,
			'show_on_menu' => true,
		);

		return apply_filters( 'epic_admin_menu', $menu );
	}

	/**
	 * Render Header
	 */
	public function render_header() {
		settings_errors();
		?>
		<div class="wrap">
			<h2 class="nav-tab-wrapper epic-admin-tab">
				<?php
				$allmenu = apply_filters( 'epic_get_admin_menu', '' );
				foreach ( $allmenu as $menu ) {
					$tabactive = isset( $_GET['page'] ) && ( $_GET['page'] === $menu['slug'] ) ? 'nav-tab-active' : '';
					$pageurl   = menu_page_url( $menu['slug'], false );
					if ( 'customize.php' === $menu['slug'] ) {
						$pageurl = admin_url() . 'customize.php';
					}
					?>
					<a href="<?php echo esc_url( $pageurl ); ?>" class="nav-tab <?php echo esc_attr( $tabactive ); ?>"><?php echo esc_html( $menu['title'] ); ?></a>
					<?php
				}
				?>
			</h2>
		</div>
		<?php
	}

	/**
	 * Theme license form
	 */
	public function theme_license() {
		if ( $this->theme->get_id() ) {
			if ( $this->theme->is_license_valid() ) {
				?>
				<div class="epic-registration-wrap epic-panel">
					<div class="epic-validate">
						<i class="fa fa-check-circle"></i>
						<span class="epic-validate-wrapper">
							<strong><?php echo esc_html( $this->theme->get_name() ); ?></strong>
							<?php esc_html_e( 'License is Validated', 'epic' ); ?>
						</span>
					</div>
				</div>
				<?php
			} else {
				?>
				<div class="epic-registration-wrap epic-panel">
					<form method="POST" action="<?php menu_page_url( 'epic' ); ?>">
						<?php wp_nonce_field( 'epic', 'nonce' ); ?>
						<input type="hidden" name="action" value="validate-license">
						<input type="hidden" name="product-id" value="<?php echo esc_html( $this->theme->get_id() ); ?>">
						<label for="envato_token">
							<?php esc_html_e( 'Product License Registration for', 'epic' ); ?>
							<strong><?php echo esc_html( $this->theme->get_name() ); ?></strong>
						</label>
						<div class="input-token">
							<input name="envato_token" class="large-text" autocomplete="off" type="text" placeholder="<?php esc_html_e( 'Enter your Envato Token', 'epic' ); ?>">
							<?php submit_button( esc_html__( 'Submit', 'epic' ) ); ?>
						</div>
					</form>
				</div>
				<?php
			}
		}
	}

	/**
	 * Landing Page
	 */
	public function landing() {
		?>
		<div class="epic-wrap wrap about-wrap">
			<h1>
				<?php echo apply_filters( 'epic_dashboard_welcome_string', __( 'Welcome to <strong>Epic Plugin</strong>', 'epic' ) ); ?>
			</h1>
			<div class="about-text">
				<?php echo apply_filters( 'epic_dashboard_about_string', __( 'Please activate <strong>Epic\'s</strong> plugin license to get official support service and automatic update. Read below for additional information.', 'epic' ) ); ?>
			</div>

			<?php

			$this->theme_license();

			$plugins = $this->plugin->get_plugins();

			if ( is_array( $plugins ) ) {
				foreach ( $plugins as $plugin ) {
					if ( $plugin->is_license_valid() ) {
						?>
						<div class="epic-registration-wrap epic-panel">
							<div class="epic-validate">
								<i class="fa fa-check-circle"></i>
								<span class="epic-validate-wrapper">
									<strong><?php echo esc_html( $plugin->get_name() ); ?></strong>
									<?php esc_html_e( 'License is Validated', 'epic' ); ?>
								</span>
							</div>
						</div>
						<?php
					} else {
						?>
						<div class="epic-registration-wrap epic-panel">
							<form method="POST" action="<?php menu_page_url( 'epic' ); ?>">
								<?php wp_nonce_field( 'epic', 'nonce' ); ?>
								<input type="hidden" name="action" value="validate-license">
								<input type="hidden" name="product-id" value="<?php echo esc_html( $plugin->get_id() ); ?>">
								<label for="envato_token">
									<?php esc_html_e( 'Product License Registration for', 'epic' ); ?>
									<strong><?php echo esc_html( $plugin->get_name() ); ?></strong>
								</label>
								<div class="input-token">
									<input name="envato_token" class="large-text" autocomplete="off" type="text" placeholder="<?php esc_html_e( 'Enter your Envato Token', 'epic' ); ?>">
									<?php submit_button( esc_html__( 'Submit', 'epic' ) ); ?>
								</div>
							</form>
						</div>
						<?php
					}
				}
			}
			?>

			<div class="epic-howto">
				<h3><?php esc_html_e( 'Instructions for Generating Envato Token', 'epic' ); ?></h3>
				<ol>
					<li>
						<?php
						printf(
							wp_kses(
								/* translators: 1: Generate Token URL */
								__( 'Click on <a href="%s" title="Generate token">Generate Token</a>. You must be logged into the same Themeforest or Codecanyon account that purchased the theme or plugin. If you already logged in, look in the top menu bar to ensure it is the right account. If you are not logged in, you will be directed to login then directed back to the Create A Token Page.', 'epic' ), wp_kses_allowed_html()
							),
							'https://build.envato.com/create-token/?purchase:download=t&purchase:list=t'
						);
						?>
					</li>
					<li><?php esc_html_e( 'Enter a name for your token, then check the boxes for View Your Envato Account Username, Download Your Purchased Items, Verify Purchases You\'ve Made and List Purchases You\'ve Made from the permissions needed section. Check the box to agree to the terms and conditions, then click the Create Token button', 'epic' ); ?></li>
					<li><?php esc_html_e( 'A new page will load with a token number in a box. Copy the token number then come back to this registration page and paste it into the field below and click the Submit button.', 'epic' ); ?></li>
					<li><?php esc_html_e( 'You will see a green check mark for success, or a failure message if something went wrong. If it failed, please make sure you followed the steps above correctly. You can also view our documentation post for various fallback methods.', 'epic' ); ?></li>
				</ol>
			</div>
		</div>
		<?php
	}

	/**
	 * Import handler
	 */
	public function import() {
		?>
		<div class="epic-wrap wrap about-wrap">
			<h1>
				<?php esc_html_e( 'Import Demo & Style', 'epic' ); ?>
			</h1>
			<div class="about-text">
				<?php
					if ( $this->theme->is_license_valid() ) {
						echo wp_kses( sprintf( __('The imported demo will show you about the website structure, theme setting, content structure, design template and etc. In this case, you will be more familiar working with <strong>' . $this->theme->get_name() . '</strong>. The imported demo is also fully customizable. Feel free to play around with your own design. Read <a target="_blank" href="%s">here</a> for more information.', 'epic'), 'http://support.jegtheme.com' ), wp_kses_allowed_html() );
					} else {
						echo wp_kses( __( 'Please activate <strong>' . $this->theme->get_name() . '</strong> license to get official support service and automatic update.', 'epic' ), wp_kses_allowed_html() );
					}
				?>
			</div>

			<!-- Import demo list -->
		</div>
		<?php
	}

	/**
	 * Plugin handler
	 */
	public function plugin() {
		?>
		<div class="epic-wrap wrap about-wrap">
			<h1>
				<?php esc_html_e( 'Manage Plugin', 'epic' ); ?>
			</h1>
			<div class="about-text">
				<?php esc_html_e( 'Please only install plugin that you need to make your website lighter and faster.', 'epic' ); ?>
			</div>

			<!-- List of included plugins -->
			<div class="epic-plugin-wrap">
    			<input type="hidden" value="<?php echo wp_create_nonce('epic-dashboard-nonce'); ?>" name="epic-dashboard-nonce"/>
				<?php $this->tgm->render_included_plugin(); ?>
			</div>

			<h3>
				<?php esc_html_e( 'Supported Plugin', 'epic' ); ?>
			</h3>
			<div class="about-text">
				<?php esc_html_e( 'Other than plugin listed above, we also provide compatibility with below plugin. If you have any suggestion what plugin we need to support, please contact us from Support Forum and let us know.', 'epic' ); ?>
			</div>


			<!-- List of supported plugins -->
		</div>
		<?php
	}

	/**
	 * System Status
	 */
	public function system_status() {
		$system = new System_Dashboard();
		$system->system_status();
	}

}