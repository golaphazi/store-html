<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Element;

use EPIC\Module\ModuleOptionAbstract;

Class Element_Header_Option extends ModuleOptionAbstract
{
    public function compatible_column()
    {
        return array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 );
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - Header Module', 'epic-ne');
    }

    public function get_category()
    {
	    return esc_html__('EPIC - Element', 'epic-ne');
    }

	public function set_options()
    {
        $this->set_header_option();
        $this->set_style_option();
    }

    public function set_header_option()
    {
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'first_title',
            'holder'        => 'span',
            'heading'       => esc_html__('Title', 'epic-ne'),
            'description'   => esc_html__('Main title of Module Block.', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'second_title',
            'holder'        => 'span',
            'heading'       => esc_html__('Second Title', 'epic-ne'),
            'description'   => esc_html__('Secondary title of Module Block.', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'url',
            'heading'       => esc_html__('Title URL', 'epic-ne'),
            'description'   => esc_html__('Insert URL of heading title.', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'radioimage',
            'param_name'    => 'header_type',
            'std'           => 'heading_1',
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
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'header_align',
            'heading'       => esc_html__('Header Align', 'epic-ne'),
            'description'   => esc_html__('Choose which header alignment you want to use.', 'epic-ne'),
            'std'           => 'left',
            'value'         => array(
                esc_html__('Left', 'epic-ne')              => 'left',
                esc_html__('Center', 'epic-ne')            => 'center',
            )
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_background',
            'heading'       => esc_html__('Header Background', 'epic-ne'),
            'description'   => esc_html__('This option may not work for all of heading type.', 'epic-ne'),
            'dependency'    => array('element' => "header_type", 'value' => array('heading_1', 'heading_2', 'heading_3', 'heading_4', 'heading_5')),
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_secondary_background',
            'heading'       => esc_html__('Header Secondary Background', 'epic-ne'),
            'description'   => esc_html__('change secondary background', 'epic-ne'),
            'dependency'    => array('element' => "header_type", 'value' => array('heading_2'))
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_text_color',
            'heading'       => esc_html__('Header Text Color', 'epic-ne'),
            'description'   => esc_html__('Change color of your header text', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_line_color',
            'heading'       => esc_html__('Header line Color', 'epic-ne'),
            'description'   => esc_html__('Change line color of your header', 'epic-ne'),
            'dependency'    => array('element' => "header_type", 'value' => array('heading_1', 'heading_5', 'heading_6', 'heading_9'))
        );
        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'header_accent_color',
            'heading'       => esc_html__('Header Accent', 'epic-ne'),
            'description'   => esc_html__('Change Accent of your header', 'epic-ne'),
            'dependency'    => array('element' => "header_type", 'value' => array('heading_6', 'heading_7'))
        );
    }

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for post title', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_block_title span,{{WRAPPER}} .jeg_block_title strong',
			]
		);
	}
}
