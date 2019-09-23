<?php

$options = array();

/**
 * Category
 */
$options[] = array(
	'id'    => 'epic-ne[single_category_template_header]',
	'type'  => 'jeg-header',
	'label' => esc_html__( 'Category Archive Template', 'epic-ne' ),
);

$options[] = array(
	'id'          => 'epic-ne[single_category_template]',
	'option_type' => 'option',
	'transport'   => 'postMessage',
	'default'     => false,
	'type'        => 'jeg-toggle',
	'label'       => esc_html__( 'Category Archive Template', 'epic-ne' ),
	'description' => esc_html__( 'Enable custom category archive template.', 'epic-ne' ),
	'postvar'     => array(
		array(
			'redirect' => 'category_tag',
			'refresh'  => true
		)
	)
);

$options[] = array(
	'id'              => 'epic-ne[single_category_template_id]',
	'option_type'     => 'option',
	'transport'       => 'refresh',
	'default'         => '',
	'type'            => 'jeg-select',
	'label'           => esc_html__( 'Category Archive Template List', 'epic-ne' ),
	'description'     => wp_kses( sprintf( __( 'Create custom category template from <a href="%s" target="_blank">here</a>', 'epic-ne' ), get_admin_url() . 'edit.php?post_type=archive-template' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => epic_get_all_custom_archive_template(),
	'active_callback' => array(
		array(
			'setting'  => 'epic-ne[single_category_template]',
			'operator' => '==',
			'value'    => true,
		)
	),
	'postvar'         => array(
		array(
			'redirect' => 'category_tag',
			'refresh'  => true
		)
	),
);

$options[] = array(
	'id'              => 'epic-ne[single_category_template_number_post]',
	'option_type'     => 'option',
	'transport'       => 'refresh',
	'default'         => 10,
	'type'            => 'jeg-text',
	'label'           => esc_html__( 'Number of Post', 'epic-ne' ),
	'description'     => esc_html__( 'Set the number of post per page on category page.', 'epic-ne' ),
	'active_callback' => array(
		array(
			'setting'  => 'epic-ne[single_category_template]',
			'operator' => '==',
			'value'    => true,
		)
	),
	'postvar'         => array(
		array(
			'redirect' => 'category_tag',
			'refresh'  => true
		)
	)
);

//$options[] = array(
//	'id'              => 'epic-ne[single_category_template_laptop_container]',
//	'option_type'     => 'option',
//	'transport'       => 'postMessage',
//	'default'         => '1170',
//	'type'            => 'jeg-range-slider',
//	'label'           => esc_html__( '[ Laptop ] Container Width ', 'epic-ne' ),
//	'description'     => esc_html__( 'Content width on Laptop ( width less than 1440px )', 'epic-ne' ),
//	'choices'         => array(
//		'min'  => '1170',
//		'max'  => '1370',
//		'step' => '1',
//	),
//	'active_callback' => array(
//		array(
//			'setting'  => 'epic-ne[single_category_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'postvar'         => array(
//		array(
//			'redirect' => 'category_tag',
//			'refresh'  => true
//		)
//	),
//	'output'          => array(
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1200px)',
//			'method'     => 'inject-style',
//			'element'    => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'   => 'width',
//			'units'      => 'px',
//		),
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1200px)',
//			'method'     => 'inject-style',
//			'element'    => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'   => 'max-width',
//			'units'      => 'px',
//		)
//	)
//);

//$options[] = array(
//	'id'              => 'epic-ne[single_category_template_desktop_container]',
//	'option_type'     => 'option',
//	'transport'       => 'postMessage',
//	'default'         => '1170',
//	'type'            => 'jeg-range-slider',
//	'label'           => esc_html__( '[ Desktop ] Content Width', 'epic-ne' ),
//	'description'     => esc_html__( 'Content width on Desktop ( width more than 1440px )', 'epic-ne' ),
//	'choices'         => array(
//		'min'  => '1170',
//		'max'  => '1400',
//		'step' => '1',
//	),
//	'active_callback' => array(
//		array(
//			'setting'  => 'epic-ne[single_category_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'postvar'         => array(
//		array(
//			'redirect' => 'category_tag',
//			'refresh'  => true
//		)
//	),
//	'output'          => array(
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1441px)',
//			'method'     => 'inject-style',
//			'element'    => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'   => 'width',
//			'units'      => 'px',
//		),
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1441px)',
//			'method'     => 'inject-style',
//			'element'    => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'   => 'max-width',
//			'units'      => 'px',
//		)
//	)
//);

