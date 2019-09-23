<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Hero;

use EPIC\Module\ModuleOptionAbstract;

abstract Class HeroOptionAbstract extends ModuleOptionAbstract
{
    protected $number_post = 0;
    protected $margin = 0;
    protected $show_style = true;

    public function get_number_post()
    {
        return $this->number_post;
    }

	public function get_category()
	{
		return esc_html__('EPIC - Hero', 'epic-ne');
	}

    public function compatible_column()
    {
        return array( 12 );
    }

    public function show_color_scheme()
    {
        return false;
    }

    public function set_options()
    {
        $this->set_hero_option();
        $this->set_content_filter_option($this->number_post, true);
        if($this->show_style) {
            $this->set_hero_design_option();
	        $this->set_hero_overlay_option();
            $this->set_hero_slider_option();
        }
        $this->set_style_option();
    }

    public function set_hero_overlay_option()
    {
        for($i = 1; $i <= $this->number_post; $i++)
        {
            $this->options[] = array(
                'type'          => 'checkbox',
                'param_name'    => 'hero_item_' . $i . '_enable',
                'heading'       => sprintf(esc_html__('Override overlay for item %s', 'epic-ne'), $i),
                'group'         => esc_html__('Hero Style', 'epic-ne'),
                'description'   => esc_html__('Override overlay style for this item', 'epic-ne'),
            );

            $this->options[] = array(
                'type'          => 'slider',
                'param_name'    => 'hero_item_' . $i . '_degree',
                'heading'       => sprintf(esc_html__('Hero Item %s : Overlay Gradient Degree', 'epic-ne'), $i),
                'group'         => esc_html__('Hero Style', 'epic-ne'),
                'min'           => 0,
                'max'           => 360,
                'step'          => 1,
                'std'           => 0,
                'dependency'    => array('element' => 'hero_item_' . $i . '_enable', 'value' => 'true')
            );

            $this->options[] = array(
                'type'          => 'colorpicker',
                'std'           => 'rgba(255,255,255,0.5)',
                'param_name'    => 'hero_item_' . $i . '_start_color',
                'group'         => esc_html__('Hero Style', 'epic-ne'),
                'heading'       => sprintf(esc_html__('Hero Item %s : Gradient Start Color', 'epic-ne'), $i),
                'dependency'    => array('element' => 'hero_item_' . $i . '_enable', 'value' => 'true')
            );

            $this->options[] = array(
                'type'          => 'colorpicker',
                'std'           => 'rgba(0,0,0,0.5)',
                'param_name'    => 'hero_item_' . $i . '_end_color',
                'group'         => esc_html__('Hero Style', 'epic-ne'),
                'heading'       => sprintf(esc_html__('Hero Item %s : Gradient End Color', 'epic-ne'), $i),
                'dependency'    => array('element' => 'hero_item_' . $i . '_enable', 'value' => 'true')
            );
        }
    }

    public function set_hero_design_option()
    {
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'hero_height_desktop',
            'heading'       => esc_html__('Hero Height on Dekstop', 'epic-ne'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'epic-ne'),
            'group'         => esc_html__('Hero Design', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'hero_height_1024',
            'heading'       => esc_html__('Hero Height on 1024px Width Screen', 'epic-ne'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'epic-ne'),
            'group'         => esc_html__('Hero Design', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'hero_height_768',
            'heading'       => esc_html__('Hero Height on 768px Width Screen', 'epic-ne'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'epic-ne'),
            'group'         => esc_html__('Hero Design', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'hero_height_667',
            'heading'       => esc_html__('Hero Height on 667px Width Screen', 'epic-ne'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'epic-ne'),
            'group'         => esc_html__('Hero Design', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'hero_height_568',
            'heading'       => esc_html__('Hero Height on 568px Width Screen', 'epic-ne'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'epic-ne'),
            'group'         => esc_html__('Hero Design', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'hero_height_480',
            'heading'       => esc_html__('Hero Height on 480px Width Screen', 'epic-ne'),
            'description'   => esc_html__('Height on pixel / px, leave it empty to use the default number.', 'epic-ne'),
            'group'         => esc_html__('Hero Design', 'epic-ne'),
        );
    }

    public function set_hero_option()
    {
        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'hero_margin',
            'heading'       => esc_html__('Hero Margin', 'epic-ne'),
            'description'   => esc_html__('Margin of each hero element.', 'epic-ne'),
            'group'         => esc_html__('Hero Setting', 'epic-ne'),
            'min'           => 0,
            'max'           => 30,
            'step'          => 1,
            'std'           => 0,
        );
        $this->options[] = array(
            'type'          => 'radioimage',
            'param_name'    => 'hero_style',
            'std'           => 'jeg_hero_style_1',
            'value'         => array(
                EPIC_URL . '/assets/img/admin/hero-1.png'  => 'jeg_hero_style_1',
                EPIC_URL . '/assets/img/admin/hero-2.png'  => 'jeg_hero_style_2',
                EPIC_URL . '/assets/img/admin/hero-3.png'  => 'jeg_hero_style_3',
                EPIC_URL . '/assets/img/admin/hero-4.png'  => 'jeg_hero_style_4',
                EPIC_URL . '/assets/img/admin/hero-5.png'  => 'jeg_hero_style_5',
                EPIC_URL . '/assets/img/admin/hero-6.png'  => 'jeg_hero_style_6',
                EPIC_URL . '/assets/img/admin/hero-7.png'  => 'jeg_hero_style_7',
            ),
            'heading'       => esc_html__('Hero Style', 'epic-ne'),
            'description'   => esc_html__('Choose which hero style that fit your content design.', 'epic-ne'),
            'group'         => esc_html__('Hero Setting', 'epic-ne'),
        );
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'date_format',
            'heading'       => esc_html__('Choose Date Format', 'epic-ne'),
            'description'   => esc_html__('Choose which date format you want to use.', 'epic-ne'),
            'std'           => 'default',
            'group'         => esc_html__('Hero Setting', 'epic-ne'),
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
            'std'           => 'Y/m/d',
            'group'         => esc_html__('Hero Setting', 'epic-ne'),
            'dependency'    => array('element' => 'date_format', 'value' => array('custom'))
        );
    }

	public function set_hero_slider_option()
	{
		$this->options[] = array(
			'type'          => 'checkbox',
			'param_name'    => 'hero_slider_enable',
			'heading'       => esc_html__('Hero Slider', 'epic-ne'),
			'description'   => esc_html__('Enable hero slider.', 'epic-ne'),
			'group'         => esc_html__('Hero Slider', 'epic-ne'),
		);

		$this->options[] = array(
			'type'          => 'checkbox',
			'param_name'    => 'hero_slider_auto_play',
			'heading'       => esc_html__('Slider Autoplay', 'epic-ne'),
			'description'   => esc_html__('Enable autoplay hero slider.', 'epic-ne'),
			'group'         => esc_html__('Hero Slider', 'epic-ne'),
			'dependency'    => array('element' => 'hero_slider_enable', 'value' => 'true')
		);

		$this->options[] = array(
			'type'          => 'slider',
			'param_name'    => 'hero_slider_delay',
			'heading'       => esc_html__('Autoplay Delay', 'epic-ne'),
			'description'   => esc_html__('Set your autoplay delay (in millisecond).', 'epic-ne'),
			'min'           => 1000,
			'max'           => 10000,
			'step'          => 500,
			'std'           => 3000,
			'group'         => esc_html__('Hero Slider', 'epic-ne'),
			'dependency'    => array('element' => 'hero_slider_auto_play', 'value' => 'true')
		);

		$this->options[] = array(
			'type'          => 'slider',
			'param_name'    => 'hero_slider_item',
			'heading'       => esc_html__('Slider Item', 'epic-ne'),
			'description'   => esc_html__('Set number of items of hero slider.', 'epic-ne'),
			'group'         => esc_html__('Hero Slider', 'epic-ne'),
			'min'           => 1,
			'max'           => 10,
			'step'          => 1,
			'std'           => 3,
			'dependency'    => array('element' => 'hero_slider_enable', 'value' => 'true')
		);
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
