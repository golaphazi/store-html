<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Module\Archive;

use EPIC\Module\ModuleOptionAbstract;

Class Archive_Hero_Option extends ModuleOptionAbstract {
	public function get_category() {
		return esc_html__( 'EPIC - Archive', 'epic-ne' );
	}

	public function compatible_column() {
		return array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 );
	}

	public function get_module_name() {
		return esc_html__( 'EPIC - Archive Hero', 'epic-ne' );
	}

	public function set_options() {
		$this->set_general_option();
		$this->set_design_option();
		$this->set_overlay_option();
		$this->set_style_option();
	}

	public function set_general_option() {
		$this->options[] = array(
			'type'        => 'radioimage',
			'param_name'  => 'hero_type',
			'std'         => '1',
			'value'       => array(
				EPIC_URL . '/assets/img/admin/hero-type-1.png'    => '1',
				EPIC_URL . '/assets/img/admin/hero-type-2.png'    => '2',
				EPIC_URL . '/assets/img/admin/hero-type-3.png'    => '3',
				EPIC_URL . '/assets/img/admin/hero-type-4.png'    => '4',
				EPIC_URL . '/assets/img/admin/hero-type-5.png'    => '5',
				EPIC_URL . '/assets/img/admin/hero-type-6.png'    => '6',
				EPIC_URL . '/assets/img/admin/hero-type-7.png'    => '7',
				EPIC_URL . '/assets/img/admin/hero-type-8.png'    => '8',
				EPIC_URL . '/assets/img/admin/hero-type-9.png'    => '9',
				EPIC_URL . '/assets/img/admin/hero-type-10.png'   => '10',
				EPIC_URL . '/assets/img/admin/hero-type-11.png'   => '11',
				EPIC_URL . '/assets/img/admin/hero-type-12.png'   => '12',
				EPIC_URL . '/assets/img/admin/hero-type-13.png'   => '13',
				EPIC_URL . '/assets/img/admin/hero-type-skew.png' => 'skew'
			),
			'heading'     => esc_html__( 'Hero Type', 'epic-ne' ),
			'description' => esc_html__( 'Choose which hero type that fit your content design.', 'epic-ne' ),
		);

		$this->options[] = array(
			'type'        => 'radioimage',
			'param_name'  => 'hero_style',
			'std'         => 'jeg_hero_style_1',
			'value'       => array(
				EPIC_URL . '/assets/img/admin/hero-1.png' => 'jeg_hero_style_1',
				EPIC_URL . '/assets/img/admin/hero-2.png' => 'jeg_hero_style_2',
				EPIC_URL . '/assets/img/admin/hero-3.png' => 'jeg_hero_style_3',
				EPIC_URL . '/assets/img/admin/hero-4.png' => 'jeg_hero_style_4',
				EPIC_URL . '/assets/img/admin/hero-5.png' => 'jeg_hero_style_5',
				EPIC_URL . '/assets/img/admin/hero-6.png' => 'jeg_hero_style_6',
				EPIC_URL . '/assets/img/admin/hero-7.png' => 'jeg_hero_style_7',
			),
			'heading'     => esc_html__( 'Hero Style', 'epic-ne' ),
			'description' => esc_html__( 'Choose which hero style that fit your content design.', 'epic-ne' ),
			'dependency'  => array(
				'element' => 'hero_type',
				'value'   => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'skew'
				)
			)
		);

		$this->options[] = array(
			'type'        => 'slider',
			'param_name'  => 'hero_margin',
			'heading'     => esc_html__( 'Hero Margin', 'epic-ne' ),
			'description' => esc_html__( 'Margin of each hero element.', 'epic-ne' ),
			'min'         => 0,
			'max'         => 30,
			'step'        => 1,
			'std'         => 0,
			'dependency'  => array(
				'element' => 'hero_type',
				'value'   => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'skew'
				)
			)
		);

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'date_format',
			'heading'     => esc_html__( 'Choose Date Format', 'epic-ne' ),
			'description' => esc_html__( 'Choose which date format you want to use.', 'epic-ne' ),
			'std'         => 'default',
			'value'       => array(
				esc_html__( 'Relative Date/Time Format (ago)', 'epic-ne' ) => 'ago',
				esc_html__( 'WordPress Default Format', 'epic-ne' )        => 'default',
				esc_html__( 'Custom Format', 'epic-ne' )                   => 'custom',
			),
			'dependency'  => array(
				'element' => 'hero_type',
				'value'   => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'skew'
				)
			)
		);

		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'date_format_custom',
			'heading'     => esc_html__( 'Custom Date Format', 'epic-ne' ),
			'description' => wp_kses( sprintf( __( 'Please write custom date format for your module, for more detail about how to write date format, you can refer to this <a href="%s" target="_blank">link</a>.', 'epic-ne' ), 'https://codex.wordpress.org/Formatting_Date_and_Time' ), wp_kses_allowed_html() ),
			'std'         => 'Y/m/d',
			'dependency'  => array( 'element' => 'date_format', 'value' => array( 'custom' ) )
		);

		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'first_page',
			'heading'     => esc_html__( 'Only First Page', 'epic-ne' ),
			'description' => esc_html__( 'Enable this option if you want to show this hero only on the first page.', 'epic-ne' ),
			'std'         => false
		);
	}

	public function set_design_option() {
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'hero_height_desktop',
			'heading'     => esc_html__( 'Hero Height on Dekstop', 'epic-ne' ),
			'description' => esc_html__( 'Height on pixel / px, leave it empty to use the default number.', 'epic-ne' ),
			'group'       => esc_html__( 'Hero Design', 'epic-ne' ),
			'dependency'  => array(
				'element' => 'hero_type',
				'value'   => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'skew'
				)
			)
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'hero_height_1024',
			'heading'     => esc_html__( 'Hero Height on 1024px Width Screen', 'epic-ne' ),
			'description' => esc_html__( 'Height on pixel / px, leave it empty to use the default number.', 'epic-ne' ),
			'group'       => esc_html__( 'Hero Design', 'epic-ne' ),
			'dependency'  => array(
				'element' => 'hero_type',
				'value'   => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'skew'
				)
			)
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'hero_height_768',
			'heading'     => esc_html__( 'Hero Height on 768px Width Screen', 'epic-ne' ),
			'description' => esc_html__( 'Height on pixel / px, leave it empty to use the default number.', 'epic-ne' ),
			'group'       => esc_html__( 'Hero Design', 'epic-ne' ),
			'dependency'  => array(
				'element' => 'hero_type',
				'value'   => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'skew'
				)
			)
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'hero_height_667',
			'heading'     => esc_html__( 'Hero Height on 667px Width Screen', 'epic-ne' ),
			'description' => esc_html__( 'Height on pixel / px, leave it empty to use the default number.', 'epic-ne' ),
			'group'       => esc_html__( 'Hero Design', 'epic-ne' ),
			'dependency'  => array(
				'element' => 'hero_type',
				'value'   => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'skew'
				)
			)
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'hero_height_568',
			'heading'     => esc_html__( 'Hero Height on 568px Width Screen', 'epic-ne' ),
			'description' => esc_html__( 'Height on pixel / px, leave it empty to use the default number.', 'epic-ne' ),
			'group'       => esc_html__( 'Hero Design', 'epic-ne' ),
			'dependency'  => array(
				'element' => 'hero_type',
				'value'   => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'skew'
				)
			)
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'hero_height_480',
			'heading'     => esc_html__( 'Hero Height on 480px Width Screen', 'epic-ne' ),
			'description' => esc_html__( 'Height on pixel / px, leave it empty to use the default number.', 'epic-ne' ),
			'group'       => esc_html__( 'Hero Design', 'epic-ne' ),
			'dependency'  => array(
				'element' => 'hero_type',
				'value'   => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'skew'
				)
			)
		);
	}

	public function set_overlay_option() {
		for ( $i = 1; $i <= 7; $i ++ ) {
			$dependency = '';

			switch ( $i ) {
				case 1:
					$dependency = array(
						'element' => 'hero_type',
						'value'   => array(
							'1',
							'2',
							'3',
							'4',
							'5',
							'6',
							'7',
							'8',
							'9',
							'10',
							'11',
							'12',
							'13',
							'skew'
						)
					);
					break;

				case 2:
					$dependency = array(
						'element' => 'hero_type',
						'value'   => array(
							'1',
							'2',
							'3',
							'4',
							'5',
							'6',
							'7',
							'8',
							'9',
							'10',
							'11',
							'12',
							'skew'
						)
					);
					break;

				case 3:
					$dependency = array(
						'element' => 'hero_type',
						'value'   => array( '1', '2', '3', '4', '5', '6', '7', '8', '10', '11', '12' )
					);
					break;

				case 4:
					$dependency = array(
						'element' => 'hero_type',
						'value'   => array( '1', '2', '3', '6', '7', '10', '11', '12' )
					);
					break;

				case 5:
					$dependency = array( 'element' => 'hero_type', 'value' => array( '2', '10', '11', '12' ) );
					break;

				case 6:
					$dependency = array( 'element' => 'hero_type', 'value' => array( '10' ) );
					break;

				case 7:
					$dependency = array( 'element' => 'hero_type', 'value' => array( '10' ) );
					break;
			}

			$this->options[] = array(
				'type'        => 'checkbox',
				'param_name'  => 'hero_item_' . $i . '_enable',
				'heading'     => sprintf( esc_html__( 'Override overlay for item %s', 'epic-ne' ), $i ),
				'group'       => esc_html__( 'Hero Style', 'epic-ne' ),
				'description' => esc_html__( 'Override overlay style for this item', 'epic-ne' ),
				'dependency'  => $dependency
			);

			$this->options[] = array(
				'type'       => 'slider',
				'param_name' => 'hero_item_' . $i . '_degree',
				'heading'    => sprintf( esc_html__( 'Hero Item %s : Overlay Gradient Degree', 'epic-ne' ), $i ),
				'group'      => esc_html__( 'Hero Style', 'epic-ne' ),
				'min'        => 0,
				'max'        => 360,
				'step'       => 1,
				'std'        => 0,
				'dependency' => array( 'element' => 'hero_item_' . $i . '_enable', 'value' => 'true' )
			);

			$this->options[] = array(
				'type'       => 'colorpicker',
				'std'        => 'rgba(255,255,255,0.5)',
				'param_name' => 'hero_item_' . $i . '_start_color',
				'group'      => esc_html__( 'Hero Style', 'epic-ne' ),
				'heading'    => sprintf( esc_html__( 'Hero Item %s : Gradient Start Color', 'epic-ne' ), $i ),
				'dependency' => array( 'element' => 'hero_item_' . $i . '_enable', 'value' => 'true' )
			);

			$this->options[] = array(
				'type'       => 'colorpicker',
				'std'        => 'rgba(0,0,0,0.5)',
				'param_name' => 'hero_item_' . $i . '_end_color',
				'group'      => esc_html__( 'Hero Style', 'epic-ne' ),
				'heading'    => sprintf( esc_html__( 'Hero Item %s : Gradient End Color', 'epic-ne' ), $i ),
				'dependency' => array( 'element' => 'hero_item_' . $i . '_enable', 'value' => 'true' )
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