/**
 * Tag
 */
$options[] = array(
	'id'    => 'epic-ne[single_tag_template_header]',
	'type'  => 'jeg-header',
	'label' => esc_html__( 'Tag Archive Template', 'epic-ne' ),
);

$options[] = array(
	'id'          => 'epic-ne[single_tag_template]',
	'option_type' => 'option',
	'transport'   => 'postMessage',
	'default'     => false,
	'type'        => 'jeg-toggle',
	'label'       => esc_html__( 'Tag Archive Template', 'epic-ne' ),
	'description' => esc_html__( 'Enable custom tag archive template.', 'epic-ne' ),
	'postvar'     => array(
		array(
			'redirect' => 'single_post_tag',
			'refresh'  => true
		)
	)
);

$options[] = array(
	'id'              => 'epic-ne[single_tag_template_id]',
	'option_type'     => 'option',
	'transport'       => 'refresh',
	'default'         => '',
	'type'            => 'jeg-select',
	'label'           => esc_html__( 'Tag Archive Template List', 'epic-ne' ),
	'description'     => wp_kses( sprintf( __( 'Create custom category template from <a href="%s" target="_blank">here</a>', 'epic-ne' ), get_admin_url() . 'edit.php?post_type=archive-template' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => epic_get_all_custom_archive_template(),
	'active_callback' => array(
		array(
			'setting'  => 'epic-ne[single_tag_template]',
			'operator' => '==',
			'value'    => true,
		)
	),
	'postvar'         => array(
		array(
			'redirect' => 'single_post_tag',
			'refresh'  => true
		)
	),
);

$options[] = array(
	'id'              => 'epic-ne[single_tag_template_number_post]',
	'option_type'     => 'option',
	'transport'       => 'refresh',
	'default'         => 10,
	'type'            => 'jeg-text',
	'label'           => esc_html__( 'Number of Post', 'epic-ne' ),
	'description'     => esc_html__( 'Set the number of post per page on tag archive page.', 'epic-ne' ),
	'active_callback' => array(
		array(
			'setting'  => 'epic-ne[single_tag_template]',
			'operator' => '==',
			'value'    => true,
		)
	),
	'postvar'         => array(
		array(
			'redirect' => 'single_post_tag',
			'refresh'  => true
		)
	)
);

//$options[] = array(
//	'id'              => 'epic-ne[single_tag_template_laptop_container]',
//	'option_type'     => 'option',
//	'transport'       => 'postMessage',
//	'default'         => '1170',
//	'type'            => 'jeg-range-slider',
//	'label'           => esc_html__( '[ Laptop ] Container Width ', 'epic-ne' ),
//	'description'     => esc_html__( 'Content width on Laptop ( width less than 1440px )', 'epic-ne' ),
//	'choices'         => array(
//		'min'  => '1170',
//		'max'  => '1370',
//		'step' => '1',
//	),
//	'active_callback' => array(
//		array(
//			'setting'  => 'epic-ne[single_tag_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'postvar'         => array(
//		array(
//			'redirect' => 'single_post_tag',
//			'refresh'  => true
//		)
//	),
//	'output'          => array(
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1200px)',
//			'method'     => 'inject-style',
//			'element'    => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'   => 'width',
//			'units'      => 'px',
//		),
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1200px)',
//			'method'     => 'inject-style',
//			'element'    => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'   => 'max-width',
//			'units'      => 'px',
//		)
//	)
//);
//
//$options[] = array(
//	'id'              => 'epic-ne[single_tag_template_desktop_container]',
//	'option_type'     => 'option',
//	'transport'       => 'postMessage',
//	'default'         => '1170',
//	'type'            => 'jeg-range-slider',
//	'label'           => esc_html__( '[ Desktop ] Content Width', 'epic-ne' ),
//	'description'     => esc_html__( 'Content width on Desktop ( width more than 1440px )', 'epic-ne' ),
//	'choices'         => array(
//		'min'  => '1170',
//		'max'  => '1400',
//		'step' => '1',
//	),
//	'active_callback' => array(
//		array(
//			'setting'  => 'epic-ne[single_tag_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'postvar'         => array(
//		array(
//			'redirect' => 'single_post_tag',
//			'refresh'  => true
//		)
//	),
//	'output'          => array(
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1441px)',
//			'method'     => 'inject-style',
//			'element'    => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'   => 'width',
//			'units'      => 'px',
//		),
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1441px)',
//			'method'     => 'inject-style',
//			'element'    => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'   => 'max-width',
//			'units'      => 'px',
//		)
//	)
//);

