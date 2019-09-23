<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Element;

use EPIC\Module\ModuleOptionAbstract;

Class Element_Ads_Option extends ModuleOptionAbstract
{
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
            esc_attr__('970 x 250', 'epic-ne')         => '970x250',
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

	public function get_category()
	{
		return esc_html__('EPIC - Element', 'epic-ne');
	}

    public function compatible_column()
    {
        return array( 1,2,3,4,5,6,7,8,9,10,11,12 );
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - Ads Block', 'epic-ne');
    }

    public function set_options()
    {
        $this->get_ads_option();
        $this->set_style_option();
    }

    public function get_ads_option()
    {
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'ads_type',
            'heading'       => esc_html__('Ads Type', 'epic-ne'),
            'description'   => esc_html__('Choose which ads type you want to use.', 'epic-ne'),
            'std'           => 'googleads',
            'value'         => array(
                esc_html__('Image Ads', 'epic-ne')     => 'image',
                esc_html__('Script Code', 'epic-ne')   => 'code',
                esc_html__('Google Ads', 'epic-ne')    => 'googleads',
            ),
        );
        // IMAGE
        $this->options[] = array(
            'type'          => 'attach_image',
            'param_name'    => 'ads_image',
            'heading'       => esc_html__('[Image Ads] Ads Image Desktop', 'epic-ne'),
            'description'   => esc_html__('Upload your ads image that will be shown on the desktop view.', 'epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
        );
	    $this->options[] = array(
		    'type'          => 'attach_image',
		    'param_name'    => 'ads_image_tablet',
		    'heading'       => esc_html__('[Image Ads] Ads Image Tablet', 'epic-ne'),
		    'description'   => esc_html__('Upload your ads image that will be shown on the tablet view.', 'epic-ne'),
		    'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
	    );
	    $this->options[] = array(
		    'type'          => 'attach_image',
		    'param_name'    => 'ads_image_phone',
		    'heading'       => esc_html__('[Image Ads] Ads Image Phone', 'epic-ne'),
		    'description'   => esc_html__('Upload your ads image that will be shown on the phone view.', 'epic-ne'),
		    'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
	    );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'ads_image_link',
            'heading'       => esc_html__('[Image Ads] Ads Image Link', 'epic-ne'),
            'description'   => esc_html__('Insert link of your image ads.','epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'ads_image_alt',
            'heading'       => esc_html__('[Image Ads] Image Alternate Text','epic-ne'),
            'description'   => esc_html__('Insert alternate of your ads image.','epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'ads_image_new_tab',
            'heading'       => esc_html__('[Image Ads] Open New Tab','epic-ne'),
            'value'         => array( "Open in new tab when ads image clicked." => 'yes' ),
            'dependency'    => Array('element' => "ads_type", 'value' => array('image'))
        );
        // GOOGLE
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'google_publisher_id',
            'heading'       => esc_html__('[Google Ads] Publisher ID','epic-ne'),
            'description'   => esc_html__('Insert data-ad-client / google_ad_client content.','epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads'))
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'google_slot_id',
            'heading'       => esc_html__('[Google Ads] Ads Slot ID','epic-ne'),
            'description'   => esc_html__('Insert data-ad-slot / google_ad_slot content.','epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads'))
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'google_desktop',
            'heading'       => esc_html__('[Google Ads] Desktop Ads Size','epic-ne'),
            'description'   => esc_html__('Choose ads size to show on desktop.','epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads')),
            'std'           => 'auto',
            'value'         => $this->get_ad_size()
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'google_tab',
            'heading'       => esc_html__('[Google Ads] Tab Ads Size','epic-ne'),
            'description'   => esc_html__('Choose ads size to show on tab.','epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads')),
            'std'           => 'auto',
            'value'         => $this->get_ad_size()
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'google_phone',
            'heading'       => esc_html__('[Google Ads] Phone Ads Size','epic-ne'),
            'description'   => esc_html__('Choose ads size to show on phone.','epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads')),
            'std'           => 'auto',
            'value'         => $this->get_ad_size()
        );
        // CODE
        $this->options[] = array(
            'type'          => 'textarea_html',
            'param_name'    => 'content',
            'heading'       => esc_html__('[Script Code] Ads Code','epic-ne'),
            'description'   => esc_html__('Put your full ads script right here.','epic-ne'),
            'dependency'    => Array('element' => "ads_type", 'value' => array('code'))
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'ads_bottom_text',
            'heading'       => esc_html__('Show Advertisement Text', 'epic-ne'),
            'description'   => esc_html__('Show Advertisement Text on bottom of advertisement', 'epic-ne'),
        );
    }
}
