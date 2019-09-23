<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Archive;

use EPIC\Module\ModuleOptionAbstract;

Class Archive_Pagination_Option extends ModuleOptionAbstract
{
    public function get_category()
    {
        return esc_html__('EPIC - Archive', 'epic-ne');
    }

    public function compatible_column()
    {
        return array( 1,2,3,4,5,6,7,8,9,10,11,12 );
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - Archive Pagination', 'epic-ne');
    }

    public function set_options()
    {
    	$this->set_general_option();
        $this->set_style_option();
    }

	public function set_general_option()
	{
		$this->options[] = array(
			'type'          => 'dropdown',
			'param_name'    => 'pagination_mode',
			'heading'       => esc_html__('Pagination Mode', 'epic-ne'),
			'description'   => esc_html__('Choose which pagination mode that fit with your block.', 'epic-ne'),
			'group'         => esc_html__('Pagination', 'epic-ne'),
			'std'           => 'nav_1',
			'value'         => array(
				esc_html__('Normal - Navigation 1', 'epic-ne') => 'nav_1',
				esc_html__('Normal - Navigation 2', 'epic-ne') => 'nav_2',
				esc_html__('Normal - Navigation 3', 'epic-ne') => 'nav_3',
			)
		);

		$this->options[] = array(
			'type'          => 'dropdown',
			'param_name'    => 'pagination_align',
			'heading'       => esc_html__('Pagination Align', 'epic-ne'),
			'description'   => esc_html__('Choose pagination alignment.', 'epic-ne'),
			'group'         => esc_html__('Pagination', 'epic-ne'),
			'std'           => 'nav_1',
			'value'         => array(
				esc_html__('Left', 'epic-ne') => 'left',
				esc_html__('Center', 'epic-ne') => 'center',
			)
		);

		$this->options[] = array(
			'type'          => 'checkbox',
			'param_name'    => 'pagination_navtext',
			'group'         => esc_html__('Pagination', 'epic-ne'),
			'heading'       => esc_html__('Show Navigation Text', 'epic-ne'),
			'value'         => array( esc_html__("Show navigation text (next, prev).", 'epic-ne') => 'yes' )
		);

		$this->options[] = array(
			'type'          => 'checkbox',
			'param_name'    => 'pagination_pageinfo',
			'group'         => esc_html__('Pagination', 'epic-ne'),
			'heading'       => esc_html__('Show Page Info', 'epic-ne'),
			'value'         => array( esc_html__("Show page info text (Page x of y).", 'epic-ne') => 'yes' ),
		);
	}

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'pagination_typography',
				'label'       => esc_html__( 'Typography', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_pagination *',
			]
		);
	}
}
