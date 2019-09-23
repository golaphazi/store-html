<?php

$options = array();

$options[] = array(
    'id'            => 'epic-ne[block_notice]',
    'option_type'   => 'option',
    'type'          => 'jeg-alert',
    'default'       => 'info',
    'label'         => esc_html__('Notice','epic-ne' ),
    'description'   => wp_kses(__(
        '<ul>
            <li>Every element will behave differently when option changed depend on default meta on each element</li>
        </ul>',
        'epic-ne'), wp_kses_allowed_html()),
);

$options[] = array(
    'id'            => 'epic-ne[show_block_meta]',
    'option_type'   => 'option',
    'transport'     => 'refresh',
    'default'       => true,
    'type'          => 'jeg-toggle',
    'label'         => esc_html__('Show Block Meta','epic-ne'),
    'description'   => esc_html__('Show meta for block','epic-ne'),
);

$options[] = array(
    'id'            => 'epic-ne[show_block_meta_author]',
    'option_type'   => 'option',
    'transport'     => 'refresh',
    'default'       => true,
    'type'          => 'jeg-toggle',
    'label'         => esc_html__('Show Block Meta - Author','epic-ne'),
    'description'   => esc_html__('Show author on meta block','epic-ne'),
    'active_callback'  => array(
        array(
            'setting'  => 'epic-ne[show_block_meta]',
            'operator' => '==',
            'value'    => true,
        )
    ),
);

$options[] = array(
    'id'            => 'epic-ne[show_block_meta_date]',
    'option_type'   => 'option',
    'transport'     => 'refresh',
    'default'       => true,
    'type'          => 'jeg-toggle',
    'label'         => esc_html__('Show Block Meta - Date','epic-ne'),
    'description'   => esc_html__('Show date on meta block','epic-ne'),
    'active_callback'  => array(
        array(
            'setting'  => 'epic-ne[show_block_meta]',
            'operator' => '==',
            'value'    => true,
        )
    ),
);

$options[] = array(
    'id'            => 'epic-ne[global_post_date]',
    'option_type'   => 'option',
    'transport'     => 'refresh',
    'default'       => 'modified',
    'type'          => 'jeg-select',
    'label'         => esc_html__('Post Date Meta','epic-ne'),
    'description'   => esc_html__('Choose which post date type that you want to show for global post date meta.','epic-ne'),
    'choices'       => array(
        'publish' => esc_attr__( 'Publish Date', 'epic-ne' ),
        'modified' => esc_attr__( 'Modified Date', 'epic-ne' ),
    ),
    'active_callback'  => array(
        array(
            'setting'  => 'epic-ne[show_block_meta]',
            'operator' => '==',
            'value'    => true,
        ),
        array(
            'setting'  => 'epic-ne[show_block_meta_date]',
            'operator' => '==',
            'value'    => true,
        )
    ),
);

$options[] = array(
    'id'            => 'epic-ne[show_block_meta_comment]',
    'option_type'   => 'option',
    'transport'     => 'refresh',
    'default'       => true,
    'type'          => 'jeg-toggle',
    'label'         => esc_html__('Show Block Meta - Comment','epic-ne'),
    'description'   => esc_html__('Show comment icon on meta block','epic-ne'),
    'active_callback'  => array(
        array(
            'setting'  => 'epic-ne[show_block_meta]',
            'operator' => '==',
            'value'    => true,
        )
    ),
);

$options[] = array(
	'id'            => 'epic-ne[show_block_meta_share]',
	'option_type'   => 'option',
	'transport'     => 'refresh',
	'default'       => false,
	'type'          => 'jeg-toggle',
	'label'         => esc_html__('Show Block Meta - Share','epic-ne'),
	'description'   => esc_html__('Show share icon on meta block','epic-ne'),
	'active_callback'  => array(
		array(
			'setting'  => 'epic-ne[show_block_meta]',
			'operator' => '==',
			'value'    => true,
		)
	),
);

$options[] = array(
	'id'            => 'epic-ne[show_block_meta_share_item]',
	'option_type'   => 'option',
	'transport'     => 'postMessage',
	'type'          => 'jeg-repeater',
	'label'         => esc_html__('Add Social Icon', 'epic-ne'),
	'description'   => esc_html__('Add icon for each of your social account.', 'epic-ne'),
    'active_callback'  => array(
        array(
            'setting'  => 'epic-ne[show_block_meta]',
            'operator' => '==',
            'value'    => true,
        ),
        array(
            'setting'  => 'epic-ne[show_block_meta_share]',
            'operator' => '==',
            'value'    => true,
        )
    ),
	'default'       => array(
		array(
			'social_icon' => 'facebook',
		),
		array(
			'social_icon' => 'twitter',
		),
        array(
            'social_icon' => 'googleplus',
        ),
        array(
            'social_icon' => 'linkedin',
        ),
        array(
            'social_icon' => 'pinterest',
        ),
	),
	'row_label'     => array(
		'type' => 'text',
		'value' => esc_attr__( 'Social Icon', 'epic-ne' ),
		'field' => false,
	),
	'fields' => array(
		'social_icon' => array(
			'type'        => 'select',
			'label'       => esc_attr__( 'Social Icon', 'jnews' ),
			'default'     => '',
			'choices'     => array(
				''              => esc_attr__( 'Choose Icon', 'jnews' ),
				'facebook'      => esc_attr__( 'Facebook', 'jnews' ),
				'twitter'       => esc_attr__( 'Twitter', 'jnews' ),
				'linkedin'      => esc_attr__( 'Linkedin', 'jnews' ),
				'googleplus'    => esc_attr__( 'Google+', 'jnews' ),
				'pinterest'     => esc_attr__( 'Pinterest', 'jnews' ),
				'tumblr'        => esc_attr__( 'Tumblr', 'jnews' ),
                'stumbleupon'   => esc_attr__( 'StumbleUpon', 'jnews' ),
                'whatsapp'      => esc_attr__( 'WhatsApp', 'jnews' ),
                // 'line'          => esc_attr__( 'Line', 'jnews' ),
                // 'hatena'          => esc_attr__( 'Hatena', 'jnews' ),
                // 'qrcode'          => esc_attr__( 'QRCode', 'jnews' ),
                'email'          => esc_attr__( 'E-mail', 'jnews' ),
				// 'buffer'        => esc_attr__( 'Buffer', 'jnews' ),
				'vk'            => esc_attr__( 'Vk', 'jnews' ),
				'reddit'        => esc_attr__( 'Reddit', 'jnews' ),
				'wechat'        => esc_attr__( 'WeChat', 'jnews' ),
			),
		)
	)
);

return $options;
