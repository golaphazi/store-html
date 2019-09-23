<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_29_Option extends BlockOptionAbstract
{
    protected $default_number_post = 6;
    protected $show_excerpt = false;
    protected $show_ads = true;
    protected $default_ajax_post = 4;

    public function compatible_column()
    {
        return array( 2, 3, 4, 5, 6, 7, 8 , 9, 10, 11, 12 );
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - Module 29', 'epic-ne');
    }

    public function set_style_option()
    {
        $this->options[] = array(
            'type'          => 'checkbox',
            'heading'       => esc_html__('Show bottom border line for each article', 'epic-ne'),
            'param_name'    => 'show_border',
            'group'         => esc_html__('Design', 'epic-ne'),
        );

        parent::set_style_option();
    }

    public function set_content_setting_option($show_excerpt = false)
    {
        $this->options[] = array(
            'type'          => 'checkbox',
            'heading'       => esc_html__('Tick to show date', 'epic-ne'),
            'param_name'    => 'show_date',
            'group'         => esc_html__('Content Setting', 'epic-ne'),
            'value'         => array( esc_html__("Show Date", 'epic-ne') => 'yes' ),
        );

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
        }
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
	}
}
