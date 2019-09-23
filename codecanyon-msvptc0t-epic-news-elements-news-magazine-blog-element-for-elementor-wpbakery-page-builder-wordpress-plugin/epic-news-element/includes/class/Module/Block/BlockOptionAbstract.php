<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

use EPIC\Module\ModuleOptionAbstract;

abstract Class BlockOptionAbstract extends ModuleOptionAbstract
{
    protected $default_number_post = 5;
    protected $show_excerpt = false;
    protected $show_ads = false;
    protected $default_ajax_post = 5;

    public function compatible_column()
    {
        return array( 4, 8 , 12 );
    }

    public function set_options()
    {
        $this->set_header_option();
        $this->set_header_filter_option();
        $this->set_content_filter_option($this->default_number_post);
        $this->set_content_setting_option($this->show_excerpt);
        $this->set_ajax_filter_option($this->default_ajax_post);
        $this->set_ads_setting_option($this->show_ads);
        $this->set_style_option();
    }

    protected function get_ad_size()
    {
        return array(
            esc_attr__('Auto', 'epic-ne')              => 'auto',
            esc_attr__('Hide', 'epic-ne')              => 'hide',
            esc_attr__('120 x 90', 'epic-ne')          => '120x90',
            esc_attr__('120 x 240', 'epic-ne')         => '120x240',
            esc_attr__('120 x 600', 'epic-ne')         => '120x600',
            esc_attr__('125 x 125', 'epic-ne')         => '125x125',
            esc_attr__('160 x 90', 'epic-ne')          => '160x90',
            esc_attr__('160 x 600', 'epic-ne')         => '160x600',
            esc_attr__('180 x 90', 'epic-ne')          => '180x90',
            esc_attr__('180 x 150', 'epic-ne')         => '180x150',
            esc_attr__('200 x 90', 'epic-ne')          => '200x90',
            esc_attr__('200 x 200', 'epic-ne')         => '200x200',
            esc_attr__('234 x 60', 'epic-ne')          => '234x60',
            esc_attr__('250 x 250', 'epic-ne')         => '250x250',
            esc_attr__('320 x 100', 'epic-ne')         => '320x100',
            esc_attr__('300 x 250', 'epic-ne')         => '300x250',
            esc_attr__('300 x 600', 'epic-ne')         => '300x600',
            esc_attr__('320 x 50', 'epic-ne')          => '320x50',
            esc_attr__('336 x 280', 'epic-ne')         => '336x280',
            esc_attr__('468 x 15', 'epic-ne')          => '468x15',
            esc_attr__('468 x 60', 'epic-ne')          => '468x60',
            esc_attr__('728 x 15', 'epic-ne')          => '728x15',
            esc_attr__('728 x 90', 'epic-ne')          => '728x90',
            esc_attr__('970 x 90', 'epic-ne')          => '970x90',
            esc_attr__('240 x 400', 'epic-ne')         => '240x400',
            esc_attr__('250 x 360', 'epic-ne')         => '250x360',
            esc_attr__('580 x 400', 'epic-ne')         => '580x400',
            esc_attr__('750 x 100', 'epic-ne')         => '750x100',
            esc_attr__('750 x 200', 'epic-ne')         => '750x200',
            esc_attr__('750 x 300', 'epic-ne')         => '750x300',
            esc_attr__('980 x 120', 'epic-ne')         => '980x120',
            esc_attr__('930 x 180', 'epic-ne')         => '930x180',
        );
    }

    public function additional_style()
    {
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'title_color',
            'group'         => esc_html__('Design', 'epic-ne'),
            'heading'       => esc_html__('Title Color', 'epic-ne'),
            'description'   => esc_html__('This option will change your Title color.', 'epic-ne'),
        );

        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'accent_color',
            'group'         => esc_html__('Design', 'epic-ne'),
            'heading'       => esc_html__('Accent Color & Link Hover', 'epic-ne'),
            'description'   => esc_html__('This option will change your accent color.', 'epic-ne'),
        );

        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'alt_color',
            'group'         => esc_html__('Design', 'epic-ne'),
            'heading'       => esc_html__('Meta Color', 'epic-ne'),
            'description'   => esc_html__('This option will change your meta color.', 'epic-ne'),
        );

        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'excerpt_color',
            'group'         => esc_html__('Design', 'epic-ne'),
            'heading'       => esc_html__('Excerpt Color', 'epic-ne'),
            'description'   => esc_html__('This option will change your excerpt color.', 'epic-ne'),
        );
    }

    /**
     * @return array
     */
    public function set_header_option()
    {
        $this->options[] = array(
            'type'          => 'iconpicker',
            'param_name'    => 'header_icon',
            'heading'       => esc_html__('Header Icon', 'epic-ne'),
            'description'   => esc_html__('Choose icon for this block icon.', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
            'std'         => '',
            'settings'      => array(
                'emptyIcon'     => true,
                'iconsPerPage'  => 100,
            )
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'first_title',
            'holder'        => 'span',
            'heading'       => esc_html__('Title', 'epic-ne'),
            'description'   => esc_html__('Main title of Module Block.', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'second_title',
            'holder'        => 'span',
            'heading'       => esc_html__('Second Title', 'epic-ne'),
            'description'   => esc_html__('Secondary title of Module Block.', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'url',
            'heading'       => esc_html__('Title URL', 'epic-ne'),
            'description'   => esc_html__('Insert URL of heading title.', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'radioimage',
            'param_name'    => 'header_type',
            'std'           => 'heading_6',
            'value'         => array(
                EPIC_URL . '/assets/img/admin/heading-1.png'  => 'heading_1',
                EPIC_URL . '/assets/img/admin/heading-2.png'  => 'heading_2',
                EPIC_URL . '/assets/img/admin/heading-3.png'  => 'heading_3',
                EPIC_URL . '/assets/img/admin/heading-4.png'  => 'heading_4',
                EPIC_URL . '/assets/img/admin/heading-5.png'  => 'heading_5',
                EPIC_URL . '/assets/img/admin/heading-6.png'  => 'heading_6',
                EPIC_URL . '/assets/img/admin/heading-7.png'  => 'heading_7',
                EPIC_URL . '/assets/img/admin/heading-8.png'  => 'heading_8',
                EPIC_URL . '/assets/img/admin/heading-9.png'  => 'heading_9',
            ),
            'heading'       => esc_html__('Header Type', 'epic-ne'),
            'description'   => esc_html__('Choose which header type fit with your content design.', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_background',
            'heading'       => esc_html__('Header Background', 'epic-ne'),
            'description'   => esc_html__('This option may not work for all of heading type.', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
            'dependency'    => array('element' => "header_type", 'value' => array('heading_1', 'heading_2', 'heading_3', 'heading_4', 'heading_5'))
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_secondary_background',
            'heading'       => esc_html__('Header Secondary Background', 'epic-ne'),
            'description'   => esc_html__('change secondary background', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
            'dependency'    => array('element' => "header_type", 'value' => array('heading_2'))
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_text_color',
            'heading'       => esc_html__('Header Text Color', 'epic-ne'),
            'description'   => esc_html__('Change color of your header text', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_line_color',
            'heading'       => esc_html__('Header line Color', 'epic-ne'),
            'description'   => esc_html__('Change line color of your header', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
            'dependency'    => array('element' => "header_type", 'value' => array('heading_1', 'heading_5', 'heading_6', 'heading_9'))
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_accent_color',
            'heading'       => esc_html__('Header Accent', 'epic-ne'),
            'description'   => esc_html__('Change Accent of your header', 'epic-ne'),
            'group'         => esc_html__('Header', 'epic-ne'),
            'dependency'    => array('element' => "header_type", 'value' => array('heading_6', 'heading_7'))
        );
    }

    /**
     * @return array
     */
    public function set_header_filter_option()
    {
        $this->options[] = array(
            'type'          => 'select',
            'multiple'      => PHP_INT_MAX,
            'ajax'          => 'epic_find_category',
            'options'       => 'epic_get_category_option',
            'nonce'         => wp_create_nonce('epic_find_category'),
            'param_name'    => 'header_filter_category',
            'heading'       => esc_html__('Category', 'epic-ne'),
            'description'   => esc_html__('Add category filter for heading module.', 'epic-ne'),
            'group'         => esc_html__('Header Filter', 'epic-ne'),
            'std'           => '',
        );
        $this->options[] = array(
	        'type'          => 'select',
	        'multiple'      => PHP_INT_MAX,
	        'ajax'          => 'epic_find_author',
	        'options'       => 'epic_get_author_option',
	        'nonce'         => wp_create_nonce('epic_find_author'),
            'param_name'    => 'header_filter_author',
            'heading'       => esc_html__('Author', 'epic-ne'),
            'description'   => esc_html__('Add author filter for heading module.', 'epic-ne'),
            'group'         => esc_html__('Header Filter', 'epic-ne'),
            'std'           => '',
        );
        $this->options[] = array(
	        'type'          => 'select',
	        'multiple'      => PHP_INT_MAX,
	        'ajax'          => 'epic_find_tag',
	        'options'       => 'epic_get_tag_option',
	        'nonce'         => wp_create_nonce('epic_find_tag'),
            'param_name'    => 'header_filter_tag',
            'heading'       => esc_html__('Tags', 'epic-ne'),
            'description'   => esc_html__('Add tag filter for heading module.', 'epic-ne'),
            'group'         => esc_html__('Header Filter', 'epic-ne'),
            'std'           => '',
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'header_filter_text',
            'heading'       => esc_html__('Default Text', 'epic-ne'),
            'description'   => esc_html__('First item text on heading filter.', 'epic-ne'),
            'group'         => esc_html__('Header Filter', 'epic-ne'),
            'std'           => 'All'
        );
    }

    public function set_content_setting_option($show_excerpt = false)
    {
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'date_format',
            'heading'       => esc_html__('Content Date Format', 'epic-ne'),
            'description'   => esc_html__('Choose which date format you want to use.', 'epic-ne'),
            'std'           => 'default',
            'group'         => esc_html__('Content Setting', 'epic-ne'),
            'value'         => array(
                esc_html__('Relative Date/Time Format (ago)', 'epic-ne')               => 'ago',
                esc_html__('WordPress Default Format', 'epic-ne')      => 'default',
                esc_html__('Custom Format', 'epic-ne')                 => 'custom',
            )
        );

        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'date_format_custom',
            'heading'       => esc_html__('Custom Date Format', 'epic-ne'),
            'description'   => wp_kses(sprintf(__('Please write custom date format for your module, for more detail about how to write date format, you can refer to this <a href="%s" target="_blank">link</a>.', 'epic-ne'), 'https://codex.wordpress.org/Formatting_Date_and_Time'), wp_kses_allowed_html()),
            'group'         => esc_html__('Content Setting', 'epic-ne'),
            'std'           => 'Y/m/d',
            'dependency'    => array('element' => 'date_format', 'value' => array('custom'))
        );

        if($show_excerpt)
        {
            $this->options[] = array(
                'type'          => 'slider',
                'param_name'    => 'excerpt_length',
                'heading'       => esc_html__('Excerpt Length', 'epic-ne'),
                'description'   => esc_html__('Set word length of excerpt on post block.', 'epic-ne'),
                'group'         => esc_html__('Content Setting', 'epic-ne'),
                'min'           => 0,
                'max'           => 200,
                'step'          => 1,
                'std'           => 20,
            );

            $this->options[] = array(
                'type'          => 'textfield',
                'param_name'    => 'excerpt_ellipsis',
                'heading'       => esc_html__('Excerpt Ellipsis', 'epic-ne'),
                'description'   => esc_html__('Define excerpt ellipsis', 'epic-ne'),
                'group'         => esc_html__('Content Setting', 'epic-ne'),
                'std'           => '...'
            );
        }
    }

    public function set_ajax_filter_option($number = 10)
    {
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'pagination_mode',
            'heading'       => esc_html__('Choose Pagination Mode', 'epic-ne'),
            'description'   => esc_html__('Choose which pagination mode that fit with your block.', 'epic-ne'),
            'group'         => esc_html__('Pagination', 'epic-ne'),
            'std'           => 'disable',
            'value'         => array(
                esc_html__('No Pagination', 'epic-ne')             => 'disable',
                esc_html__('Next Prev', 'epic-ne')                 => 'nextprev',
                esc_html__('Load More', 'epic-ne')                 => 'loadmore',
                esc_html__('Auto Load on Scroll', 'epic-ne')       => 'scrollload',
            )
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'pagination_nextprev_showtext',
            'heading'       => esc_html__('Show Navigation Text', 'epic-ne'),
            'value'         => array( esc_html__('Show Next/Prev text in the navigation controls.', 'epic-ne') => 'no' ),
            'group'         => esc_html__('Pagination', 'epic-ne'),
            'dependency'    => array('element' => "pagination_mode", 'value' => array('nextprev'))
        );
        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'pagination_number_post',
            'heading'       => esc_html__('Pagination Post', 'epic-ne'),
            'description'   => esc_html__('Number of Post loaded during pagination request.', 'epic-ne'),
            'group'         => esc_html__('Pagination', 'epic-ne'),
            'min'           => 1,
            'max'           => 30,
            'step'          => 1,
            'std'           => $number,
            'dependency'    => array('element' => "pagination_mode", 'value' => array('nextprev','loadmore','scrollload'))
        );
        $this->options[] = array(
            'type'          => 'number',
            'param_name'    => 'pagination_scroll_limit',
            'heading'       => esc_html__('Auto Load Limit', 'epic-ne'),
            'description'   => esc_html__('Limit of auto load when scrolling, set to zero to always load until end of content.', 'epic-ne'),
            'group'         => esc_html__('Pagination', 'epic-ne'),
            'min'           => 0,
            'max'           => 9999,
            'step'          => 1,
            'std'           => 0,
            'dependency'    => array('element' => "pagination_mode", 'value' => array('scrollload'))
        );
    }

    public function set_ads_setting_option( $show_ads = false )
    {
        if ( ! $show_ads ) return false;

        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'ads_type',
            'heading'       => esc_html__('Ads Type', 'epic-ne'),
            'description'   => esc_html__('Choose which ads type you want to use.', 'epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'std'           => 'disable',
            'value'         => array(
                esc_html__('Disable Ads', 'epic-ne')   => 'disable',
                esc_html__('Image Ads', 'epic-ne')     => 'image',
                esc_html__('Google Ads', 'epic-ne')    => 'googleads',
                esc_html__('Script Code', 'epic-ne')   => 'code'
            )
        );
        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'ads_position',
            'heading'       => esc_html__('Ads Position', 'epic-ne'),
            'description'   => esc_html__('Set after certain number of post you want this advertisement to show.', 'epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image', 'code', 'googleads')),
            'min'           => 1,
            'max'           => 10,
            'step'          => 1,
            'std'           => 1,
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'ads_random',
            'heading'       => esc_html__('Random Ads Position', 'epic-ne'),
            'value'         => array( esc_html__("Set after random certain number of post you want this advertisement to show.", 'epic-ne') => 'yes' ),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image', 'code', 'googleads'))
        );
        // IMAGE
        $this->options[] = array(
            'type'          => 'attach_image',
            'param_name'    => 'ads_image',
            'heading'       => esc_html__('Ads Image', 'epic-ne'),
            'description'   => esc_html__('Upload your ads image.', 'epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
        );
	    $this->options[] = array(
		    'type'          => 'attach_image',
		    'param_name'    => 'ads_image_tablet',
		    'heading'       => esc_html__('Ads Image Tablet', 'epic-ne'),
		    'description'   => esc_html__('Upload your ads image that will be shown on the tablet view.', 'epic-ne'),
		    'group'         => esc_html__('Ads', 'epic-ne'),
		    'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
	    );
	    $this->options[] = array(
		    'type'          => 'attach_image',
		    'param_name'    => 'ads_image_phone',
		    'heading'       => esc_html__('Ads Image Phone', 'epic-ne'),
		    'description'   => esc_html__('Upload your ads image that will be shown on the phone view.', 'epic-ne'),
		    'group'         => esc_html__('Ads', 'epic-ne'),
		    'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
	    );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'ads_image_link',
            'heading'       => esc_html__('Ads Image Link', 'epic-ne'),
            'description'   => esc_html__('Insert link of your image ads.','epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'ads_image_alt',
            'heading'       => esc_html__('Image Alternate Text','epic-ne'),
            'description'   => esc_html__('Insert alternate of your ads image.','epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'ads_image_new_tab',
            'heading'       => esc_html__('Open New Tab','epic-ne'),
            'value'         => array( esc_html__("Open in new tab when ads image clicked.", 'epic-ne') => 'yes' ),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
        );
        // GOOGLE
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'google_publisher_id',
            'heading'       => esc_html__('Publisher ID','epic-ne'),
            'description'   => esc_html__('Insert data-ad-client / google_ad_client content.','epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads'))
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'google_slot_id',
            'heading'       => esc_html__('Ads Slot ID','epic-ne'),
            'description'   => esc_html__('Insert data-ad-slot / google_ad_slot content.','epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads'))
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'google_desktop',
            'heading'       => esc_html__('Desktop Ads Size','epic-ne'),
            'description'   => esc_html__('Choose ads size to show on desktop.','epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads')),
            'std'           => 'auto',
            'value'         => $this->get_ad_size()
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'google_tab',
            'heading'       => esc_html__('Tab Ads Size','epic-ne'),
            'description'   => esc_html__('Choose ads size to show on tab.','epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads')),
            'std'           => 'auto',
            'value'         => $this->get_ad_size()
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'google_phone',
            'heading'       => esc_html__('Phone Ads Size','epic-ne'),
            'description'   => esc_html__('Choose ads size to show on phone.','epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads')),
            'std'           => 'auto',
            'value'         => $this->get_ad_size()
        );
        // CODE
        $this->options[] = array(
            'type'          => 'textarea_html',
            'param_name'    => 'content',
            'heading'       => esc_html__('Script Ads Code','epic-ne'),
            'description'   => esc_html__('Put your full ads script right here.','epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('code'))
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'ads_bottom_text',
            'heading'       => esc_html__('Show Advertisement Text', 'epic-ne'),
            'description'   => esc_html__('Show Advertisement Text on bottom of advertisement', 'epic-ne'),
            'group'         => esc_html__('Ads', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
        );
    }

    protected function set_boxed_option()
    {
	    $this->options[] = array(
		    'type'          => 'checkbox',
		    'param_name'    => 'boxed',
		    'group'         => esc_html__('Design', 'epic-ne'),
		    'heading'       => esc_html__('Enable Boxed', 'epic-ne'),
		    'value'         => array( esc_html__("This option will turn the module into boxed.", 'epic-ne') => 'true' ),
	    );

	    $this->options[] = array(
		    'type'          => 'checkbox',
		    'param_name'    => 'boxed_shadow',
		    'group'         => esc_html__('Design', 'epic-ne'),
		    'heading'       => esc_html__('Enable Shadow', 'epic-ne'),
		    'dependency'    => array('element' => "boxed", 'value' => 'true')
	    );
    }

    public function set_typography_option( $instance ) {

	    $instance->add_group_control(
		    \Elementor\Group_Control_Typography::get_type(),
		    [
			    'name'        => 'title_typography',
			    'label'       => esc_html__( 'Title Typography', 'epic-ne' ),
			    'description' => esc_html__( 'Set typography for post title', 'epic-ne' ),
			    'selector'    => '{{WRAPPER}} .jeg_post_title > a',
		    ]
	    );

	    $instance->add_group_control(
		    \Elementor\Group_Control_Typography::get_type(),
		    [
			    'name'        => 'meta_typography',
			    'label'       => esc_html__( 'Meta Typography', 'epic-ne' ),
			    'description' => esc_html__( 'Set typography for post meta', 'epic-ne' ),
			    'selector'    => '{{WRAPPER}} .jeg_post_meta, {{WRAPPER}} .jeg_post_meta .fa, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a:hover, {{WRAPPER}} .jeg_pl_md_card .jeg_post_category a, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a.current, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta .fa, {{WRAPPER}} .jeg_post_category a',
		    ]
	    );

	    $instance->add_group_control(
		    \Elementor\Group_Control_Typography::get_type(),
		    [
			    'name'        => 'content_typography',
			    'label'       => esc_html__( 'Post Content Typography', 'epic-ne' ),
			    'description' => esc_html__( 'Set typography for post content', 'epic-ne' ),
			    'selector'    => '{{WRAPPER}} .jeg_post_excerpt, {{WRAPPER}} .jeg_readmore',
		    ]
	    );
    }
}