/**
 * Author
 */
$options[] = array(
	'id'    => 'epic-ne[single_author_template_header]',
	'type'  => 'jeg-header',
	'label' => esc_html__( 'Author Archive Template', 'epic-ne' ),
);

$options[] = array(
	'id'          => 'epic-ne[single_author_template]',
	'option_type' => 'option',
	'transport'   => 'postMessage',
	'default'     => false,
	'type'        => 'jeg-toggle',
	'label'       => esc_html__( 'Author Archive Template', 'epic-ne' ),
	'description' => esc_html__( 'Enable custom author archive template.', 'epic-ne' ),
	'postvar'     => array(
		array(
			'redirect' => 'author_tag',
			'refresh'  => true
		)
	),
);

$options[] = array(
	'id'              => 'epic-ne[single_author_template_id]',
	'option_type'     => 'option',
	'transport'       => 'refresh',
	'default'         => '',
	'type'            => 'jeg-select',
	'label'           => esc_html__( 'Author Archive Template List', 'epic-ne' ),
	'description'     => wp_kses( sprintf( __( 'Create custom category template from <a href="%s" target="_blank">here</a>', 'epic-ne' ), get_admin_url() . 'edit.php?post_type=archive-template' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => epic_get_all_custom_archive_template(),
	'active_callback' => array(
		array(
			'setting'  => 'epic-ne[single_author_template]',
			'operator' => '==',
			'value'    => true,
		)
	),
	'postvar'         => array(
		array(
			'redirect' => 'author_tag',
			'refresh'  => true
		)
	),
);

$options[] = array(
	'id'              => 'epic-ne[single_author_template_number_post]',
	'option_type'     => 'option',
	'transport'       => 'refresh',
	'default'         => 10,
	'type'            => 'jeg-text',
	'label'           => esc_html__( 'Number of Post', 'epic-ne' ),
	'description'     => esc_html__( 'Set the number of post per page on post author page.', 'epic-ne' ),
	'active_callback' => array(
		array(
			'setting'  => 'epic-ne[single_author_template]',
			'operator' => '==',
			'value'    => true,
		)
	),
	'postvar'         => array(
		array(
			'redirect' => 'author_tag',
			'refresh'  => true
		)
	)
);

//$options[] = array(
//	'id'              => 'epic-ne[single_author_template_laptop_container]',
//	'option_type'     => 'option',
//	'transport'       => 'postMessage',
//	'default'         => '1170',
//	'type'            => 'jeg-range-slider',
//	'label'           => esc_html__( '[ Laptop ] Container Width ', 'epic-ne' ),
//	'description'     => esc_html__( 'Content width on Laptop ( width less than 1440px )', 'epic-ne' ),
//	'choices'         => array(
//		'min'  => '1170',
//		'max'  => '1370',
//		'step' => '1',
//	),
//	'active_callback' => array(
//		array(
//			'setting'  => 'epic-ne[single_author_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'postvar'         => array(
//		array(
//			'redirect' => 'author_tag',
//			'refresh'  => true
//		)
//	),
//	'output'          => array(
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1200px)',
//			'method'     => 'inject-style',
//			'element'    => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'   => 'width',
//			'units'      => 'px',
//		),
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1200px)',
//			'method'     => 'inject-style',
//			'element'    => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'   => 'max-width',
//			'units'      => 'px',
//		)
//	)
//);
//
//$options[] = array(
//	'id'              => 'epic-ne[single_author_template_desktop_container]',
//	'option_type'     => 'option',
//	'transport'       => 'postMessage',
//	'default'         => '1170',
//	'type'            => 'jeg-range-slider',
//	'label'           => esc_html__( '[ Desktop ] Content Width', 'epic-ne' ),
//	'description'     => esc_html__( 'Content width on Desktop ( width more than 1440px )', 'epic-ne' ),
//	'choices'         => array(
//		'min'  => '1170',
//		'max'  => '1400',
//		'step' => '1',
//	),
//	'active_callback' => array(
//		array(
//			'setting'  => 'epic-ne[single_author_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'postvar'         => array(
//		array(
//			'redirect' => 'author_tag',
//			'refresh'  => true
//		)
//	),
//	'output'          => array(
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1441px)',
//			'method'     => 'inject-style',
//			'element'    => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'   => 'width',
//			'units'      => 'px',
//		),
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1441px)',
//			'method'     => 'inject-style',
//			'element'    => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'   => 'max-width',
//			'units'      => 'px',
//		)
//	)
//);

