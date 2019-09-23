<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Element;

use EPIC\Module\ModuleOptionAbstract;

Class Element_Embedplaylist_Option extends ModuleOptionAbstract
{
    public function compatible_column()
    {
        return array( 4, 8 , 12 );
    }

    public function get_category()
    {
	    return esc_html__( 'EPIC - Element', 'epic-ne' );
    }

	public function show_color_scheme()
    {
        return false;
    }

    public function set_options()
    {
        $this->set_playlist_option();
        $this->set_style_option();
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - Youtube / Vimeo Playlist', 'epic-ne');
    }

    public function set_playlist_option()
    {
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'layout',
            'heading'       => esc_html__('Video Playlist Layout', 'epic-ne'),
            'description'   => esc_html__('Choose video playlist layout.', 'epic-ne'),
            'std'           => 'default',
            'value'         => array(
                esc_html__('Horizontal', 'epic-ne')    => 'horizontal',
                esc_html__('Vertical', 'epic-ne')      => 'vertical',
            )
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'scheme',
            'heading'       => esc_html__('Video Playlist Scheme', 'epic-ne'),
            'description'   => esc_html__('Choose video scheme color.', 'epic-ne'),
            'std'           => 'light',
            'value'         => array(
                esc_html__('Light Scheme', 'epic-ne')      => 'light',
                esc_html__('Dark Scheme', 'epic-ne')    => 'dark',
            )
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'playlist',
            'heading'       => esc_html__('YouTube / Vimeo Video', 'epic-ne'),
            'description'   => esc_html__('Enter your youtube / vimeo video separated by comma (Ex : https://www.youtube.com/watch?v=IvcE4o36cAo, https://vimeo.com/180337696).', 'epic-ne'),
        );
    }

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for title', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_video_playlist_current_info a,{{WRAPPER}} .jeg_video_playlist_title',
			]
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'meta_typography',
				'label'       => esc_html__( 'Meta Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for post meta', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_video_playlist_category',
			]
		);
	}
}
