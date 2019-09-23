<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Post;

use EPIC\Module\ModuleOptionAbstract;

Class Post_Feature_Option extends ModuleOptionAbstract
{
    public function get_category()
    {
        return esc_html__('EPIC - Post', 'epic-ne');
    }

    public function compatible_column()
    {
        return array( 1,2,3,4,5,6,7,8,9,10,11,12 );
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - Post Featured Image', 'epic-ne');
    }

    public function set_options()
    {
        $this->set_post_option();
        $this->set_style_option();
    }

    public function set_post_option()
    {
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'image_size',
            'heading'       => esc_html__('Featured Image Size', 'epic-ne'),
            'description'   => esc_html__('choose which feature image size','epic-ne'),
            'std'           => '1140x570',
            'value'         => array(
                esc_html__('1140x570', 'epic-ne')                => '1140x570',
                esc_html__('750x375', 'epic-ne')                 => '750x375',
                esc_html__('1140x815', 'epic-ne')                => '1140x815',
                esc_html__('750x536', 'epic-ne')                 => '750x536',
                esc_html__('Width 1140', 'epic-ne')              => 'featured-1140',
                esc_html__('Width 750', 'epic-ne')               => 'featured-750',
                esc_html__('Full Width', 'epic-ne')              => 'full',
            )
        );

//        $this->options[] = array(
//            'type'          => 'dropdown',
//            'param_name'    => 'gallery_size',
//            'heading'       => esc_html__('Gallery Image Size', 'epic-ne'),
//            'description'   => esc_html__('choose which gallery image size','epic-ne'),
//            'std'           => '',
//            'value'         => array(
//                esc_html__('1140x570', 'epic-ne')                => '1140x570',
//                esc_html__('750x375', 'epic-ne')                 => '750x375',
//                esc_html__('1140x815', 'epic-ne')                => '1140x815',
//                esc_html__('750x536', 'epic-ne')                 => '750x536',
//                esc_html__('Width 1140', 'epic-ne')              => 'featured-1140',
//                esc_html__('Width 750', 'epic-ne')               => 'featured-750',
//            )
//        );
    }
}
