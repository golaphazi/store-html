<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Element;

use EPIC\Module\ModuleOptionAbstract;

Class Element_Blocklink_Option extends ModuleOptionAbstract
{
    public function compatible_column()
    {
        return array( 4, 8 , 12 );
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - Block Link', 'epic-ne');
    }

	public function get_category()
	{
		return esc_html__('EPIC - Element', 'epic-ne');
	}

    public function set_options()
    {
        $this->set_playlist_option();
        $this->set_style_option();
    }

    public function set_playlist_option()
    {
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'first_title',
            'heading'       => esc_html__('Title', 'epic-ne'),
            'description'   => esc_html__('Insert a text for block link title.', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'second_title',
            'heading'       => esc_html__('Second Title', 'epic-ne'),
            'description'   => esc_html__('Sub title or short description.', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'title_url',
            'heading'       => esc_html__('Title URL', 'epic-ne'),
            'description'   => esc_html__('Url of block link title.', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'newtab',
            'heading'       => esc_html__('Open New Tab', 'epic-ne'),
            'description'   => esc_html__('Check this option to open link on new tab.', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'attach_image',
            'param_name'    => 'image',
            'heading'       => esc_html__('Background Image', 'epic-ne'),
            'description'   => esc_html__('Choose an image for block background.', 'epic-ne'),
        );

        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'use_video_bg',
            'heading'       => esc_html__('Use Video Background', 'epic-ne'),
            'description'   => esc_html__('If checked, video will be used as background.', 'epic-ne'),
        );

        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'video_url',
            'heading'       => esc_html__('YouTube Link', 'epic-ne'),
            'description'   => esc_html__('Add YouTube video link to used as video background.', 'epic-ne'),
            'dependency'    => array('element' => 'use_video_bg', 'value' => 'true'),
        );
    }

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for title', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_block_content h3',
			]
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'meta_typography',
				'label'       => esc_html__( 'Second Title Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for second title', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_block_content span',
			]
		);
	}
}
