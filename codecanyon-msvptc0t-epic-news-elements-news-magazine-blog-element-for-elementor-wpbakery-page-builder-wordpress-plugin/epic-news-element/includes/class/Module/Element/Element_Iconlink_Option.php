<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Element;

use EPIC\Module\ModuleOptionAbstract;

Class Element_Iconlink_Option extends ModuleOptionAbstract
{
    public function compatible_column()
    {
        return array(1,2,3,4,5,6,7,8,9,10,11,12);
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - Icon Link', 'epic-ne');
    }

    public function get_category()
    {
	    return esc_html__('EPIC - Element', 'epic-ne');
    }

	public function set_options()
    {
        $this->set_icon_option();
        $this->set_style_option();
    }

    public function set_icon_option()
    {
        $this->options[] = array(
            'type'          => 'iconpicker',
            'param_name'    => 'icon',
            'heading'       => esc_html__('Icon', 'epic-ne'),
            'description'   => esc_html__('Choose icon for this icon link', 'epic-ne'),
            'std'         => 'fa fa-bolt',
            'settings'      => array(
                'emptyIcon'     => false,
                'iconsPerPage'  => 100,
            )
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'title',
            'heading'       => esc_html__('Title', 'epic-ne'),
            'description'   => esc_html__('Insert a text for block link title.', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'subtitle',
            'heading'       => esc_html__('Subtitle', 'epic-ne'),
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
    }

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for title', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_block_icon_title h3',
			]
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'meta_typography',
				'label'       => esc_html__( 'Second Title Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for second title', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_block_icon_desc_span span',
			]
		);
	}
}