/**
 * Date
 */
$options[] = array(
	'id'    => 'epic-ne[single_date_template_header]',
	'type'  => 'jeg-header',
	'label' => esc_html__( 'Date Archive Template', 'epic-ne' ),
);

$options[] = array(
	'id'          => 'epic-ne[single_date_template]',
	'option_type' => 'option',
	'transport'   => 'postMessage',
	'default'     => false,
	'type'        => 'jeg-toggle',
	'label'       => esc_html__( 'Date Archive Template', 'epic-ne' ),
	'description' => esc_html__( 'Enable custom date archive template.', 'epic-ne' ),
);

$options[] = array(
	'id'              => 'epic-ne[single_date_template_id]',
	'option_type'     => 'option',
	'transport'       => 'refresh',
	'default'         => '',
	'type'            => 'jeg-select',
	'label'           => esc_html__( 'Date Archive Template List', 'epic-ne' ),
	'description'     => wp_kses( sprintf( __( 'Create custom category template from <a href="%s" target="_blank">here</a>', 'epic-ne' ), get_admin_url() . 'edit.php?post_type=archive-template' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => epic_get_all_custom_archive_template(),
	'active_callback' => array(
		array(
			'setting'  => 'epic-ne[single_date_template]',
			'operator' => '==',
			'value'    => true,
		)
	)
);

$options[] = array(
	'id'              => 'epic-ne[single_date_template_number_post]',
	'option_type'     => 'option',
	'transport'       => 'refresh',
	'default'         => 10,
	'type'            => 'jeg-text',
	'label'           => esc_html__( 'Number of Post', 'epic-ne' ),
	'description'     => esc_html__( 'Set the number of post per page on date archive page.', 'epic-ne' ),
	'active_callback' => array(
		array(
			'setting'  => 'epic-ne[single_date_template]',
			'operator' => '==',
			'value'    => true,
		)
	),
);

//$options[] = array(
//	'id'              => 'epic-ne[single_date_template_laptop_container]',
//	'option_type'     => 'option',
//	'transport'       => 'postMessage',
//	'default'         => '1170',
//	'type'            => 'jeg-range-slider',
//	'label'           => esc_html__( '[ Laptop ] Container Width ', 'epic-ne' ),
//	'description'     => esc_html__( 'Content width on Laptop ( width less than 1440px )', 'epic-ne' ),
//	'choices'         => array(
//		'min'  => '1170',
//		'max'  => '1370',
//		'step' => '1',
//	),
//	'active_callback' => array(
//		array(
//			'setting'  => 'epic-ne[single_date_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'output'          => array(
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1200px)',
//			'method'     => 'inject-style',
//			'element'    => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'   => 'width',
//			'units'      => 'px',
//		),
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1200px)',
//			'method'     => 'inject-style',
//			'element'    => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'   => 'max-width',
//			'units'      => 'px',
//		)
//	)
//);
//
//$options[] = array(
//	'id'              => 'epic-ne[single_date_template_desktop_container]',
//	'option_type'     => 'option',
//	'transport'       => 'postMessage',
//	'default'         => '1170',
//	'type'            => 'jeg-range-slider',
//	'label'           => esc_html__( '[ Desktop ] Content Width', 'epic-ne' ),
//	'description'     => esc_html__( 'Content width on Desktop ( width more than 1440px )', 'epic-ne' ),
//	'choices'         => array(
//		'min'  => '1170',
//		'max'  => '1400',
//		'step' => '1',
//	),
//	'active_callback' => array(
//		array(
//			'setting'  => 'epic-ne[single_date_template]',
//			'operator' => '==',
//			'value'    => true,
//		)
//	),
//	'output'          => array(
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1441px)',
//			'method'     => 'inject-style',
//			'element'    => '.container, .jeg_vc_content > .vc_row, .jeg_vc_content > .vc_element > .vc_row, .jeg_vc_content > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper, .jeg_vc_content > .vc_element > .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"]) > .jeg-vc-wrapper',
//			'property'   => 'width',
//			'units'      => 'px',
//		),
//		array(
//			'mediaquery' => '@media only screen and (min-width : 1441px)',
//			'method'     => 'inject-style',
//			'element'    => '.elementor-section.elementor-section-boxed > .elementor-container',
//			'property'   => 'max-width',
//			'units'      => 'px',
//		)
//	)
//);

return $options;
