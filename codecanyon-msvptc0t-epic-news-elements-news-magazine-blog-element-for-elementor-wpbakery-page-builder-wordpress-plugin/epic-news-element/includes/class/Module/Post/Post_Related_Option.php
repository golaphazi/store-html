<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Post;

use EPIC\Module\ModuleOptionAbstract;

Class Post_Related_Option extends ModuleOptionAbstract
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
        return esc_html__('EPIC - Related Post', 'epic-ne');
    }

    public function set_options()
    {
        $this->set_post_option();
        $this->set_style_option();
    }

    public function set_post_option()
    {
	    $this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'first_title',
		    'heading'       => esc_html__('First Title', 'epic-ne'),
		    'description'   => esc_html__('Insert text for first title.', 'epic-ne'),
		    'std'           => esc_html__( 'Related', 'epic-ne' )
	    );

	    $this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'second_title',
		    'heading'       => esc_html__('Second Title', 'epic-ne'),
		    'description'   => esc_html__('Insert text for second title.', 'epic-ne'),
		    'std'           => esc_html__( ' Posts', 'epic-ne' )
	    );

        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'match',
            'heading'       => esc_html__('Related Post Filter', 'epic-ne'),
            'description'   => esc_html__('Select how related post will filter article.','epic-ne'),
            'std'           => '',
            'value'         => array(
                esc_html__('Category', 'epic-ne') => 'category',
                esc_html__('Tag', 'epic-ne')      => 'tag',
            )
        );

        $this->options[] = array(
            'type'          => 'radioimage',
            'param_name'    => 'header_type',
            'std'           => 'heading_6',
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
            'param_name'    => 'pagination',
            'heading'       => esc_html__('Related Pagination Style', 'epic-ne'),
            'description'   => esc_html__('Adjust how related post will shown.','epic-ne'),
            'std'           => '',
            'value'         => array(
                esc_html__('No Pagination', 'epic-ne')        => 'disable',
                esc_html__('Next Prev', 'epic-ne')            => 'nextprev',
                esc_html__('Load More', 'epic-ne')            => 'loadmore',
                esc_html__('Auto Load on Scroll', 'epic-ne')  => 'scrollload',
            )
        );

        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'number',
            'heading'       => esc_html__('Number of Post', 'epic-ne'),
            'description'   => esc_html__('Set the number of post each related post load.', 'epic-ne'),
            'min'           => 2,
            'max'           => 10,
            'step'          => 1,
            'std'           => 5,
        );

        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'auto_load',
            'heading'       => esc_html__('Auto Load Limit', 'epic-ne'),
            'description'   => esc_html__('Limit of auto load when scrolling, set to zero to always load until end of content.', 'epic-ne'),
            'min'           => 0,
            'max'           => 500,
            'step'          => 1,
            'std'           => 3,
            'dependency'    => array('element' => 'pagination', 'value' => array('nextprev', 'loadmore', 'scrollload'))
        );

        $this->options[] = array(
            'type'          => 'radioimage',
            'param_name'    => 'template',
            'std'           => '9',
            'value'         => array(
                EPIC_URL . '/assets/img/admin/content-1.png' => '1' ,
                EPIC_URL . '/assets/img/admin/content-2.png' => '2' ,
                EPIC_URL . '/assets/img/admin/content-3.png' => '3' ,
                EPIC_URL . '/assets/img/admin/content-4.png' => '4' ,
                EPIC_URL . '/assets/img/admin/content-5.png' => '5' ,
                EPIC_URL . '/assets/img/admin/content-6.png' => '6' ,
                EPIC_URL . '/assets/img/admin/content-7.png' => '7' ,
                EPIC_URL . '/assets/img/admin/content-8.png' => '8' ,
                EPIC_URL . '/assets/img/admin/content-9.png' => '9' ,
                EPIC_URL . '/assets/img/admin/content-10.png' => '10',
                EPIC_URL . '/assets/img/admin/content-11.png' => '11',
                EPIC_URL . '/assets/img/admin/content-12.png' => '12',
                EPIC_URL . '/assets/img/admin/content-13.png' => '13',
                EPIC_URL . '/assets/img/admin/content-14.png' => '14',
                EPIC_URL . '/assets/img/admin/content-15.png' => '15',
                EPIC_URL . '/assets/img/admin/content-16.png' => '16',
                EPIC_URL . '/assets/img/admin/content-17.png' => '17',
                EPIC_URL . '/assets/img/admin/content-18.png' => '18',
                EPIC_URL . '/assets/img/admin/content-19.png' => '19',
                EPIC_URL . '/assets/img/admin/content-20.png' => '20',
                EPIC_URL . '/assets/img/admin/content-21.png' => '21',
                EPIC_URL . '/assets/img/admin/content-22.png' => '22',
                EPIC_URL . '/assets/img/admin/content-23.png' => '23',
                EPIC_URL . '/assets/img/admin/content-24.png' => '24',
                EPIC_URL . '/assets/img/admin/content-25.png' => '25',
                EPIC_URL . '/assets/img/admin/content-26.png' => '26',
                EPIC_URL . '/assets/img/admin/content-27.png' => '27',
            ),
            'heading'       => esc_html__('Related PostTemplate', 'epic-ne'),
            'description'   => esc_html__('Choose your related post template.', 'epic-ne'),
        );

        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'excerpt',
            'heading'       => esc_html__('Excerpt Length', 'epic-ne'),
            'description'   => esc_html__('Set word length of excerpt on related post.', 'epic-ne'),
            'min'           => 0,
            'max'           => 200,
            'step'          => 1,
            'std'           => 20,
        );

        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'date',
            'heading'       => esc_html__('Related Post Date Format', 'epic-ne'),
            'description'   => esc_html__('Choose which date format you want to use for archive content.','epic-ne'),
            'std'           => 'default',
            'value'         => array(
                 esc_attr__( 'Relative Date/Time Format (ago)', 'epic-ne' ) => 'ago',
                 esc_attr__( 'WordPress Default Format', 'epic-ne' ) => 'default',
                 esc_attr__( 'Custom Format', 'epic-ne' ) => 'custom',
            )
        );

        $this->options[] = array(
            'type'          => 'textfield',
            'param_name'    => 'date_custom',
            'heading'       => esc_html__('Custom Date Format for Related Post', 'epic-ne'),
            'description'   => wp_kses(sprintf(__("Please set your date format for related post content, for more detail about this format, please refer to
                        <a href='%s' target='_blank'>Developer Codex</a>.", 'epic-ne'), "https://developer.wordpress.org/reference/functions/current_time/"),
                wp_kses_allowed_html()),
            'std'       => 'Y/m/d',
        );
    }

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'epic-ne' ),
				'description' => esc_html__( 'Set typography for post title', 'epic-ne' ),
				'selector'    => '{{WRAPPER}} .jeg_post_title > a,{{WRAPPER}} .jeg_block_title',
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
