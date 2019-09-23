<?php
/**
 * System Class
 *
 * @author Jegstudio
 * @license https://opensource.org/licenses/MIT
 * @package epic-dashboard
 */

namespace EPIC\Dashboard;

/**
 * Class System
 *
 * @package EPIC\Dashboard
 */
class System_Dashboard {

	/**
	 * Let to Num
	 *
	 * @param string $size Size of number.
	 *
	 * @return bool|int|string
	 */
	public function let_to_num( $size ) {
		$l   = substr( $size, - 1 );
		$ret = substr( $size, 0, - 1 );
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}

		return $ret;
	}

	public function status_flag( $code ) {
		$string = '';
		switch ( $code ) {
			case 'green':
				$string = esc_html__( 'Everything is Good', 'epic' );
				break;
			case 'yellow':
				$string = esc_html__( 'This setting may not affect your website entirely, but it will cause some of the features not working as expected.', 'epic' );
				break;
			case 'red':
				$string = esc_html__( 'You will need to fix this setting to make plugin work as expected.', 'epic' );
				break;
		}

		return "<div class='tooltip flag-item flag-{$code}' title='{$string}'></div>";
	}

	public function status_render( $options, $html ) {
		if ( $html ) {
			foreach ( $options as $option ) {
				$option['self'] = $this;
				if ( 'status' === $option['type'] ) {
					$this->system_status_help( $option );
				} elseif ( 'flag' === $option['type'] ) {
					$this->system_status_flag_render( $option );
				}
			}
		} else {
			foreach ( $options as $option ) {
				$option['self'] = $this;
				$this->system_status_text( $option );
			}
		}
	}

	public function system_status_text( $option ) {
		echo esc_html( $option['title'] ) . ' : ' . esc_html( $option['content'] ) . "\n";
	}

	public function system_status_flag_render( $option ) {
		?>
		<tr>
			<td class="status-title">
				<?php echo esc_html( $option['title'] ); ?>
			</td>
			<td class="status-flag flag">
				<?php
					echo wp_kses( $this->system_status_flag( $option['flag'] ), array(
						'div' => array(
							'title' => true,
							'class' => true,
						),
					) );
				?>
			</td>
			<td>
				<?php
				echo wp_kses( $option['content'], array(
					'strong' => array(),
					'a'      => array(
						'href' => true,
					),
					'mark'   => array(
						'class' => true,
					),
				) );
				if ( isset( $option['small'] ) ) {
					?>
					<em><?php echo esc_html( $option['small'] ); ?></em>
					<?php
				}
				?>
			</td>
		</tr>
		<?php
	}

	public function system_status_help( $option ) {
		?>
		<tr>
			<td class="status-title"><?php echo esc_html( $option['title'] ); ?></td>
			<td class="status-flag help">
				<?php if ( isset( $option['tooltip'] ) && ! empty( $option['tooltip'] ) ) : ?>
					<i class="tooltip fa fa-question-circle" title="<?php echo esc_html( $option['tooltip'] ); ?>"></i>
				<?php endif; ?>
			</td>
			<td>
				<?php
				echo wp_kses( $option['content'], array(
					'strong' => array(),
					'a'      => array(
						'href' => true,
					),
					'mark'   => array(
						'class' => true,
					),
				) );
				?>
			</td>
		</tr>
		<?php
	}

	public function active_plugin( $html = true ) {
		$active_plugin = array();

		$plugins = array_merge(
			array_flip( (array) get_option( 'active_plugins', array() ) ),
			(array) get_site_option( 'active_sitewide_plugins', array() )
		);

		$plugins = array_intersect_key( get_plugins(), $plugins );
		if ( $plugins ) {
			foreach ( $plugins as $plugin ) {
				$item                = array();
				$item['uri']         = isset( $plugin['PluginURI'] ) ? esc_url( $plugin['PluginURI'] ) : '#';
				$item['name']        = isset( $plugin['Name'] ) ? $plugin['Name'] : esc_html__( 'unknown', 'epic' );
				$item['author_uri']  = isset( $plugin['AuthorURI'] ) ? esc_url( $plugin['AuthorURI'] ) : '#';
				$item['author_name'] = isset( $plugin['Author'] ) ? $plugin['Author'] : esc_html__( 'unknown', 'epic' );
				$item['version']     = isset( $plugin['Version'] ) ? $plugin['Version'] : esc_html__( 'unknown', 'epic' );

				if ( $html ) {
					$content = esc_html__( 'by', 'epic' ) . ' ' . "<a href='{$item['author_uri']}'>" . $item['author_name'] . "</a>" . ' - ' . $item['version'];
				} else {
					$content = esc_html__( 'by', 'epic' ) . ' ' . $item['author_name'] . ' - ' . $item['version'];
				}

				array_push( $active_plugin, array(
					'type'    => 'status',
					'title'   => $item['name'],
					'content' => $content,
				) );
			}
		}

		$this->status_render( $active_plugin, $html );
	}

	public function server_enviroment( $html = true ) {
		$server = array();

		array_push( $server, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Server Info', 'epic' ),
			'tooltip' => esc_html__( 'Information about the web server that is currently hosting your site', 'epic' ),
			'content' => $_SERVER['SERVER_SOFTWARE'],
		) );

		if ( function_exists( 'phpversion' ) ) {
			$php_version = phpversion();

			if ( version_compare( $php_version, '5.4', '<' ) ) {

				$content = '<mark class="error">' . sprintf( esc_html__( '%s - We recommend a minimum PHP version of 5.4. See: %s', 'epic' ), esc_html( $php_version ), esc_html( $php_version ) ) . '</mark>';

				if ( ! $html ) {
					$content = sprintf( esc_html__( '%s - We recommend a minimum PHP version of 5.4. See: %s', 'epic' ), esc_html( $php_version ) );
				}

				array_push( $server, array(
					'type'    => 'flag',
					'title'   => esc_html__( 'PHP Version', 'epic' ),
					'flag'    => 'red',
					'content' => $content,
				) );
			} else {
				$content = '<mark class="yes">' . esc_html( $php_version ) . '</mark>';

				if ( ! $html ) {
					$content = esc_html( $php_version );
				}

				array_push( $server, array(
					'type'    => 'flag',
					'title'   => esc_html__( 'PHP Version', 'epic' ),
					'flag'    => 'green',
					'content' => $content,
				) );
			}
		} else {
			array_push( $server, array(
				'type'    => 'flag',
				'title'   => esc_html__( 'PHP Version', 'epic' ),
				'flag'    => 'red',
				'content' => esc_html__( "Couldn't determine PHP version because phpversion() doesn't exist", 'epic' ),
			) );
		}

		if ( function_exists( 'ini_get' ) ) {

			array_push( $server, array(
				'type'    => 'status',
				'title'   => esc_html__( 'PHP Post Max Size', 'epic' ),
				'tooltip' => esc_html__( 'The largest filesize that can be contained in one post', 'epic' ),
				'content' => size_format( $this->let_to_num( ini_get( 'post_max_size' ) ) ),
			) );

			$maxtime      = ini_get( 'max_execution_time' );
			$maxtimelimit = 3000;

			if ( $maxtime >= $maxtimelimit ) {
				array_push( $server, array(
					'type'    => 'flag',
					'title'   => esc_html__( 'PHP Time Limit', 'epic' ),
					'flag'    => 'green',
					'content' => $maxtime,
				) );
			} else {
				array_push( $server, array(
					'type'    => 'flag',
					'title'   => esc_html__( 'PHP Time Limit', 'epic' ),
					'flag'    => 'yellow',
					'content' => $maxtime,
					'small'   => sprintf( esc_html__( 'max_execution_time should be bigger than %s, otherwise import process may not finished as expected', 'epic' ), $maxtimelimit ),
				) );
			}

			$maxinput      = ini_get( 'max_input_vars' );
			$maxinputlimit = 2000;

			if ( $maxinput >= $maxinputlimit ) {
				array_push( $server, array(
					'type'    => 'flag',
					'title'   => esc_html__( 'PHP Max Input Vars', 'epic' ),
					'flag'    => 'green',
					'content' => $maxinput,
				) );
			} else {
				array_push( $server, array(
					'type'    => 'flag',
					'title'   => esc_html__( 'PHP Max Input Vars', 'epic' ),
					'flag'    => 'yellow',
					'content' => $maxinput,
					'small'   => sprintf( esc_html__( 'max_input_vars should be bigger than %s, otherwise you may not able to save setting on option panel', 'epic' ), $maxinputlimit ),
				) );
			}

			array_push( $server, array(
				'type'    => 'status',
				'title'   => esc_html__( 'SUHOSIN Installed', 'epic' ),
				'tooltip' => esc_html__( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'epic' ),
				'content' => extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;',
			) );
		}

		// WP Remote Get
		$response = @wp_remote_get( 'http://api.wordpress.org/plugins/update-check/1.1/' );

		if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
			$wp_remote_get       = true;
			$wp_remote_get_error = '';
			$wp_remote_get_flag  = 'green';
		} else {
			$wp_remote_get       = false;
			$wp_remote_get_error = $response['response']['code'] . ' - ' . $response['response']['message'];
			$wp_remote_get_flag  = 'yellow';
		}

		array_push( $server, array(
			'type'    => 'status',
			'title'   => esc_html__( 'WP Remote Get', 'epic' ),
			'flag'    => $wp_remote_get_flag,
			'tooltip' => esc_html__( 'Some features of EPIC need WP remote to be installed properly. Including demo importer and validated license.', 'epic' ),
			'content' => $wp_remote_get ? '&#10004;' : $wp_remote_get_error,
		) );

		$gd_installed      = extension_loaded( 'gd' ) && function_exists( 'gd_info' );
		$imagick_installed = extension_loaded( 'imagick' );

		if ( $gd_installed || $imagick_installed ) {
			array_push( $server, array(
				'type'    => 'flag',
				'title'   => esc_html__( 'PHP Image library installed ', 'epic' ),
				'flag'    => 'green',
				'content' => '&#10004;',
			) );
		} else {
			array_push( $server, array(
				'type'    => 'flag',
				'title'   => esc_html__( 'PHP Image library installed ', 'epic' ),
				'flag'    => 'yellow',
				'content' => esc_html__( 'Please install PHP image library ( GD or Image Magic ) ', 'epic' ),
			) );
		}

		$curl_installed = extension_loaded( 'curl' ) && function_exists( 'curl_version' );

		if ( $curl_installed ) {
			array_push( $server, array(
				'type'    => 'flag',
				'title'   => esc_html__( 'CURL Installed ', 'epic' ),
				'flag'    => 'green',
				'content' => '&#10004;',
			) );
		} else {
			array_push( $server, array(
				'type'    => 'flag',
				'title'   => esc_html__( 'CURL Installed ', 'epic' ),
				'flag'    => 'yellow',
				'content' => esc_html__( 'Please install CURL PHP library', 'epic' ),
			) );
		}

		$this->status_render( $server, $html );
	}

	/**
	 * Print status flag
	 *
	 * @param $code
	 *
	 * @return string
	 */
	public function system_status_flag( $code ) {
		$string = '';
		switch ( $code ) {
			case 'green':
				$string = esc_html__( 'Everything is Good', 'epic' );
				break;
			case 'yellow':
				$string = esc_html__( 'This setting may not affect your website entirely, but it will cause some of the features not working as expected.', 'epic' );
				break;
			case 'red':
				$string = esc_html__( 'You will need to fix this setting to make themes & plugin work as expected.', 'epic' );
				break;
		}

		return "<div class='tooltip flag-item flag-{$code}' title='{$string}'></div>";
	}

	public function wordpress_enviroment( $html = true ) {
		$wpenviroment = array();

		array_push( $wpenviroment, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Home URL', 'epic' ),
			'tooltip' => esc_html__( 'The URL of your site\'s homepage', 'epic' ),
			'content' => home_url(),
		) );

		array_push( $wpenviroment, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Site URL', 'epic' ),
			'tooltip' => esc_html__( 'The root URL of your site', 'epic' ),
			'content' => site_url(),
		) );

		array_push( $wpenviroment, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Login URL', 'epic' ),
			'tooltip' => esc_html__( 'your website login url', 'epic' ),
			'content' => wp_login_url(),
		) );

		array_push( $wpenviroment, array(
			'type'    => 'status',
			'title'   => esc_html__( 'WP Version', 'epic' ),
			'tooltip' => esc_html__( 'The version of WordPress installed on your site', 'epic' ),
			'content' => get_bloginfo( 'version', 'display' ),
		) );

		array_push( $wpenviroment, array(
			'type'    => 'status',
			'title'   => esc_html__( 'WP Multisite', 'epic' ),
			'tooltip' => esc_html__( 'Whether or not you have WordPress Multisite enabled', 'epic' ),
			'content' => is_multisite() ? '&#10004;' : '&ndash;',
		) );

		if ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) {
			array_push( $wpenviroment, array(
				'type'    => 'flag',
				'title'   => esc_html__( 'WP Debug Mode', 'epic' ),
				'flag'    => 'yellow',
				'content' => esc_html__( 'Enabled', 'epic' ),
				'small'   => esc_html__( 'Only enable WP DEBUG if you are on development server, once on production server, you will need to disable WP Debug', 'epic' ),
			) );
		} else {
			array_push( $wpenviroment, array(
				'type'    => 'flag',
				'title'   => esc_html__( 'WP Debug Mode', 'epic' ),
				'flag'    => 'green',
				'content' => esc_html__( 'Disabled', 'epic' ),
				'small'   => esc_html__( 'Only enable WP DEBUG if you are on development server, once on production server, you will need to disable WP Debug', 'epic' ),
			) );
		}


		$memory         = $this->let_to_num( WP_MEMORY_LIMIT );
		$minmemorylimit = 134217728;

		if ( function_exists( 'memory_get_usage' ) ) {
			$system_memory = $this->let_to_num( @ini_get( 'memory_limit' ) );

			if ( $system_memory >= $minmemorylimit ) {
				$content = '<mark class="yes">' . size_format( $system_memory ) . '</mark>';
				if ( ! $html ) {
					$content = size_format( $system_memory );
				}
				$color = 'green';
			} else {
				$content = '<mark class="error">' . sprintf( esc_html__( '%s - We recommend setting memory to at least 128MB. See: %s', 'epic' ), size_format( $system_memory ), '<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'epic' ) . '</a>' ) . '</mark>';
				if ( ! $html ) {
					$content = sprintf( esc_html__( '%s - We recommend setting memory to at least 128MB.', 'epic' ), size_format( $system_memory ) );
				}
				$color = 'yellow';
			}

			array_push( $wpenviroment, array(
				'type'    => 'flag',
				'title'   => esc_html__( 'PHP Memory Limit', 'epic' ),
				'flag'    => $color,
				'content' => $content,
			) );
		}


		if ( $memory >= $minmemorylimit ) {
			$content = '<mark class="yes">' . size_format( $memory ) . '</mark>';
			if ( ! $html ) {
				$content = size_format( $memory );
			}
			$color = 'green';
		} else {
			$content = '<mark class="error">' . sprintf( esc_html__( '%s - We recommend setting memory to at least 128MB. See: %s', 'epic' ), size_format( $memory ), '<a href="http://support.jegtheme.com/documentation/system-status/#memory-limit" target="_blank">' . esc_html__( 'Increasing the WordPress Memory Limit', 'epic' ) . '</a>' ) . '</mark>';
			if ( ! $html ) {
				$content = sprintf( esc_html__( '%s - We recommend setting memory to at least 128MB.', 'epic' ), size_format( $memory ) );
			}
			$color = 'yellow';
		}

		array_push( $wpenviroment, array(
			'type'    => 'flag',
			'title'   => esc_html__( 'WP Memory Limit', 'epic' ),
			'flag'    => $color,
			'content' => $content,
		) );


		array_push( $wpenviroment, array(
			'type'    => 'status',
			'title'   => esc_html__( 'WP Language', 'epic' ),
			'flag'    => 'green',
			'content' => get_locale(),
			'tooltip' => esc_html__( 'Default Language of your WordPress Installation', 'epic' ),
		) );

		$wp_upload_dir = wp_upload_dir();

		array_push( $wpenviroment, array(
			'type'    => 'status',
			'title'   => esc_html__( 'WP Upload Directory', 'epic' ),
			'flag'    => 'green',
			'content' => wp_is_writable( $wp_upload_dir['basedir'] ) ? '&#10004;' : '&ndash;',
			'tooltip' => esc_html__( 'Determine if upload directory is writable', 'epic' ),
		) );

		array_push( $wpenviroment, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Number of Category', 'epic' ),
			'flag'    => 'green',
			'content' => wp_count_terms( 'category' ),
			'tooltip' => esc_html__( 'The current number of post category on your site', 'epic' ),
		) );

		array_push( $wpenviroment, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Number of Tag', 'epic' ),
			'flag'    => 'green',
			'content' => wp_count_terms( 'post_tag' ),
			'tooltip' => esc_html__( 'The current number of post tag on your site', 'epic' ),
		) );

		$this->status_render( $wpenviroment, $html );
	}

	/**
	 * @param bool $html
	 * @param Plugin $plugin plugin instance
	 */
	public function plugin_info( $html = true, $plugin ) {
		$plugininfo     = array();

		array_push( $plugininfo, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Plugin Name', 'epic' ),
			'tooltip' => esc_html__( 'Plugin currently installed & activated', 'epic' ),
			'content' => $plugin->get_name(),
		) );

		array_push( $plugininfo, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Plugin Version', 'epic' ),
			'tooltip' => esc_html__( 'Current plugin version', 'epic' ),
			'content' => $plugin->get_version(),
		) );

		array_push( $plugininfo, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Plugin License', 'epic' ),
			'tooltip' => esc_html__( 'Plugin license registration', 'epic' ),
			'content' => $plugin->is_license_valid() ? '&#10004;' : '&ndash;',
		) );

		array_push( $plugininfo, array(
			'type'    => 'status',
			'title'   => esc_html__( 'License Code', 'epic' ),
			'tooltip' => esc_html__( 'Plugin License Code', 'epic' ),
			'content' => $plugin->get_token(),
		) );

		$this->status_render( $plugininfo, $html );
	}

	public function theme_info( $html = true ) {
		$themeinfo = array();
		$theme     = wp_get_theme();
		$themedata = Theme::get_instance();

		array_push( $themeinfo, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Theme Name', 'epic' ),
			'tooltip' => esc_html__( 'Theme currently installed & activated', 'epic' ),
			'content' => $theme->get( 'Name' ),
		) );

		array_push( $themeinfo, array(
			'type'    => 'status',
			'title'   => esc_html__( 'Theme Version', 'epic' ),
			'tooltip' => esc_html__( 'Current theme version', 'epic' ),
			'content' => $theme->get( 'Version' ),
		) );

		if ( is_child_theme() ) {
	        array_push( $themeinfo, array(
		        'type'    => 'status',
		        'title'   => esc_html__( 'Themes Parent', 'epic' ),
		        'tooltip' => esc_html__( 'Current parent theme version', 'epic' ),
		        'content' => wp_get_theme( $themedata->get_slug() )->get( 'Version' )
	        ) );
        }

        if ( $themedata->get_id() ) {
        	array_push( $themeinfo, array(
	            'type'    => 'status',
	            'title'   => esc_html__( 'Themes License', 'epic' ),
	            'tooltip' => esc_html__( 'Theme license registration', 'epic' ),
	            'content' => $themedata->is_license_valid() ? '&#10004;' : '&ndash;'
	        ) );
        }

        if ( $themedata->get_id() ) {
        	array_push( $themeinfo, array(
	            'type'    => 'status',
	            'title'   => esc_html__( 'License Code', 'epic' ),
	            'tooltip' => esc_html__( 'Theme License Code', 'epic' ),
	            'content' => $themedata->get_token()
	        ) );
        }

		$this->status_render( $themeinfo, $html );
	}

	public function system_status() {
		?>
		<div class="epic-wrap wrap">

			<table class="epic_admin_table widefat" cellspacing="0" id="status">
				<thead>
				<tr>
					<th><?php echo wp_kses( __( 'System Report <em> - Please copy and paste this information when asking for support</em>', 'epic' ), wp_kses_allowed_html() ); ?></th>
				</tr>
				</thead>
				<tbody>
				<td>
					<div class="debug-report">
                <textarea readonly="readonly">
### <?php esc_html_e( 'THEME INFO', 'epic' ); ?> ###

<?php $this->theme_info( false ); ?>


<?php
$plugins = Plugins::get_instance()->get_plugins();
foreach ( $plugins as $plugin ) {
?>
### <?php esc_html_e( 'PLUGIN INFO', 'epic' ); ?> ###

<?php
$this->plugin_info( false, $plugin );
echo "\n\n";
}
?>
### <?php esc_html_e( 'WordPress Enviroment', 'epic' ); ?> ###

<?php $this->wordpress_enviroment( false ); ?>


### <?php esc_html_e( 'Server Enviroment', 'epic' ); ?> ###

<?php $this->server_enviroment( false ); ?>


### <?php esc_html_e( 'Active Plugins', 'epic' ); ?> ###

<?php $this->active_plugin( false ); ?>

### <?php esc_html_e( 'End', 'epic' ); ?> ###
                </textarea>
						<div class='epic-action-notice success'>
							<span><?php esc_html_e( 'System Report Copied', 'epic' ); ?></span>
							<i class='fa fa-times'></i>
						</div>
					</div>
				</td>
				</tbody>
			</table>

			<table class="epic_admin_table widefat" cellspacing="0" id="status">
				<thead>
				<tr>
					<th colspan="3"><?php esc_html_e( 'Theme Info', 'epic' ); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php $this->theme_info(); ?>
				</tbody>
			</table>

			<?php
			$plugins = Plugins::get_instance()->get_plugins();
			foreach ( $plugins as $plugin ) {
				?>
				<table class="epic_admin_table widefat" cellspacing="0" id="status">
					<thead>
					<tr>
						<th colspan="3"><?php esc_html_e( 'Plugin Info', 'epic' ); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php $this->plugin_info( true, $plugin ); ?>
					</tbody>
				</table>
				<?php
			}
			?>

			<table class="epic_admin_table widefat" cellspacing="0" id="status">
				<thead>
				<tr>
					<th colspan="3"><?php esc_html_e( 'WordPress Enviroment', 'epic' ); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php $this->wordpress_enviroment(); ?>
				</tbody>
			</table>

			<table class="epic_admin_table widefat" cellspacing="0" id="status">
				<thead>
				<tr>
					<th colspan="3"><?php esc_html_e( 'Server Enviroment', 'epic' ); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php $this->server_enviroment(); ?>
				</tbody>
			</table>

			<table class="epic_admin_table widefat" cellspacing="0" id="status">
				<thead>
				<tr>
					<th colspan="3"><?php esc_html_e( 'Active Plugins', 'epic' ); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php $this->active_plugin(); ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	public function backend_status() {
		?>
<pre>
<?php
$plugins = Plugins::get_instance()->get_plugins();
foreach ( $plugins as $plugin ) {
?>
### PLUGIN INFO ###
<?php
echo "\n";
$this->plugin_info( false, $plugin );
echo "\n";
}
?>

### THEME INFO ###

<?php $this->theme_info(false); ?>


### WordPress Enviroment ###

<?php $this->wordpress_enviroment(false); ?>


### Server Enviroment ###

<?php $this->server_enviroment(false); ?>

### End ###</pre>
<?php
		exit;
	}
}
