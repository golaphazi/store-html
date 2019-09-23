<?php

$options = array();

$options[] = array(
    'id'            => 'epic-ne[single_post_template]',
    'option_type'   => 'option',
    'transport'     => 'postMessage',
    'default'       => false,
    'type'          => 'jeg-toggle',
    'label'         => esc_html__('Single Post Template', 'epic-ne'),
    'description'   => esc_html__('Enable custom single post template.','epic-ne'),
);

$options[] = array(
	'id'            => 'epic-ne[single_post_template_id]',
	'option_type'   => 'option',
	'transport'     => 'refresh',
	'default'       => '',
	'type'          => 'jeg-select',
	'label'         => esc_html__('Single Post Template List','epic-ne'),
	'description'   => wp_kses(sprintf(__('Create custom single post template from <a href="%s" target="_blank">here</a>','epic-ne'), get_admin_url() . 'edit.php?post_type=custom-post-template'), wp_kses_allowed_html()),
	'multiple'      => 1,
	'choices'       => call_user_func(function(){
		$post = get_posts(array(
			'posts_per_page'   => -1,
			'post_type'        => 'custom-post-template',
		));

		$template = array();
		$template[] = esc_html__('Choose Custom Template', 'epic-ne');

		if($post) {
			foreach($post as $value) {
				$template[$value->ID] = $value->post_title;
			}
		}

		return $template;
	}),
	'active_callback'  => array(
		array(
			'setting'  => 'epic-ne[single_post_template]',
			'operator' => '==',
			'value'    => true,
		)
	),
	'postvar'       => array(
		array(
			'redirect'  => 'single_post_tag',
			'refresh'   => true
		)
	),
);

//$options[] = array(
//	'id'            => 'epic-ne[single_post_template_laptop_container]',
//	'option_type'   => 'option',
//	'transport'     => 'postMessage',
//	'default'       => '1170',
//	'type'          => 'jeg-range-slider',
//	'label'         => esc_html__('[ Laptop ] Container Width ', 'epic-ne'),
//	'description'   => esc_html__('Content width on Laptop ( width less than 1440px )', 'epic-ne'),
//	'choices'     => array(
//		'min'       => '1170',
//		'max'       => '1370',
//		'step'      => '1',
//	),
//	'active_callback'  => array(
//		array(
//			'setting'  => 'epic-ne[single_post_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'postvar'       => array(
//		array(
//			'redirect'  => 'single_post_tag',
//			'refresh'   => true
//		)
//	),
//	'output'     => array(
//		array(
//			'mediaquery'    => '@media only screen and (min-width : 1200px)',
//			'method'        => 'inject-style',
//			'element'       => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'      => 'width',
//			'units'         => 'px',
//		),
//		array(
//			'mediaquery'    => '@media only screen and (min-width : 1200px)',
//			'method'        => 'inject-style',
//			'element'       => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'      => 'max-width',
//			'units'         => 'px',
//		)
//	)
//);
//
//$options[] = array(
//	'id'            => 'epic-ne[single_post_template_dekstop_container]',
//	'option_type'   => 'option',
//	'transport'     => 'postMessage',
//	'default'       => '1170',
//	'type'          => 'jeg-range-slider',
//	'label'         => esc_html__('[ Desktop ] Content Width', 'epic-ne'),
//	'description'   => esc_html__('Content width on Desktop ( width more than 1440px )', 'epic-ne'),
//	'choices'     => array(
//		'min'       => '1170',
//		'max'       => '1400',
//		'step'      => '1',
//	),
//	'active_callback'  => array(
//		array(
//			'setting'  => 'epic-ne[single_post_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'postvar'       => array(
//		array(
//			'redirect'  => 'single_post_tag',
//			'refresh'   => true
//		)
//	),
//	'output'     => array(
//		array(
//			'mediaquery'    => '@media only screen and (min-width : 1441px)',
//			'method'        => 'inject-style',
//			'element'       => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'      => 'width',
//			'units'         => 'px',
//		),
//		array(
//			'mediaquery'    => '@media only screen and (min-width : 1441px)',
//			'method'        => 'inject-style',
//			'element'       => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'      => 'max-width',
//			'units'         => 'px',
//		)
//	)
//);

return $options;
