<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Post;

use EPIC\Module\ModuleOptionAbstract;

Class Post_Author_Option extends ModuleOptionAbstract
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
        return esc_html__('EPIC - Post Author Box', 'epic-ne');
    }

    public function set_options()
    {
        $this->set_style_option();
    }

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'author_typography',
				'label'       => esc_html__( 'Typography', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_authorbox *',
			]
		);
	}
}
