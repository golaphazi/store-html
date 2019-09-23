<?php
/**
 * Tgm Integration
 *
 * @author Jegstudio
 * @license https://opensource.org/licenses/MIT
 * @package epic-dashboard
 */

namespace EPIC\Dashboard;

/**
 * Class Tgm
 *
 * @package EPIC\Dashboard
 */
class Tgm {

	/**
	 * Instance of Tgm
	 *
	 * @var Tgm
	 */
	private static $instance;

	/**
	 * Instance of TGMPA
	 * 
	 * @var TGMPA
	 */
	private $tgm_instance;

	/**
	 * Get Instance
	 *
	 * @return Tgm
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Tgm constructor.
	 */
	private function __construct() {
		if ( is_admin() && apply_filters( 'epic_dashboard_plugin_enable', false ) ) {
			require_once EPIC_DASHBOARD_DIR . '/lib/tgm/class-tgm-plugin-activation.php';

			add_action( 'tgmpa_register', array( $this, 'register_plugins' ) );
        	add_action( 'wp_ajax_epic_ajax_plugin', array( $this, 'ajax_plugin') );

        	if ( ! $this->tgm_instance ) $this->tgm_instance = $GLOBALS['tgmpa'];
		}
	}

	/**
	 * Ajax plugin action
	 */
	public function ajax_plugin() {
		if ( isset( $_POST['nonce'], $_POST['slug'], $_POST['path'], $_POST['doing'] ) && wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'epic-dashboard-nonce' ) ) {

			do_action('tgmpa_register');

			switch ( $_POST['doing'] ) {
                case 'activate':
                    $this->ajax_plugin_activate( $_POST['slug'], $_POST['path'] );
                    break;
                case 'deactivate':
                    $this->ajax_plugin_deactivate( $_POST['slug'], $_POST['path'] );
                    break;
                case 'install':
                case 'update' :
                    $this->ajax_plugin_install( $_POST['slug'], $_POST['path'], $_POST['doing'] );
                    break;
            }
		}
	}

	/**
	 * Get plugin api
	 * 
	 * @param  string $slug Plugin slug
	 * @return array
	 */
	protected function get_plugin_api( $slug ) {
		static $api = array();

		if ( ! isset( $api[ $slug ] ) ) {
			if ( ! function_exists( 'plugins_api' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			}

			$response = plugins_api( 'plugin_information', array( 'slug' => $slug, 'fields' => array( 'sections' => false ) ) );

			$api[ $slug ] = false;

			if ( is_wp_error( $response ) ) {
				wp_die( esc_html__( 'Something went wrong with the plugin API.', 'epic' ) );
			} else {
				$api[ $slug ] = $response;
			}
		}

		return $api[ $slug ];
	}

	/**
	 * Ajax install plugin
	 * 
	 * @param string $slug  Plugin slug
	 * @param string $path  Plugin path
	 * @param string $doing Plugin action
	 */
	protected function ajax_plugin_install( $slug, $path, $doing ) {
		$slug   = $this->tgm_instance->sanitize_key( urldecode( $slug ) );
        $plugin = $this->tgm_instance->plugins[ $slug ];
        $source = $this->tgm_instance->get_download_url( $slug );
        $api    = ( 'repo' === $plugin['source_type'] ) ? $this->get_plugin_api( $slug ) : null;
        $api    = ( false !== $api ) ? $api : null;
        $url    = add_query_arg(
            array(
                'action' => $doing . '-plugin',
                'plugin' => urlencode( $slug ),
            ),
            'update.php'
        );

        if ( !class_exists( 'Plugin_Upgrader', false ) ) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        }

        $skin_args = array(
            'type'   => ( 'bundled' !== $plugin['source_type'] ) ? 'web' : 'upload',
            'title'  => $plugin['name'],
            'url'    => esc_url_raw( $url ),
            'nonce'  => $doing . '-plugin_' . $slug,
            'plugin' => '',
            'api'    => $api,
            'extra'  => array(
	        	'slug' => $slug
	        )
        );

        if ( 'update' === $doing ) {
            $skin_args['plugin'] = $plugin['file_path'];
            $skin = new \Plugin_Upgrader_Skin( $skin_args );
        } else {
            $skin = new \Plugin_Installer_Skin( $skin_args );
        }

        $upgrader = new \Plugin_Upgrader( $skin );

        add_filter( 'upgrader_source_selection', array( $this->tgm_instance, 'maybe_adjust_source_dir' ), 1, 3 );

        set_time_limit( MINUTE_IN_SECONDS * 60 );

        if ( 'update' === $doing ) {
            $to_inject                    = array( $slug => $plugin );
            $to_inject[ $slug ]['source'] = $source;
            $this->tgm_instance->inject_update_info( $to_inject );

            $upgrader->upgrade( $plugin['file_path'] );
        } else {
            $upgrader->install( $source );
        }

        remove_filter( 'upgrader_source_selection', array( $this->tgm_instance, 'maybe_adjust_source_dir' ), 1 );

        $this->tgm_instance->populate_file_path( $slug );

		$file_path = $this->tgm_instance->plugins[$plugin['slug']]['file_path'];
		$author    = $this->tgm_instance->get_plugins()[$file_path]['Author'];
		$version   = $this->tgm_instance->get_plugins()[$file_path]['Version'];

		wp_send_json([
			'doing'  => 'activate',
			'status' => 'success',
			'info'   => $this->render_plugin_info( $plugin, $author, $version, null ),
			'path'   => $file_path,
			'notice' => ( 'install' === $doing ) ? esc_html__( 'The plugin is successfully installed.', 'epic' ) : esc_html__( 'The plugin is successfully updated.', 'epic' )
		]);
	}

	/**
	 * Ajax activate plugin
	 * 
	 * @param  string $slug Plugin slug
	 * @param  string $path Plugin path
	 */
	protected function ajax_plugin_activate( $slug, $path ) {
		if ( activate_plugins( $path, null, false, false ) ) {
			wp_send_json([
				'doing'  => 'deactivate',
				'status' => 'success',
				'notice' => esc_html__( 'The plugin is successfully activated.', 'epic' )
			]);
		} else {
			wp_send_json(array(
                'doing'  => 'activate',
				'status' => 'warning',
                'notice' => sprintf( __( 'Something went wrong with the plugin API. Please try to install &amp; activate the plugin via TGM Plugin Activation <a href="%s" target="_blank">here</a> or contact our support team <a href="%s" target="_blank">here</a>.', 'epic' ), "themes.php?page=tgmpa-install-plugins", "http://support.jegtheme.com/"),
            ));
		}
	}

	/**
	 * Ajax deactivate plugin
	 * 
	 * @param  string $slug Plugin slug
	 * @param  string $path Plugin path
	 */
	protected function ajax_plugin_deactivate( $slug, $path ) {
		deactivate_plugins( $path );

		if ( ! $this->tgm_instance->is_plugin_active( $slug ) ) {
			wp_send_json([
				'doing'  => 'activate',
				'status' => 'success',
				'notice' => esc_html__( 'The plugin is successfully deactivated.', 'epic' )
			]);
		} else {
			wp_send_json(array(
				'doing'  => 'deactivate',
                'status' => 'warning',
                'notice' => sprintf( __( 'Something went wrong with the plugin API. Please try to install &amp; activate the plugin via TGM Plugin Activation <a href="%s" target="_blank">here</a> or contact our support team <a href="%s" target="_blank">here</a>.', 'epic' ), "themes.php?page=tgmpa-install-plugins", "http://support.jegtheme.com/"),
            ));
		}
	}

	/**
	 * Register plugin list
	 */
	public function tgm_plugins() {
		$plugin  = array();
		$plugins = apply_filters( 'epic_dashboard_tgm_plugins', array() );

		foreach ( $plugins as $key => $group ) {
	        $plugin = array_merge( $plugin, $group['items'] );
	    }

		return $plugin;
	}

	/**
	 * Register plugins
	 */
	public function register_plugins() {
		$config = apply_filters( 'epic_dashboard_tgm_config', array() );

		tgmpa( $this->tgm_plugins(), $config );
	}

	/**
	 * Render plugin info
	 * 
	 * @param  array  $plugin         Plugin data
	 * @param  string $author         Plugin author
	 * @param  string $version        Plugin version
	 * @param  string $update_version Update version of plugin
	 * 
	 * @return html
	 */
	public function render_plugin_info( $plugin, $author, $version, $update_version ) {
		if ( $author ) {
			$author = '<p>' . esc_html__( 'by', 'epic' ) . ' <strong>' . esc_html( $author ) . '</strong></p>';
		}

		if ( $version || $update_version ) {
			if ( $update_version ) {
				$update_version = '<li><p><strong>' . esc_html__( 'Required Version :', 'epic' ) . ' ' . esc_html( $update_version ) . '</strong></p></li>';
			}

			$version = 
				'<ul class="version">
					<li><p><strong>' . esc_html__( 'Installed Version :', 'epic' ) . ' ' . esc_html( $version ) . '</strong></p></li>
					' . $update_version . '
				</ul>';
		}

		$output = 
			'<h3>' . esc_html( $plugin['name'] ) . '</h3>'
			. $author . 
			'<p>' . trim( $plugin['description'] ) . '</p>'
			. $version;

		return $output;
	}

	/**
	 * Render included plugin list
	 */
	public function render_included_plugin() {
		$plugins_list = apply_filters( 'epic_dashboard_tgm_plugins', array() );

		foreach ( $plugins_list as $key => $group ) {
			?>
			<div class="epic-plugin-group">
				<div class="epic-plugin-heading">
					<span class="flag <?php esc_html_e( $group['type'] ) ?>"><?php esc_html_e( $group['type'] ) ?></span>
					<span class="title"><?php esc_html_e( $group['title'] ) ?></span>
					<span class="flag update"><?php esc_html_e( 'New Update Available', 'epic' ); ?></span>
					<span class="toggle"><i class="fa fa-caret-down"></i></span>
				</div>
				<div class="epic-plugin-body">
					<?php 
						foreach ( $group['items'] as $plugin ) : 

						$status = $author = $version = $update_version = '';

						if ( $this->tgm_instance->is_plugin_installed( $plugin['slug'] ) ) {
							if ( $this->tgm_instance->is_plugin_active( $plugin['slug'] ) ) {
								if ( $this->tgm_instance->does_plugin_require_update( $plugin['slug'] ) ) {
									$update_version = $this->tgm_instance->plugins[$plugin['slug']]['version'];
									$status         = 'update';
								} else {
									$status = 'deactivate';
								}
							} else {
								$status = 'activate';
							}
							$file_path = $this->tgm_instance->plugins[$plugin['slug']]['file_path'];
							$author    = $this->tgm_instance->get_plugins()[$file_path]['Author'];
							$version   = $this->tgm_instance->get_plugins()[$file_path]['Version'];
						} else {
							$status = 'install';
						}
					?>
						<div class="epic-plugin-item" data-status="<?php echo esc_attr( $status ) ?>" data-slug="<?php echo esc_attr( $plugin['slug'] ) ?>" data-path="<?php echo esc_attr( $this->tgm_instance->plugins[$plugin['slug']]['file_path'] ); ?>">
							<div class="image">
								<img src="<?php echo esc_attr( $plugin['image'] ); ?>">
							</div>
							<div class="info">
								<?php echo jeg_sanitize_output( $this->render_plugin_info( $plugin, $author, $version, $update_version ) ); ?>
							</div>
							<div class="action">
								<a class="button button-primary button-large install" href=""><?php esc_html_e( 'Install', 'epic' ); ?></a>
								<a class="button button-primary button-large activate" href=""><?php esc_html_e( 'Activate', 'epic' ); ?></a>
								<a class="button button-large deactivate" href=""><?php esc_html_e( 'Deactivate', 'epic' ); ?></a>
								<a class="button button-primary button-large update" href=""><?php esc_html_e( 'Update', 'epic' ); ?></a>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
			<?php
		}
	}
}
