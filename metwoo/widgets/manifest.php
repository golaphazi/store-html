<?php
namespace MetWoo\Widgets;
defined( 'ABSPATH' ) || exit;

Class Manifest{

    private static $instance = null;

    public static function get_instance(){
        if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

	public function init() {
		//add_action( 'elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
		//add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

	}

	public function get_input_widgets(){
		return [
			'mf-text',
			'mf-email',
			'mf-number',
			'mf-date',
			'mf-time',
			'mf-dropdown',
			'mf-multi-dropdown',
			'mf-textarea',
			'mf-checkbox',
			'mf-radio',
			'mf-switch',
			'mf-range',
			'mf-url',
			'mf-password',
			'mf-listing-fname',
			'mf-listing-lname',
			'mf-listing-phone',
			'mf-listing-obtain',
			'mf-recaptcha',
			'mf-rating',
			'mf-file-upload',
		];
	}

	public function includes() {

		require_once plugin_dir_path(__FILE__) . 'form.php';
		require_once plugin_dir_path(__FILE__) . 'text/text.php';
		require_once plugin_dir_path(__FILE__) . 'email/email.php';
		require_once plugin_dir_path(__FILE__) . 'number/number.php';
		require_once plugin_dir_path(__FILE__) . 'date/date.php';
		require_once plugin_dir_path(__FILE__) . 'time/time.php';
		require_once plugin_dir_path(__FILE__) . 'dropdown/dropdown.php';
		require_once plugin_dir_path(__FILE__) . 'multi-select/multi-select.php';
		require_once plugin_dir_path(__FILE__) . 'button/button.php';
		require_once plugin_dir_path(__FILE__) . 'textarea/textarea.php';
		require_once plugin_dir_path(__FILE__) . 'checkbox/checkbox.php';
		require_once plugin_dir_path(__FILE__) . 'radio/radio.php';
		require_once plugin_dir_path(__FILE__) . 'switch/switch.php';
		require_once plugin_dir_path(__FILE__) . 'range/range.php';
		require_once plugin_dir_path(__FILE__) . 'url/url.php';
		require_once plugin_dir_path(__FILE__) . 'password/password.php';
		require_once plugin_dir_path(__FILE__) . 'response/response.php';
		require_once plugin_dir_path(__FILE__) . 'listing/listing-fname.php';
		require_once plugin_dir_path(__FILE__) . 'listing/listing-lname.php';
		require_once plugin_dir_path(__FILE__) . 'listing/listing-phone.php';
		require_once plugin_dir_path(__FILE__) . 'listing/listing-obtain.php';
		require_once plugin_dir_path(__FILE__) . 'recaptcha/recaptcha.php';
		require_once plugin_dir_path(__FILE__) . 'rating/rating.php';
		require_once plugin_dir_path(__FILE__) . 'file-upload/file-upload.php';

	}

	public function register_widgets() {

        $this->includes();

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Widget_My_Form() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Button() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Text() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Email() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Number() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Date() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Time() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Dropdown() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Multi_Select() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Textarea() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Checkbox() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Radio() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Switch() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Range() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Url() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Password() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Response() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Listing_Fname() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Listing_Lname() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Listing_Phone() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Listing_Obtain() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Recaptcha() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_Rating() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MetForm_Input_File_Upload() );
		
	}

	public function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'metform',
			[
				'title' => esc_html__( 'Metform', 'metform' ),
				'icon' => 'fa fa-plug',
			]
		);
	}
}

