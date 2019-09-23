<?php

$options = array();

$post_types = EPIC\Util\Cache::get_exclude_post_type();

unset( $post_types['post'] );
unset( $post_types['page'] );

if ( ! empty( $post_types ) && is_array( $post_types ) ) {

	foreach ( $post_types as $key => $label ) {

		$options[] = array(
			'id'          => 'epic-ne[enable_cpt_' . $key . ']',
			'option_type' => 'option',
			'transport'   => 'postMessage',
			'default'     => true,
			'type'        => 'jeg-toggle',
			'label'       => sprintf( esc_html__( 'Enable %s Post Type', 'epic-ne' ), $label ),
			'description' => sprintf( esc_html__( 'Enable %s post type and their custom taxonomy as content filter.', 'epic-ne' ), strtolower( $label ) )
		);
	}

} else {
	$options[] = array(
		'id'          => 'epic-ne[enable_post_type_alert]',
		'type'        => 'jeg-alert',
		'default'     => 'info',
		'label'       => esc_html__( 'Notice', 'epic-ne' ),
		'description' => esc_html__( 'There\'s no custom post type found.', 'epic-ne' ),
	);
}

return $options;
