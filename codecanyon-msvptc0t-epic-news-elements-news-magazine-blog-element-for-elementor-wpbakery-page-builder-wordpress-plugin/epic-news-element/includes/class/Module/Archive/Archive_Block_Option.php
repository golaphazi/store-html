<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Archive;

use EPIC\Module\ModuleOptionAbstract;

Class Archive_Block_Option extends ModuleOptionAbstract
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
        return esc_html__('EPIC - Archive Block', 'epic-ne');
    }

    public function set_options()
    {
    	$this->set_general_option();
//	    $this->set_pagination_option();
        $this->set_style_option();
    }

    public function set_pagination_option() {
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
//			    esc_html__('Ajax - Next Prev', 'epic-ne') => 'nextprev',
//			    esc_html__('Ajax - Load More', 'epic-ne') => 'loadmore',
//			    esc_html__('Ajax - Auto Scroll Load', 'epic-ne') => 'scrollload',
		    )
	    );

	    $this->options[] = array(
		    'type'          => 'slider',
		    'param_name'    => 'pagination_scroll_limit',
		    'group'         => esc_html__('Pagination', 'epic-ne'),
		    'heading'       => esc_html__('Auto Load Limit', 'epic-ne'),
		    'description'   => esc_html__('Limit of auto load when scrolling, set to zero to always load until end of content.', 'epic-ne'),
		    'min'           => 0,
		    'max'           => 99999,
		    'step'          => 1,
		    'std'           => 0,
		    'dependency'    => array( 'element' => 'pagination_mode', 'value' => array( 'scrollload' ) )
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
		    ),
		    'dependency'    => array( 'element' => 'pagination_mode', 'value' => array( 'nav_1', 'nav_2', 'nav_3' ) )
	    );

	    $this->options[] = array(
		    'type'          => 'checkbox',
		    'param_name'    => 'pagination_navtext',
		    'group'         => esc_html__('Pagination', 'epic-ne'),
		    'heading'       => esc_html__('Show Navigation Text', 'epic-ne'),
		    'value'         => array( esc_html__("Show navigation text (next, prev).", 'epic-ne') => 'yes' ),
		    'dependency'    => array( 'element' => 'pagination_mode', 'value' => array( 'nav_1', 'nav_2', 'nav_3' ) )
	    );

	    $this->options[] = array(
		    'type'          => 'checkbox',
		    'param_name'    => 'pagination_pageinfo',
		    'group'         => esc_html__('Pagination', 'epic-ne'),
		    'heading'       => esc_html__('Show Page Info', 'epic-ne'),
		    'value'         => array( esc_html__("Show page info text (Page x of y).", 'epic-ne') => 'yes' ),
		    'dependency'    => array( 'element' => 'pagination_mode', 'value' => array( 'nav_1', 'nav_2', 'nav_3' ) )
	    );
    }

	public function set_general_option()
	{
		$this->options[] = array(
			'type'          => 'radioimage',
			'param_name'    => 'block_type',
			'std'           => '3',
			'value'         => array(
				EPIC_URL . '/assets/img/admin/content-3.png'  => '3',
				EPIC_URL . '/assets/img/admin/content-4.png'  => '4',
				EPIC_URL . '/assets/img/admin/content-5.png'  => '5',
				EPIC_URL . '/assets/img/admin/content-6.png'  => '6',
				EPIC_URL . '/assets/img/admin/content-7.png'  => '7',
				EPIC_URL . '/assets/img/admin/content-9.png'  => '9',
				EPIC_URL . '/assets/img/admin/content-10.png'  => '10',
				EPIC_URL . '/assets/img/admin/content-11.png'  => '11',
				EPIC_URL . '/assets/img/admin/content-12.png'  => '12',
				EPIC_URL . '/assets/img/admin/content-14.png'  => '14',
				EPIC_URL . '/assets/img/admin/content-15.png'  => '15',
				EPIC_URL . '/assets/img/admin/content-18.png'  => '18',
				EPIC_URL . '/assets/img/admin/content-22.png'  => '22',
				EPIC_URL . '/assets/img/admin/content-23.png'  => '23',
				EPIC_URL . '/assets/img/admin/content-25.png'  => '25',
				EPIC_URL . '/assets/img/admin/content-26.png'  => '26',
				EPIC_URL . '/assets/img/admin/content-27.png'  => '27',
				EPIC_URL . '/assets/img/admin/content-32.png'  => '32',
				EPIC_URL . '/assets/img/admin/content-33.png'  => '33',
				EPIC_URL . '/assets/img/admin/content-34.png'  => '34',
				EPIC_URL . '/assets/img/admin/content-35.png'  => '35',
				EPIC_URL . '/assets/img/admin/content-36.png'  => '36',
				EPIC_URL . '/assets/img/admin/content-37.png'  => '37'
			),
			'heading'       => esc_html__('Block Type', 'epic-ne'),
			'description'   => esc_html__('Choose which block type that fit your content design.', 'epic-ne'),
		);

		$this->options[] = array(
			'type'          => 'slider',
			'param_name'    => 'number_post',
			'heading'       => esc_html__('Number of post', 'epic-ne'),
			'description'   => esc_html__('Set number of post for this block.', 'epic-ne'),
			'min'           => 1,
			'max'           => 100,
			'step'          => 1,
			'std'           => 5
		);

		$this->options[] = array(
			'type'          => 'checkbox',
			'param_name'    => 'boxed',
			'heading'       => esc_html__('Enable Boxed', 'epic-ne'),
			'value'         => array( esc_html__("This option will turn the module into boxed.", 'epic-ne') => 'yes' ),
			'dependency'    => array( 'element' => 'block_type', 'value' => array( '3', '4', '5', '6', '7', '9', '10', '14', '18', '22', '23', '25', '26', '27' ) )
		);

		$this->options[] = array(
			'type'          => 'checkbox',
			'param_name'    => 'boxed_shadow',
			'heading'       => esc_html__('Enable Shadow', 'epic-ne'),
			'description'   => esc_html__('Enable excerpt ellipsis', 'epic-ne'),
			'dependency'    => array('element' => "boxed", 'value' => 'yes')
		);

		$this->options[] = array(
			'type'          => 'slider',
			'param_name'    => 'excerpt_length',
			'heading'       => esc_html__('Excerpt Length', 'epic-ne'),
			'description'   => esc_html__('Set word length of excerpt on post block.', 'epic-ne'),
			'min'           => 0,
			'max'           => 200,
			'step'          => 1,
			'std'           => 20,
			'dependency'    => array( 'element' => 'block_type', 'value' => array( '3', '4', '5', '6', '7', '10', '12', '23', '25', '26', '27', '32', '33', '35', '36' ) )
		);

		$this->options[] = array(
			'type'          => 'textfield',
			'param_name'    => 'excerpt_ellipsis',
			'heading'       => esc_html__('Excerpt Ellipsis', 'epic-ne'),
			'description'   => esc_html__('Define excerpt ellipsis', 'epic-ne'),
			'std'           => '...',
			'dependency'    => array( 'element' => 'block_type', 'value' => array( '3', '4', '5', '6', '7', '10', '12', '23', '25', '26', '27', '32', '33', '35', '36' ) )
		);

		$this->options[] = array(
			'type'          => 'dropdown',
			'param_name'    => 'date_format',
			'heading'       => esc_html__('Content Date Format', 'epic-ne'),
			'description'   => esc_html__('Choose which date format you want to use.', 'epic-ne'),
			'std'           => 'default',
			'value'         => array(
				esc_html__('Relative Date/Time Format (ago)', 'epic-ne') => 'ago',
				esc_html__('WordPress Default Format', 'epic-ne')        => 'default',
				esc_html__('Custom Format', 'epic-ne')                   => 'custom',
			),
			'dependency'    => array( 'element' => 'block_type', 'value' => array( '3', '4', '5', '6', '7', '10', '12', '23', '25', '26', '27', '32', '33', '35', '36' ) )
		);

		$this->options[] = array(
			'type'          => 'textfield',
			'param_name'    => 'date_format_custom',
			'heading'       => esc_html__('Custom Date Format', 'epic-ne'),
			'description'   => wp_kses(sprintf(__('Please write custom date format for your module, for more detail about how to write date format, you can refer to this <a href="%s" target="_blank">link</a>.', 'epic-ne'), 'https://codex.wordpress.org/Formatting_Date_and_Time'), wp_kses_allowed_html()),
			'std'           => 'Y/m/d',
			'dependency'    => array('element' => 'date_format', 'value' => array('custom')),
		);

		$this->options[] = array(
			'type'          => 'checkbox',
			'param_name'    => 'first_page',
			'heading'       => esc_html__('Only First Page', 'epic-ne'),
			'description'   => esc_html__('Enable this option if you want to show this block only on the first page.', 'epic-ne'),
			'std'           => false
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
