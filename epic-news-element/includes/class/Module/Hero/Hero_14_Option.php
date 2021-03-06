<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Hero;

Class Hero_14_Option extends HeroOptionAbstract
{
    protected $number_post = 8;
    protected $show_style = false;

    public function get_module_name()
    {
        return esc_html__('EPIC - Hero 14', 'epic-ne');
    }

    public function show_color_scheme()
    {
        return true;
    }

    public function set_options()
    {
        $this->set_content_filter_option($this->number_post, true);
        $this->set_style_option();
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
