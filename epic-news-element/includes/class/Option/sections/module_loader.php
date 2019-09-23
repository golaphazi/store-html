<?php

$options = array();

$options[] = array(
    'id'            => 'epic-ne[module_loader]',
    'option_type'   => 'option',
    'transport'     => 'postMessage',
    'default'       => 'dot',
    'type'          => 'jeg-select',
    'label'         => esc_html__('Module Loader Style', 'epic-ne'),
    'description'   => esc_html__('Choose loader style for general module element.','epic-ne'),
    'choices'       => array(
        'dot'		    => esc_html__('Dot', 'epic-ne'),
        'circle'		=> esc_html__('Circle', 'epic-ne'),
        'square'		=> esc_html__('Square', 'epic-ne'),
    ),
    'output'     => array(
        array(
            'method'        => 'class-masking',
            'element'       => '.module-overlay .preloader_type',
            'property'      => array(
                'dot'           => 'preloader_dot',
                'circle'        => 'preloader_circle',
                'square'        => 'preloader_square',
            ),
        ),
    )
);

return $options;
