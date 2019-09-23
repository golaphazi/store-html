<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module;

/**
 * Class EPIC VC Integration
 */
Class ModuleVC {
	/**
	 * @var ModuleVC
	 */
	private static $instance;

	/**
	 * @return ModuleVC
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * ModuleVC constructor.
	 */
	private function __construct() {
		$this->setup_hook();
	}

	/**
	 * Setup Hook
	 */
	public function setup_hook() {
		add_action( 'after_setup_theme', array( $this, 'integrate_vc' ) );

		add_action( 'init', array( $this, 'additional_element' ), 98 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_script' ) );

		add_action( 'wp_ajax_epic_find_post', array( $this, 'find_ajax_post' ) );
		add_action( 'wp_ajax_epic_find_author', array( $this, 'find_ajax_author' ) );
		add_action( 'wp_ajax_epic_find_tag', array( $this, 'find_ajax_tag' ) );
		add_action( 'wp_ajax_epic_find_category', array( $this, 'find_ajax_category' ) );
		add_action( 'wp_ajax_epic_find_post_tag', array( $this, 'find_ajax_post_tag' ) );

		add_action( 'vc_google_fonts_get_fonts_filter', array( $this, 'vc_fonts_helper' ) );
	}

	public function find_ajax_author() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'epic_find_author' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$users = new \WP_User_Query( array(
				'search'         => "*{$query}*",
				'search_columns' => array(
					'user_login',
					'user_nicename',
					'user_email',
					'user_url',
				)
			) );

			$users_found = $users->get_results();

			$result = array();

			if ( count( $users_found ) > 0 ) {
				foreach ( $users_found as $user ) {
					$result[] = array(
						'value' => $user->ID,
						'text'  => $user->display_name
					);
				}
			}

			wp_send_json_success( $result );
		}
	}

	public function find_ajax_tag() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'epic_find_tag' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$args = array(
				'taxonomy'   => array( 'post_tag' ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => true,
				'fields'     => 'all',
				'name__like' => urldecode( $query ),
			);

			$terms = get_terms( $args );

			$result = array();

			if ( count( $terms ) > 0 ) {
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}

			wp_send_json_success( $result );
		}
	}

	public function find_ajax_post() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'epic_find_post' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			add_filter( 'posts_where', function ( $where ) use ( $query ) {
				global $wpdb;
				$where .= $wpdb->prepare( "AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like( $query ) . '%' );

				return $where;
			} );

			$query = new \WP_Query(
				array(
					'post_type'      => array( 'post', 'page' ),
					'posts_per_page' => '15',
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);

			$result = array();

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$result[] = array(
						'value' => get_the_ID(),
						'text'  => get_the_title()
					);
				}
			}

			wp_reset_postdata();
			wp_send_json_success( $result );
		}
	}

	public function find_ajax_category() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'epic_find_category' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$args = array(
				'taxonomy'   => array( 'category' ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => true,
				'fields'     => 'all',
				'name__like' => urldecode( $query ),
				'number'     => 50,
			);

			$terms = get_terms( $args );

			$result = array();

			if ( count( $terms ) > 0 ) {
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}

			wp_send_json_success( $result );
		}
	}

	public function find_ajax_post_tag() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'epic_find_post_tag' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$args = array(
				'taxonomy'   => array( 'post_tag' ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => true,
				'fields'     => 'all',
				'name__like' => $query
			);

			$terms = get_terms( $args );

			$result = array();

			if ( count( $terms ) > 0 ) {
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name
					);
				}
			}

			wp_send_json( $result );
		}
	}

	public function admin_script() {
		wp_enqueue_style( 'global-admin', EPIC_URL . '/assets/css/admin/vc-admin.css' );
		wp_enqueue_style( 'selectize', EPIC_URL . '/assets/css/admin/selectize.default.css' );

		wp_enqueue_script( 'jquery-ui-spinner' );
		wp_enqueue_script( 'selectize', EPIC_URL . '/assets/js/vendor/selectize.js' );
	}

	public function integrate_vc() {
		if ( function_exists( 'vc_set_as_theme' ) ) {
			vc_set_as_theme();
		}
	}

	public function additional_element() {
		if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
			$params = array(
				array( 'alert', array( $this, 'vc_alert' ) ),
				array( 'select', array( $this, 'vc_select' ), EPIC_URL . '/assets/js/vc/vc.script.js' ),

				array( 'number', array( $this, 'vc_number' ), EPIC_URL . '/assets/js/vc/vc.script.js' ),
				array( 'checkblock', array( $this, 'vc_checkblock' ), EPIC_URL . '/assets/js/vc/vc.script.js' ),
				array( 'radioimage', array( $this, 'vc_radioimage' ), EPIC_URL . '/assets/js/vc/vc.script.js' ),
				array( 'slider', array( $this, 'vc_slider' ), EPIC_URL . '/assets/js/vc/vc.script.js' ),
				array( 'attach_file', array( $this, 'vc_attach_file' ), EPIC_URL . '/assets/js/vc/vc.script.js' ),
			);

			foreach ( $params as $param ) {
				call_user_func_array( 'vc_add_shortcode_param', $param );
			}
		}
	}

	/**
	 * VC ALERT
	 *
	 * @param $settings
	 * @param $value
	 *
	 * @return string
	 */
	public function vc_alert( $settings, $value ) {
		return
			"<div class=\"alert-wrapper\" data-field=\"{$settings['std']}\">
                <input name='{$settings['param_name']}' class='wpb_vc_param_value {$settings['param_name']} {$settings['type']}_field' type='hidden'/>
                <div class=\"alert-element alert-{$settings['std']}\">
                    <strong>{$settings['heading']}</strong>
                    <div class=\"alert-description\">{$settings['description']}</div>
                </div>
            </div>";
	}

	/**
	 * VC Select, Handle both single & multiple select. Also handle Ajax Loaded Option.
	 *
	 * @param $settings
	 * @param $value
	 *
	 * @return string
	 */
	public function vc_select( $settings, $value ) {
		ob_start();

		if ( isset( $settings['value'] ) ) {
			$options = array();
			foreach ( $settings['value'] as $key => $val ) {
				$options[] = array(
					'value' => $val,
					'text'  => $key,
				);
			}
		} else {
			$options = call_user_func_array( $settings['options'], array( $value ) );
		}

		?>
		<div class="vc-select-wrapper" data-ajax="<?php echo esc_attr( $settings['ajax'] ) ?>"
			 data-multiple="<?php echo esc_attr( $settings['multiple'] ); ?>"
			 data-nonce="<?php echo esc_attr( $settings['nonce'] ); ?>">
			<?php if ( $settings['multiple'] > 1 ) { ?>
				<input class='wpb_vc_param_value wpb-input input-sortable multiselect_field <?php echo esc_html( $settings['param_name'] ); ?> <?php echo esc_html( $settings['type'] ) ?>_field'
					   type="text" name="<?php echo esc_attr( $settings['param_name'] ); ?>"
					   value="<?php echo esc_attr( $value ); ?>"/>
				<script class="data-option" type="text/html">
					<?php echo json_encode( $options ); ?>
				</script>
			<?php } else { ?>
				<select class='wpb_vc_param_value wpb-input input-sortable <?php echo esc_html( $settings['param_name'] ); ?> <?php echo esc_html( $settings['type'] ) ?>_field'
						name="<?php echo esc_attr( $settings['param_name'] ); ?>">
					<?php
					echo "<option value=''></option>";
					foreach ( $options as $option ) {
						$select = ( $option['value'] === $value ) ? 'selected' : '';
						echo "<option value='{$option['value']}' {$select}>{$option['text']}</option>";
					}
					?>
				</select>
			<?php } ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * VC NUMBER
	 *
	 * @param $settings
	 * @param $value
	 *
	 * @return string
	 */
	public function vc_number( $settings, $value ) {
		return
			"<div class='number-input-wrapper'>
                <input name='{$settings['param_name']}'
                    class='wpb_vc_param_value wpb-input {$settings['param_name']} {$settings['type']}_field'
                    type='text'
                    min='{$settings['min']}'
                    max='{$settings['max']}'
                    step='{$settings['step']}'
                    value='{$value}'/>
            </div>";
	}


	/**
	 * Check Block
	 *
	 * @param $setting
	 * @param $value
	 *
	 * @return string
	 */
	public function vc_checkblock( $setting, $value ) {
		$option   = '';
		$valuearr = explode( ',', $value );

		$option .= "<input name='" . $setting['param_name'] . "' class='wpb_vc_param_value wpb-input " . $setting['param_name'] . " " . $setting['type'] . "_field' type='hidden' value='" . $value . "' />";
		foreach ( $setting['value'] as $key => $val ) {
			$checked = in_array( $val, $valuearr ) ? "checked='checked'" : "";
			$option  .= '<label><input ' . $checked . ' class="checkblock" value="' . $val . '" type="checkbox">' . $key . '</label>';
		}

		return
			'<div class="wp-tab-panel vc_checkblock">
                <div>' . $option . '</div>
            </div>';
	}

	/**
	 * VC Radio Image
	 *
	 * @param $settings
	 * @param $value
	 *
	 * @return string
	 */
	public function vc_radioimage( $settings, $value ) {
		$radio_option = '';
		$radio_input  = "<input type='hidden' name='{$settings['param_name']}' value='{$value}' class='wpb_vc_param_value wpb-input{$settings['param_name']}'/>";

		foreach ( $settings['value'] as $key => $val ) {
			$checked      = ( $value === $val ) ? "checked" : "";
			$radio_option .=
				"<label>
                <input {$checked} type='radio' name='{$settings['param_name']}_field' value='{$val}' class='{$settings['type']}_field'/>
                <img src='{$key}' class='wpb_vc_radio_image'/>
            </label>";
		}

		return
			"<div class='radio-image-wrapper'>
                {$radio_input}
                {$radio_option}
            </div>";
	}


	/**
	 * VC Slider
	 *
	 * @param $settings
	 * @param $value
	 *
	 * @return string
	 */
	public function vc_slider( $settings, $value ) {
		return
			"<div class='slider-input-wrapper'>
                <input name='{$settings['param_name']}'
                    class='wpb_vc_param_value wpb-input {$settings['param_name']} {$settings['type']}_field'
                    type='range'
                    min='{$settings['min']}'
                    max='{$settings['max']}'
                    step='{$settings['step']}'
                    value='{$value}'
                    data-reset_value='{$value}'/>
                <div class=\"jeg_range_value\">
                    <span class=\"value\">{$value}</span>
                </div>
                <div class=\"jeg-slider-reset\">
                  <span class=\"dashicons dashicons-image-rotate\"></span>
                </div>
            </div>";
	}


	/**
	 * VC Attach File
	 *
	 * @param $settings
	 * @param $value
	 *
	 * @return string
	 */
	public function vc_attach_file( $settings, $value ) {
		return
			"<div class='input-uploadfile'>
                <input name='" . $settings['param_name'] . "' class='wpb_vc_param_value wpb-input" . $settings['param_name'] . " " . $settings['type'] . "_field' type='text' value='$value' />
                <div class='buttons'>
                    <input type='button' value='" . esc_html__( 'Select File', 'epic-ne' ) . "' class='selectfileimage btn'/>
                </div>
            </div>";
	}


	public function vc_fonts_helper( $fonts_list ) {

		// new font list
		$additional_fonts = array(
			(object) array(
				'font_family'             => 'Poppins',
				'font_types'              => '300 light regular:300:normal,400 regular:400:normal,500 bold regular:500:normal,600 bold regular:600:normal,700 bold regular:700:normal',
				'font_styles'             => 'regular',
				'font_family_description' => esc_html__( 'Select font family', 'helper' ),
				'font_style_description'  => esc_html__( 'Select font styling', 'helper' )
			),
			(object) array(
				'font_family'             => 'Work Sans',
				'font_types'              => '300 Light regular:300:normal,400 Normal Regular:400:normal,500 Medium Regular:500:normal,600 Semi-Bold Regular:600:normal,700 Bold Regular:700:normal',
				'font_styles'             => 'regular',
				'font_family_description' => esc_html__( 'Select font family', 'helper' ),
				'font_style_description'  => esc_html__( 'Select font styling', 'helper' )
			)
		);

		foreach ( $additional_fonts as $newfont => $value ) {
			$fonts_list[] = $value;
		}

		return $fonts_list;
	}
}
