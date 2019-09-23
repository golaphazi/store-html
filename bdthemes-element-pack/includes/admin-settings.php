<?php

/**
 * Element Pack Admin Settings Class 
 *
 */

if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

class ElementPack_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new ElementPack_Settings_API;

        add_action( 'admin_init', [ $this, 'admin_init' ] );
        add_action( 'admin_menu', [ $this, 'admin_menu' ], 201 );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->element_pack_admin_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page(
            'elementor',
            '',
            esc_html__( 'Element Pack Settings', 'bdthemes-element-pack' ),
            'manage_options',
            'element_pack_options',
            [ $this, 'plugin_page' ]
        );
    }

    function get_settings_sections() {
        $sections = [
            [
                'id'    => 'element_pack_active_modules',
                'title' => esc_html__( 'Widgets', 'bdthemes-element-pack' )
            ],
            [
                'id'    => 'element_pack_third_party_widget',
                'title' => esc_html__( '3rd Party Widgets', 'bdthemes-element-pack' )
            ],
            [
                'id'    => 'element_pack_elementor_extend',
                'title' => esc_html__( 'Elementor Extend', 'bdthemes-element-pack' )
            ],
            [
                'id'    => 'element_pack_api_settings',
                'title' => esc_html__( 'API Settings', 'bdthemes-element-pack' )
            ],
            [
                'id'    => 'element_pack_video_tutorial',
                'title' => esc_html__( 'Video Tutorial', 'bdthemes-element-pack' )
            ],
        ];
        return $sections;
    }

    protected function element_pack_admin_settings() {
        $settings_fields = [
            'element_pack_active_modules' => [
                [
                    'name'    => 'accordion',
                    'label'   => esc_html__( 'Accordion', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'advanced-button',
                    'label'   => esc_html__( 'Advanced Button', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'advanced-gmap',
                    'label'   => esc_html__( 'Advanced Google Map', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'advanced-heading',
                    'label'   => esc_html__( 'Advanced Heading', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'advanced-image-gallery',
                    'label'   => esc_html__( 'Advanced Image Gallery', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'animated-heading',
                    'label'   => esc_html__( 'Animated Heading', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'audio-player',
                    'label'   => esc_html__( 'Audio Player', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'business-hours',
                    'label'   => esc_html__( 'Business Hours', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'dual-button',
                    'label'   => esc_html__( 'Dual Button', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'call-out',
                    'label'   => esc_html__( 'Call Out', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'carousel',
                    'label'   => esc_html__( 'Carousel', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'circle-menu',
                    'label'   => esc_html__( 'Circle Menu', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'cookie-consent',
                    'label'   => esc_html__( 'Cookie Consent', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'countdown',
                    'label'   => esc_html__( 'Countdown', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'contact-form',
                    'label'   => esc_html__( 'Simple Contact Form', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'comment',
                    'label'   => esc_html__( 'Comment', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'custom-gallery',
                    'label'   => esc_html__( 'Custom Gallery', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'custom-carousel',
                    'label'   => esc_html__( 'Custom Carousel', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'document-viewer',
                    'label'   => esc_html__( 'Document Viewer', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'device-slider',
                    'label'   => esc_html__( 'Device Slider', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'dropbar',
                    'label'   => esc_html__( 'Dropbar', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'flip-box',
                    'label'   => esc_html__( 'Flip Box', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'iconnav',
                    'label'   => esc_html__( 'Icon Nav', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'instagram',
                    'label'   => esc_html__( 'Instagram', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'image-compare',
                    'label'   => esc_html__( 'Image Compare', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'lightbox',
                    'label'   => esc_html__( 'Lightbox', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'modal',
                    'label'   => esc_html__( 'Modal', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'mailchimp',
                    'label'   => esc_html__( 'Mailchimp', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'marker',
                    'label'   => esc_html__( 'Marker', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'member',
                    'label'   => esc_html__( 'Member', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'navbar',
                    'label'   => esc_html__( 'Navbar', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'news-ticker',
                    'label'   => esc_html__( 'News Ticker', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'offcanvas',
                    'label'   => esc_html__( 'Offcanvas', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'price-list',
                    'label'   => esc_html__( 'Price List', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'price-table',
                    'label'   => esc_html__( 'Price Table', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'panel-slider',
                    'label'   => esc_html__( 'Panel Slider', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'post-slider',
                    'label'   => esc_html__( 'Post Slider', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'post-card',
                    'label'   => esc_html__( 'Post Card', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'post-block',
                    'label'   => esc_html__( 'Post Block', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'post-block-modern',
                    'label'   => esc_html__( 'Post Block Modern', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'progress-pie',
                    'label'   => esc_html__( 'Progress Pie', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'post-gallery',
                    'label'   => esc_html__( 'Post Gallery', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'post-grid',
                    'label'   => esc_html__( 'Post Grid', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'post-grid-tab',
                    'label'   => esc_html__( 'Post Grid Tab', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'post-list',
                    'label'   => esc_html__( 'Post List', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'qrcode',
                    'label'   => esc_html__( 'QR Code', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'slider',
                    'label'   => esc_html__( 'Slider', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'slideshow',
                    'label'   => esc_html__( 'Slideshow', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'social',
                    'label'   => esc_html__( 'Social Share', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'scrollnav',
                    'label'   => esc_html__( 'Scrollnav', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'search',
                    'label'   => esc_html__( 'Search', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'scroll-button',
                    'label'   => esc_html__( 'Scroll Button', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'scroll-image',
                    'label'   => esc_html__( 'Scroll Image', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'single-post',
                    'label'   => esc_html__( 'Single Post', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'social-share',
                    'label'   => esc_html__( 'Social Share', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'switcher',
                    'label'   => esc_html__( 'Switcher', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'tabs',
                    'label'   => esc_html__( 'Tabs', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'table',
                    'label'   => esc_html__( 'Table', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'table-of-content',
                    'label'   => esc_html__( 'Table Of Content', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'timeline',
                    'label'   => esc_html__( 'Timeline', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'trailer-box',
                    'label'   => esc_html__( 'Trailer Box', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'thumb-gallery',
                    'label'   => esc_html__( 'Thumb Gallery', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'toggle',
                    'label'   => esc_html__( 'Toggle', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'twitter-carousel',
                    'label'   => esc_html__( 'Twitter Carousel', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'twitter-slider',
                    'label'   => esc_html__( 'Twitter Slider', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'user-login',
                    'label'   => esc_html__( 'User Login', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'user-register',
                    'label'   => esc_html__( 'User Register', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'video-player',
                    'label'   => esc_html__( 'Video Player', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
                [
                    'name'    => 'weather',
                    'label'   => esc_html__( 'Weather', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],
            ],
            'element_pack_elementor_extend' => [
                [
                    'name'    => 'widget_parallax_show',
                    'label'   => esc_html__( 'Widget Parallax', 'bdthemes-element-pack' ),
                    'desc'              => __( 'Learn <a href="https://youtu.be/ZZFeoLmCJYU" target="_blank">how to use</a> widget parallax for your any widget.', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'section_parallax_show',
                    'label'   => esc_html__( 'Background Parallax', 'bdthemes-element-pack' ),
                     'desc'              => __( 'Learn <a href="https://youtu.be/UI3xKt2IlCQ" target="_blank">how to use</a> section background parallax for your any elementor section.', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'section_parallax_content_show',
                    'label'   => esc_html__( 'Section Parallax Images', 'bdthemes-element-pack' ),
                     'desc'              => __( 'Learn <a href="https://youtu.be/nMzk55831MY" target="_blank">how to use</a> section parallax element for your any elementor section.', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'section_particles_show',
                    'label'   => esc_html__( 'Section Particles', 'bdthemes-element-pack' ),
                     'desc'              => __( 'Learn <a href="https://youtu.be/8mylXgB2bYg" target="_blank">how to use</a> section particles for your any elementor section.', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'section_schedule_show',
                    'label'   => esc_html__( 'Section Schedule', 'bdthemes-element-pack' ),
                     'desc'              => __( 'Learn <a href="https://youtu.be/qWaJBg3PS-Q" target="_blank">how to set</a> section schedule for your any elementor section.', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'section_sticky_show',
                    'label'   => esc_html__( 'Section Sticky', 'bdthemes-element-pack' ),
                     'desc'              => __( 'Learn <a href="https://youtu.be/qWaJBg3PS-Q" target="_blank">how to set</a> section sticky for your any elementor section.', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "on",
                ],
                [
                    'name'    => 'widget_tooltip_show',
                    'label'   => esc_html__( 'Widget Tooltip', 'bdthemes-element-pack' ),
                     //'desc'              => __( 'Learn <a href="https://youtu.be/qWaJBg3PS-Q" target="_blank">how to set</a> section sticky for your any elementor section.', 'bdthemes-element-pack' ),
                    'type'    => 'checkbox',
                    'default' => "off",
                ],

            ],
            'element_pack_api_settings' => [
                [
                    'name'              => 'google_map_key',
                    'label'             => esc_html__( 'Google Map API Key', 'bdthemes-element-pack' ),
                    'desc'              => __( 'Go to <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">https://developers.google.com</a> and generate the API key and insert here. This API key needs for show Advanced Google Map widget correctly.', 'bdthemes-element-pack' ),
                    'placeholder'       => '------------- -------------------------',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                [
                    'name'              => 'disqus_user_name',
                    'label'             => esc_html__( 'Disqus User Name', 'bdthemes-element-pack' ),
                    'desc'              => __( 'Go to <a href="https://help.disqus.com/customer/portal/articles/1255134-updating-your-disqus-settings#account" target="_blank">https://help.disqus.com/</a> for know how to get user name of your disqus account.', 'bdthemes-element-pack' ),
                    'placeholder'       => 'for example: bdthemes',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                [
                    'name'              => 'facebook_app_id',
                    'label'             => esc_html__( 'Facebook APP ID', 'bdthemes-element-pack' ),
                    'desc'              => __( 'Go to <a href="https://developers.facebook.com/docs/apps/register#create-app" target="_blank">https://developers.facebook.com</a> for create your facebook APP ID.', 'bdthemes-element-pack' ),
                    'placeholder'       => '---------------',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],

                [
                    'name'              => 'twitter_name',
                    'label'             => esc_html__( 'Twitter User Name', 'bdthemes-element-pack' ),
                    'placeholder'       => 'for example: bdthemescom',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                [
                    'name'              => 'twitter_consumer_key',
                    'label'             => esc_html__( 'Twitter Consumer Key', 'bdthemes-element-pack' ),
                    'placeholder'       => '',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                [
                    'name'              => 'twitter_consumer_secret',
                    'label'             => esc_html__( 'Twitter Consumer Secret', 'bdthemes-element-pack' ),
                    'placeholder'       => '',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                [
                    'name'              => 'twitter_access_token',
                    'label'             => esc_html__( 'Twitter Access Token', 'bdthemes-element-pack' ),
                    'placeholder'       => '',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                [
                    'name'              => 'twitter_access_token_secret',
                    'label'             => esc_html__( 'Twitter Access Token Secret', 'bdthemes-element-pack' ),
                    'desc'              => __( 'Go to <a href="https://apps.twitter.com/app/new" target="_blank">https://apps.twitter.com/app/new</a> for create your Consumer key and Access Token.', 'bdthemes-element-pack' ),
                    'placeholder'       => '',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                [
                    'name'              => 'mailchimp_api_key',
                    'label'             => esc_html__( 'Mailchimp API Key', 'bdthemes-element-pack' ),
                    'desc'              => __( 'Go to your Mailchimp > Account > Extras > API Keys (<a href="http://prntscr.com/k4li1n" target="_blank">http://prntscr.com/k4li1n</a>) then create a key and paste here.', 'bdthemes-element-pack' ),
                    'placeholder'       => '',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                [
                    'name'              => 'mailchimp_list_id',
                    'label'             => esc_html__( 'Mailchimp List ID', 'bdthemes-element-pack' ),
                    'desc'              => __( 'Go to your Mailchimp > List > Settings > List name and default > Copy the list ID (<a href="http://prntscr.com/k4lgw2" target="_blank">http://prntscr.com/k4lgw2</a>) and paste here.', 'bdthemes-element-pack' ),
                    'placeholder'       => '',
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                
            ]
        ];

        $third_party_widget = [];
        
        if(is_plugin_active('bbpress/bbpress.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'bbpress',
                'label'   => esc_html__( 'bbPress', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }

        if(is_plugin_active('buddypress/bp-loader.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'buddypress',
                'label'   => esc_html__( 'BuddyPress', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }

        if(is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'contact-form-seven',
                'label'   => esc_html__( 'Contact Form 7', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }  
        

        if(is_plugin_active('download-monitor/download-monitor.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'download-monitor',
                'label'   => esc_html__( 'Download Monitor', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }
        
        if(is_plugin_active('easy-digital-downloads/easy-digital-downloads.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'easy-digital-downloads',
                'label'   => esc_html__( 'Easy Digital Download', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }
        
        if(is_plugin_active('bdthemes-faq/bdthemes-faq.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'faq',
                'label'   => esc_html__( 'FAQ', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "off",
            ];
        }

        if(is_plugin_active('instagram-feed/instagram-feed.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'instagram-feed',
                'label'   => esc_html__( 'Instagram Feed', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }

        if(is_plugin_active('LayerSlider/layerslider.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'layer-slider',
                'label'   => esc_html__( 'Layer Slider', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }

        if(is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'mailchimp-for-wp',
                'label'   => esc_html__( 'Mailchimp For WP', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }

        if(is_plugin_active('woocommerce/woocommerce.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'woocommerce',
                'label'   => esc_html__( 'Woocommerce', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }


        if(is_plugin_active('booked/booked.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'booked',
                'label'   => esc_html__( 'Booked', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }


        if(is_plugin_active('caldera-forms/caldera-forms.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'caldera-forms',
                'label'   => esc_html__( 'Caldera Forms', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }

        if(is_plugin_active('gravityforms/gravityforms.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'gravity-forms',
                'label'   => esc_html__( 'Gravity Forms', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }

        if(is_plugin_active('nextgen-gallery/nggallery.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'nextgen-gallery',
                'label'   => esc_html__( 'NextGen Gallery', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }
        
        if(is_plugin_active('ninja-forms/ninja-forms.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'ninja-forms',
                'label'   => esc_html__( 'Ninja Forms', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }


        if(is_plugin_active('quform/quform.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'quform',
                'label'   => esc_html__( 'QuForm', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }
        
        if(is_plugin_active('revslider/revslider.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'revolution-slider',
                'label'   => esc_html__( 'Revolution Slider', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }

        if(is_plugin_active('tablepress/tablepress.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'tablepress',
                'label'   => esc_html__( 'TablePress', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }
        
        if(is_plugin_active( 'bdthemes-testimonials/bdthemes-testimonials.php' ) || is_plugin_active( 'jetpack/jetpack.php' )) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'testimonial-carousel',
                'label'   => esc_html__( 'Testimonial Carousel', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'testimonial-grid',
                'label'   => esc_html__( 'Testimonial Grid', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'testimonial-slider',
                'label'   => esc_html__( 'Testimonial Slider', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }
        
        if(is_plugin_active('wpforms-lite/wpforms.php')) {
            $third_party_widget['element_pack_third_party_widget'][] = [
                'name'    => 'wp-forms',
                'label'   => esc_html__( 'Wp Forms', 'bdthemes-element-pack' ),
                'type'    => 'checkbox',
                'default' => "on",
            ];
        }
        

        $third_party_widget['element_pack_video_tutorial'][] = [
            'name'        => 'html',
            'desc'        => '<div class="element_pack_video_wrapper"><iframe width="1280" height="720" src="https://www.youtube.com/embed/videoseries?list=PLP0S85GEw7DOJf_cbgUIL20qqwqb5x8KA" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>',
            'type'        => 'html'
        ];     

        return array_merge($settings_fields, $third_party_widget);
    }


    function plugin_page() {

        echo '<div class="wrap">';
        echo '<h1>Element Pack Settings</h1>';
        $this->save_message();
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        $this->footer_info();
        echo '</div>';

    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Your settings have been saved.', 'bdthemes-element-pack') ?></strong></p>
            </div>
            
            <?php
        }
    }

    function footer_info() {
        ?>
        <div class="element-pack-footer-info">
            <p>If you don't know how to use the widgets please visit our <a href="https://www.youtube.com/playlist?list=PLP0S85GEw7DOJf_cbgUIL20qqwqb5x8KA">Youtube Channel</a> for visual instructions.</p>
            
            <p>For help and support please send a <a href="https://bdthemes.com/support/">Support Ticket</a> to us or email directly at: <a href="mailto:support@bdthemes.com">support@bdthemes.com</a>.</p>
            
            <p>If you think the <strong>Element Pack</strong> plugin helped you build your website don't forget to leave us <a href="https://codecanyon.net/item/element-pack-addon-for-elementor-page-builder-wordpress-plugin/21177318">★★★★★</a> <strong>rating on CodeCanyon</strong>. Thank you!</p>
        </div>
        <?php
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = [];
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}

new ElementPack_Admin_Settings();