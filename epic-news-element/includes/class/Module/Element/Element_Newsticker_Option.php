<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Element;

use EPIC\Module\ModuleOptionAbstract;

Class Element_Newsticker_Option extends ModuleOptionAbstract
{
    public function compatible_column()
    {
        return array( 6 , 7 , 8 , 9 , 10 , 11 , 12 );
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - News Ticker', 'epic-ne');
    }

    public function get_category()
    {
	    return esc_html__('EPIC - Element', 'epic-ne');
    }

	public function set_options()
    {
        $this->set_newsticker_option();
        $this->set_content_filter_option(5);
        $this->set_style_option();
    }

    public function set_newsticker_option()
    {
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'newsticker_title',
            'heading'       => esc_html__('News Ticker Title', 'epic-ne'),
            'description'   => esc_html__('Title of news ticker.', 'epic-ne'),
            'std'           => esc_html__('TRENDING', 'epic-ne')
        );

        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'date_format',
            'heading'       => esc_html__('Choose Date Format', 'epic-ne'),
            'description'   => esc_html__('Choose which date format you want to use.', 'epic-ne'),
            'std'           => 'default',
            'value'         => array(
                esc_html__('Relative Date/Time Format (ago)', 'epic-ne')  => 'ago',
                esc_html__('WordPress Default Format', 'epic-ne')         => 'default',
                esc_html__('Custom Format', 'epic-ne')                    => 'custom',
            )
        );

        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'date_format_custom',
            'heading'       => esc_html__('Custom Date Format', 'epic-ne'),
            'description'   => wp_kses(sprintf(__('Please write custom date format for your module, for more detail about how to write date format, you can refer to this <a href="%s" target="_blank">link</a>.', 'epic-ne'), 'https://codex.wordpress.org/Formatting_Date_and_Time'), wp_kses_allowed_html()),
            'std'           => 'Y/m/d',
            'dependency'    => array('element' => 'date_format', 'value' => array('custom'))
        );

        $this->options[] = array(
            'type'          => 'iconpicker',
            'param_name'    => 'newsticker_icon',
            'heading'       => esc_html__('News ticker icon', 'epic-ne'),
            'description'   => esc_html__('Choose which font icon that best to describe your news ticker.', 'epic-ne'),
            'std'         => 'fa fa-bolt',
            'settings'      => array(
                'emptyIcon'     => false,
                'iconsPerPage'  => 100,
            )
        );

        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'enable_autoplay',
            'heading'       => esc_html__('Enable Autoplay', 'epic-ne'),
            'description'   => esc_html__('Check this option to enable auto play.', 'epic-ne'),
        );

        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'autoplay_delay',
            'heading'       => esc_html__('Autoplay Delay', 'epic-ne'),
            'description'   => esc_html__('Set your autoplay delay (in millisecond).', 'epic-ne'),
            'min'           => 1000,
            'max'           => 10000,
            'step'          => 500,
            'std'           => 3000,
            'dependency'    => array('element' => 'enable_autoplay', 'value' => 'true')
        );

        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'newsticker_animation',
            'heading'       => esc_html__('Animation Direction', 'epic-ne'),
            'description'   => esc_html__('Choose news ticker animation direction.', 'epic-ne'),
            'std'           => 'horizontal',
            'value'         => array(
                esc_html__('Vertical', 'epic-ne')          => 'vertical',
                esc_html__('Horizontal', 'epic-ne')        => 'horizontal',
            ),
        );

        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'newsticker_background',
            'heading'       => esc_html__('News Ticker Title Background', 'epic-ne'),
            'description'   => esc_html__('Choose news ticker title background. If you leave it empty, you will use default theme scheme color.', 'epic-ne'),
        );

        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'newsticker_text_color',
            'heading'       => esc_html__('News Ticker Text Color', 'epic-ne'),
            'description'   => esc_html__('Choose news ticker title text color. If you leave it empty, you will use default theme scheme color.', 'epic-ne'),
        );
    }

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for title', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_news_ticker_item a,{{WRAPPER}} .jeg_breakingnews_title span',
			]
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'meta_typography',
				'label'       => esc_html__( 'Meta Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for post meta', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_news_ticker_item .post-date',
			]
		);
	}
}
