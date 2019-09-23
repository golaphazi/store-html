<?php

if ( ! function_exists( 'jlog' ) ) {
	function jlog( $obj ) {
		echo "<pre>";
		print_r( $obj );
		echo "</pre>";
	}
}

/**
 * Get option
 *
 * @param $setting
 * @param $default
 *
 * @return mixed
 */
if ( ! function_exists( 'epic_get_option' ) ) {
	function epic_get_option( $setting, $default = null ) {
		$options = get_option( 'epic-ne', array() );
		$value   = $default;
		if ( isset( $options[ $setting ] ) ) {
			$value = $options[ $setting ];
		}

		return apply_filters( "epic_get_option_{$setting}", $value );
	}
}

if ( ! function_exists( 'epic_load_resource_limit' ) ) {
	function epic_load_resource_limit() {
		return apply_filters( 'epic_load_resource_limit', 25 );
	}
}


if ( ! function_exists( 'epic_get_view_class_from_shortcode' ) ) {
	function epic_get_view_class_from_shortcode( $name ) {
		$mod   = explode( '_', $name );
		$class = 'EPIC\\Module\\' . ucfirst( $mod[1] ) . '\\' . ucfirst( $mod[1] ) . '_' . ucfirst( $mod[2] ) . '_View';

		return apply_filters( 'epic_get_view_class_from_shortcode', $class, $name );
	}
}

if ( ! function_exists( 'epic_get_option_class_from_shortcode' ) ) {
	function epic_get_option_class_from_shortcode( $name ) {
		$mod   = explode( '_', $name );
		$class = 'EPIC\\Module\\' . ucfirst( $mod[1] ) . '\\' . ucfirst( $mod[1] ) . '_' . $mod[2] . '_Option';

		return apply_filters( 'epic_get_option_class_from_shortcode', $class, $name );
	}
}

if ( ! function_exists( 'epic_get_shortcode_name_from_option' ) ) {
	function epic_get_shortcode_name_from_option( $class ) {
		$mod = explode( '\\', $class );

		if ( isset( $mod[3] ) ) {
			$module = str_replace( '_Option', '', $mod[0] . '_' . $mod[3] );
		} else {
			$module = $class;
		}

		$module = strtolower( $module );

		return apply_filters( 'epic_get_shortcode_name_from_option', $module, $class );
	}
}

if ( ! function_exists( 'epic_get_shortcode_name_from_view' ) ) {
	function epic_get_shortcode_name_from_view( $class ) {
		$mod = explode( '\\', $class );

		if ( isset( $mod[3] ) ) {
			$module = str_replace( '_View', '', $mod[0] . '_' . $mod[3] );
		} else {
			$module = $class;
		}

		$module = strtolower( $module );

		return apply_filters( 'epic_get_shortcode_name_from_view', $module, $class );
	}
}

if ( ! function_exists( 'epic_get_module_instance' ) ) {
	function epic_get_module_instance( $name ) {
		return call_user_func( array( $name, 'getInstance' ) );
	}
}


/**
 * Format Number
 *
 * @param $total
 *
 * @return string
 */
if ( ! function_exists( 'epic_number_format' ) ) {
	function epic_number_format( $total ) {
		if ( $total > 1000000 ) {
			$total = round( $total / 1000000, 1 ) . 'M';
		} elseif ( $total > 1000 ) {
			$total = round( $total / 1000, 1 ) . 'k';
		}

		return $total;
	}
}

/**
 * Get primary category ceremony
 *
 * @param $post_id
 *
 * @return mixed|void
 */
if ( ! function_exists( 'epic_get_primary_category' ) ) {
	function epic_get_primary_category( $post_id ) {
		$category_id = null;

		if ( get_post_type( $post_id ) === 'post' ) {
			$categories = array_slice( get_the_category( $post_id ), 0, 1 );
			if ( empty( $categories ) ) {
				return null;
			}
			$category    = array_shift( $categories );
			$category_id = $category->term_id;
		}

		return apply_filters( 'epic_primary_category', $category_id, $post_id );
	}
}

/**
 * Edit Post
 */
if ( ! function_exists( 'epic_edit_post' ) ) {
	function epic_edit_post( $post_id, $position = "left" ) {
		if ( current_user_can( 'edit_posts' ) ) {
			$url = get_edit_post_link( $post_id );

			return "<a class=\"jeg-edit-post {$position}\" href=\"{$url}\" target=\"_blank\">
                        <i class=\"fa fa-pencil\"></i>
                        <span>" . esc_html__( 'edit post', 'epic-ne' ) . "</span>
                    </a>";
		}

		return false;
	}
}

/**
 * Post Class
 */
if ( ! function_exists( 'epic_post_class' ) ) {
	function epic_post_class( $class = '', $post_id = null ) {
		// Separates classes with a single space, collates classes for post DIV
		return 'class="' . join( ' ', epic_get_post_class( $class, $post_id ) ) . '"';
	}
}

/**
 * Retrieves the classes for the post div as an array.
 *
 * The class names are many. If the post is a sticky, then the 'sticky'
 * class name. The class 'hentry' is always added to each post. If the post has a
 * post thumbnail, 'has-post-thumbnail' is added as a class. For each taxonomy that
 * the post belongs to, a class will be added of the format '{$taxonomy}-{$slug}' -
 * eg 'category-foo' or 'my_custom_taxonomy-bar'.
 *
 * The 'post_tag' taxonomy is a special
 * case; the class has the 'tag-' prefix instead of 'post_tag-'. All classes are
 * passed through the filter, {@see 'post_class'}, with the list of classes, followed by
 * $class parameter value, with the post ID as the last parameter.
 *
 * @since 2.7.0
 * @since 4.2.0 Custom taxonomy classes were added.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @param int|WP_Post $post_id Optional. Post ID or post object.
 *
 * @return array Array of classes.
 */
function epic_get_post_class( $class = '', $post_id = null ) {
	$post = get_post( $post_id );

	$classes = array();

	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_map( 'esc_attr', $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	if ( ! $post ) {
		return $classes;
	}

	$classes[] = 'post-' . $post->ID;
	if ( ! is_admin() ) {
		$classes[] = $post->post_type;
	}
	$classes[] = 'type-' . $post->post_type;
	$classes[] = 'status-' . $post->post_status;

	// Post Format
	if ( post_type_supports( $post->post_type, 'post-formats' ) ) {
		$post_format = get_post_format( $post->ID );

		if ( $post_format && ! is_wp_error( $post_format ) ) {
			$classes[] = 'format-' . sanitize_html_class( $post_format );
		} else {
			$classes[] = 'format-standard';
		}
	}

	$post_password_required = post_password_required( $post->ID );

	// Post requires password.
	if ( $post_password_required ) {
		$classes[] = 'post-password-required';
	} elseif ( ! empty( $post->post_password ) ) {
		$classes[] = 'post-password-protected';
	}

	// Post thumbnails.
	if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( $post->ID ) && ! is_attachment( $post ) && ! $post_password_required ) {
		$classes[] = 'has-post-thumbnail';
	}

	// sticky for Sticky Posts
	if ( is_sticky( $post->ID ) ) {
		if ( is_home() && ! is_paged() ) {
			$classes[] = 'sticky';
		} elseif ( is_admin() ) {
			$classes[] = 'status-sticky';
		}
	}

	// hentry for hAtom compliance
	$classes[] = 'hentry';

	// All public taxonomies
	$taxonomies = get_taxonomies( array( 'public' => true ) );
	foreach ( (array) $taxonomies as $taxonomy ) {
		if ( is_object_in_taxonomy( $post->post_type, $taxonomy ) ) {
			foreach ( (array) get_the_terms( $post->ID, $taxonomy ) as $term ) {
				if ( empty( $term->slug ) ) {
					continue;
				}

				$term_class = sanitize_html_class( $term->slug, $term->term_id );
				if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
					$term_class = $term->term_id;
				}

				// 'post_tag' uses the 'tag' prefix for backward compatibility.
				if ( 'post_tag' == $taxonomy ) {
					$classes[] = 'tag-' . $term_class;
				} else {
					$classes[] = sanitize_html_class( $taxonomy . '-' . $term_class, $taxonomy . '-' . $term->term_id );
				}
			}
		}
	}

	$classes = array_map( 'esc_attr', $classes );

	return array_unique( $classes );
}

/**
 * Comment Number
 */
if ( ! function_exists( 'epic_get_comments_number' ) ) {
	function epic_get_comments_number( $post_id = 0 ) {
		$comments_number = get_comments_number( $post_id );

		return apply_filters( 'epic_get_comments_number', $comments_number, $post_id );
	}
}

if ( ! function_exists( 'epic_ago_time' ) ) {
	function epic_ago_time( $time ) {
		return esc_html(
			sprintf(
				esc_html__( '%s ago', 'epic-ne' ),
				$time
			)
		);
	}
}

if ( ! function_exists( 'epic_generate_random_string' ) ) {
	function epic_generate_random_string( $length = 10 ) {
		return substr( str_shuffle( str_repeat( $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil( $length / strlen( $x ) ) ) ), 1, $length );
	}
}

if ( ! function_exists( 'epic_get_respond_link' ) ) {
	function epic_get_respond_link( $post_id = null ) {
		$permalink = get_the_permalink( $post_id );
		$permalink .= apply_filters( "epic_get_comments_hash_url", "#respond" );

		return $permalink;
	}
}

if ( ! function_exists( 'epic_get_post_date' ) ) {
	function epic_get_post_date( $format = '', $post = null ) {
		if ( epic_get_option( 'global_post_date', 'modified' ) === 'publish' ) {
			return get_the_date( $format, $post );
		}

		return get_the_modified_date( $format, $post );
	}
}

/**
 * All Author
 */
if ( ! function_exists( 'epic_get_all_author' ) ) {
	function epic_get_all_author() {
		$result = array();

		if ( is_admin() ) {
			$count = EPIC\Util\Cache::get_count_users();
			$limit = epic_load_resource_limit();

			if ( (int) $count['total_users'] <= $limit ) {
				$users = EPIC\Util\Cache::get_users();

				foreach ( $users as $user ) {
					$result[ $user->display_name ] = $user->ID;
				}
			}
		}

		return $result;
	}
}

/**
 * All Author
 */
if ( ! function_exists( 'epic_get_all_menu' ) ) {
	function epic_get_all_menu() {
		$result = array();

		if ( is_admin() ) {
			if ( $menus = EPIC\Util\Cache::get_menu() ) {
				foreach ( $menus as $menu ) {
					$result[ $menu->name ] = $menu->term_id;
				}
			}
		}

		return $result;
	}
}

/**
 * All Tag
 */
if ( ! function_exists( 'epic_get_all_tag' ) ) {
	function epic_get_all_tag() {
		$result = array();

		if ( is_admin() ) {
			$count = EPIC\Util\Cache::get_tags_count();
			$limit = epic_load_resource_limit();

			if ( (int) $count <= $limit ) {
				if ( $terms = EPIC\Util\Cache::get_tags() ) {
					foreach ( $terms as $term ) {
						$result[] = array(
							'value' => $term->term_id,
							'label' => $term->name
						);
					}
				}
			}
		}

		return $result;
	}
}

/**
 * All Post Category
 */
if ( ! function_exists( 'epic_get_all_category' ) ) {
	function epic_get_all_category() {
		$result = array();

		if ( is_admin() ) {
			$count = EPIC\Util\Cache::get_categories_count();
			$limit = epic_load_resource_limit();

			if ( (int) $count <= $limit ) {
				$categories = EPIC\Util\Cache::get_categories();
				$walker     = new EPIC\Walker\SelectizeWalker();
				$walker->walk( $categories, 3 );

				foreach ( $walker->cache as $value ) {
					$result[] = array(
						'value' => $value['id'],
						'label' => array( $value['title'], $value['depth'] ),
					);
				}
			}
		}

		return $result;
	}
}


if ( ! function_exists( 'epic_get_enable_post_type' ) ) {

	function epic_get_enable_post_type() {

		$post_types = EPIC\Util\Cache::get_exclude_post_type();

		if ( ! empty( $post_types ) && is_array( $post_types ) ) {

			foreach ( $post_types as $key => $label ) {

				if ( ! in_array( $key, array( 'post', 'page' ) ) ) {

					if ( ! epic_get_option( 'enable_cpt_' . $key, true ) ) {
						unset( $post_types[ $key ] );
					}
				}
			}
		}

		$post_types = apply_filters('epic_get_enable_post_type', $post_types);
		return $post_types;
	}
}


if ( ! function_exists( 'epic_unset_unnecessary_attr' ) ) {

	add_filter( 'epic_unset_unnecessary_attr', 'epic_unset_unnecessary_attr' );

	function epic_unset_unnecessary_attr( $data ) {

		$taxonomies = EPIC\Util\Cache::get_enable_custom_taxonomies();
		$taxonomies = array_keys( $taxonomies );
		$data       = array_merge( $taxonomies, $data );

		return $data;
	}
}


if ( ! function_exists( 'epic_default_query_args' ) ) {

	add_filter( 'epic_default_query_args', 'epic_default_query_args', 10, 2 );

	function epic_default_query_args( $args, $attr ) {

		$taxonomies = EPIC\Util\Cache::get_enable_custom_taxonomies();
		$taxonomies = array_keys( $taxonomies );

		foreach ( $taxonomies as $taxonomy ) {

			if ( ! empty( $attr[ $taxonomy ] ) ) {

				$args['tax_query'] = array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'term_id',
						'terms'    => explode( ',', $attr[ $taxonomy ] ),
						'operator' => 'IN'
					)
				);
			}
		}

		return $args;
	}
}


/**
 * Generate header unique style
 */
if ( ! function_exists( 'epic_header_styling' ) ) {
	function epic_header_styling( $attr, $unique_class ) {
		$type  = isset( $attr['header_type'] ) ? $attr['header_type'] : 'heading_1';
		$style = '';

		switch ( $type ) {
			case "heading_1" :
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_1 .jeg_block_title span { background: {$attr['header_background']}; }";
				}

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_1 .jeg_block_title span, .{$unique_class}.jeg_block_heading_1 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_line_color'] ) && ! empty( $attr['header_line_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_1 { border-color: {$attr['header_line_color']}; }";
				}

				break;
			case "heading_2" :
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_2 .jeg_block_title span { background: {$attr['header_background']}; }";
				}

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_2 .jeg_block_title span, .{$unique_class}.jeg_block_heading_2 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_secondary_background'] ) && ! empty( $attr['header_secondary_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_2 { background-color: {$attr['header_secondary_background']}; }";
				}

				break;
			case "heading_3" :
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_3 { background: {$attr['header_background']}; }";
				}

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_3 .jeg_block_title span, .{$unique_class}.jeg_block_heading_3 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				break;
			case "heading_4" :
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_4 .jeg_block_title span { background: {$attr['header_background']}; }";
				}

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_4 .jeg_block_title span, .{$unique_class}.jeg_block_heading_4 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				break;
			case "heading_5" :
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_5 .jeg_block_title span, .{$unique_class}.jeg_block_heading_5 .jeg_subcat { background: {$attr['header_background']}; }";
				};

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_5 .jeg_block_title span, .{$unique_class}.jeg_block_heading_5 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_line_color'] ) && ! empty( $attr['header_line_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_5:before { border-color: {$attr['header_line_color']}; }";
				}

				break;
			case "heading_6" :
				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_6 .jeg_block_title span, .{$unique_class}.jeg_block_heading_6 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_line_color'] ) && ! empty( $attr['header_line_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_6 { border-color: {$attr['header_line_color']}; }";
				}

				if ( isset( $attr['header_accent_color'] ) && ! empty( $attr['header_accent_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_6:after { background-color: {$attr['header_accent_color']}; }";
				}

				break;
			case "heading_7" :
				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_7 .jeg_block_title span, .{$unique_class}.jeg_block_heading_7 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_accent_color'] ) && ! empty( $attr['header_accent_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_7 .jeg_block_title span { border-color: {$attr['header_accent_color']}; }";
				}

				break;
			case "heading_8" :
				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_8 .jeg_block_title span, .{$unique_class}.jeg_block_heading_8 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}
				break;
			case "heading_9" :
				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_9 .jeg_block_title span, .{$unique_class}.jeg_block_heading_9 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_line_color'] ) && ! empty( $attr['header_line_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_9 { border-color: {$attr['header_line_color']}; }";
				}
				break;
		}

		return $style;
	}
}

if ( ! function_exists( 'epic_module_custom_color' ) ) {
	function epic_module_custom_color( $attr, $unique_class, $name = '' ) {
		$unique_class = trim( $unique_class );
		$style        = '';

		if ( isset( $attr['title_color'] ) && ! empty( $attr['title_color'] ) ) {
			switch ( $name ) {
				case '35':
				case '36':
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_post_title a { color: {$attr['title_color']} }";
					break;
				default:
					$style .= ".{$unique_class} .jeg_post_title a, .{$unique_class}.jeg_postblock .jeg_subcat_list > li > a, .{$unique_class} .jeg_pl_md_card .jeg_post_category a:hover { color: {$attr['title_color']} }";
					break;
			}
		}

		if ( isset( $attr['accent_color'] ) && ! empty( $attr['accent_color'] ) ) {
			switch ( $name ) {
				case '35':
				case '36':
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_meta_author a, .{$unique_class} .jeg_pl_md_5 .jeg_post_title a:hover { color: {$attr['accent_color']} }";
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_readmore:hover { background-color: {$attr['accent_color']}; }";
					break;
				default:
					$style .= ".{$unique_class} .jeg_meta_author a, .{$unique_class} .jeg_post_title a:hover { color: {$attr['accent_color']} }";
					$style .= ".{$unique_class} .jeg_readmore:hover { background-color: {$attr['accent_color']}; }";
					$style .= ".{$unique_class} .jeg_readmore:hover { border-color: {$attr['accent_color']}; }";
					break;
			}
		}

		if ( isset( $attr['readmore_background'] ) && ! empty( $attr['readmore_background'] ) ) {
			$style .= ".{$unique_class} .jeg_readmore { background-color: {$attr['readmore_background']}; }";
		}

		if ( isset( $attr['alt_color'] ) && ! empty( $attr['alt_color'] ) ) {
			switch ( $name ) {
				case '35':
				case '36':
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_post_meta, .{$unique_class} .jeg_pl_md_5 .jeg_post_meta .fa { color: {$attr['alt_color']} }";
					break;
				default:
					$style .= ".{$unique_class} .jeg_post_meta, .{$unique_class} .jeg_post_meta .fa, .{$unique_class}.jeg_postblock .jeg_subcat_list > li > a:hover, .{$unique_class} .jeg_pl_md_card .jeg_post_category a, .{$unique_class}.jeg_postblock .jeg_subcat_list > li > a.current { color: {$attr['alt_color']} }";
					break;
			}
		}

		if ( isset( $attr['excerpt_color'] ) && ! empty( $attr['excerpt_color'] ) ) {
			switch ( $name ) {
				case '35':
				case '36':
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_post_excerpt { color: {$attr['excerpt_color']} }";
					break;
				default:
					$style .= ".{$unique_class} .jeg_post_excerpt { color: {$attr['excerpt_color']} }";
					break;
			}
		}

		if ( isset( $attr['block_background'] ) && ! empty( $attr['block_background'] ) ) {
			switch ( $name ) {
				case '11':
				case '12':
					$style .= ".{$unique_class}.jeg_postblock .jeg_postblock_content, .{$unique_class}.jeg_postblock .jeg_inner_post { background: {$attr['block_background']} }";
					break;
				case '32':
				case '33':
				case '35':
				case '36':
				case '37':
					$style .= ".{$unique_class}.jeg_postblock .box_wrap { background-color: {$attr['block_background']} }";
					break;
				default:
					$style .= ".{$unique_class}.jeg_postblock .jeg_post { background-color: {$attr['block_background']} }";
					break;
			}
		}

		if ( isset( $attr['bg_color'] ) && ! empty( $attr['bg_color'] ) ) {
			$style .= ".{$unique_class}.jeg_postblock .jeg_postblock_content { background-color: {$attr['bg_color']} }";
		}

		return $style;
	}
}


add_filter( 'wp_kses_allowed_html', 'epic_allowed_html' );

// Extend Allowed HTML WP KSES
if ( ! function_exists( 'epic_allowed_html' ) ) {
	function epic_allowed_html( $allowedtags ) {
		$allowedtags['br']   = array();
		$allowedtags['ul']   = array(
			'class' => true,
			'style' => true
		);
		$allowedtags['ol']   = array();
		$allowedtags['li']   = array();
		$allowedtags['a']    = array(
			'href'   => true,
			'title'  => true,
			'target' => true,
			'class'  => true,
			'style'  => true
		);
		$allowedtags['span'] = array(
			'class' => true,
			'style' => true
		);
		$allowedtags['i']    = array(
			'class' => true
		);
		$allowedtags['div']  = array(
			'id'         => true,
			'class'      => true,
			'data-id'    => true,
			'data-video' => true
		);
		$allowedtags['img']  = array(
			'class'  => true,
			'src'    => true,
			'alt'    => true,
			'srcset' => true
		);

		return $allowedtags;
	}
}


if ( ! function_exists( 'epic_header_icon' ) ) {
	function epic_header_icon( $icon ) {
		if ( ! empty( $icon ) ) {
			$icon = trim( $icon );

			if ( substr( $icon, 0, 2 ) === "fa" && ! strpos( $icon, ' ' ) ) {
				$icon = 'fa ' . $icon;
			}

			return "<i class='{$icon}'></i>";
		}

		return null;
	}
}


if ( ! function_exists( 'jeg_is_frontend_vc' ) ) {
	function jeg_is_frontend_vc() {
		return function_exists( 'vc_is_page_editable' ) && vc_is_page_editable();
	}
}


if ( ! function_exists( 'jeg_is_frontend_elementor' ) ) {
	function jeg_is_frontend_elementor() {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			return true;
		}
	}
}


if ( ! function_exists( 'jeg_render_builder_content' ) ) {
	function jeg_render_builder_content( $template_id ) {

		if ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->db->is_built_with_elementor( $template_id ) ) {

			$frontend = new \Elementor\Frontend();

			add_action( 'wp_enqueue_scripts', [ $frontend, 'enqueue_styles' ] );
			add_action( 'wp_head', [ $frontend, 'print_fonts_links' ] );
			add_action( 'wp_footer', [ $frontend, 'wp_footer' ] );

			add_action( 'admin_bar_menu', [ $frontend, 'add_menu_in_admin_bar' ], 200 );

			add_action( 'wp_enqueue_scripts', [ $frontend, 'register_scripts' ], 5 );
			add_action( 'wp_enqueue_scripts', [ $frontend, 'register_styles' ], 5 );

			$html = $frontend->get_builder_content( $template_id );

			add_filter( 'get_the_excerpt', [ $frontend, 'start_excerpt_flag' ], 1 );
			add_filter( 'get_the_excerpt', [ $frontend, 'end_excerpt_flag' ], 20 );
		} else {
			$page = get_post( $template_id );
			$html = do_shortcode( $page->post_content );
		}

		return $html;
	}
}


if ( ! function_exists( 'jeg_recursive_category' ) ) {
	function jeg_recursive_category( $categories, &$result ) {
		foreach ( $categories as $category ) {
			$result[] = $category;
			$children = get_categories( array( 'parent' => $category->term_id ) );

			if ( ! empty( $children ) ) {
				jeg_recursive_category( $children, $result );
			}
		}
	}
}


if ( ! function_exists( 'epic_get_post_current_page' ) ) {
	function epic_get_post_current_page() {
		$page  = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		return max( $page, $paged );
	}
}


if ( ! function_exists( 'epic_the_author_link' ) ) {
	function epic_the_author_link( $author = null, $print = true ) {
		if ( $print ) {
			printf( '<a href="%1$s">%2$s</a>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author ) ) ),
				get_the_author_meta( 'display_name', $author ) );
		} else {
			return sprintf( '<a href="%1$s">%2$s</a>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author ) ) ),
				get_the_author_meta( 'display_name', $author ) );
		}
	}
}


if ( ! function_exists( 'epic_get_respond_link' ) ) {
	function epic_get_respond_link( $post_id = null ) {
		return get_the_permalink( $post_id ) . '#respond';
	}
}


if ( ! function_exists( 'epic_paging_navigation' ) ) {
	function epic_paging_navigation( $args, $total_page = false ) {
		global $wp_query, $wp_rewrite;

		// Setting up default values based on the current URL.
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$url_parts    = explode( '?', $pagenum_link );

		// Get max pages and current page out of the current query, if available.
		$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
		$total   = $total_page ? $total_page : $total;
		$current = epic_get_post_current_page();

		// Append the format placeholder to the base URL.
		$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

		// URL base depends on permalink settings.
		$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		$defaults = array(
			'base'               => $pagenum_link,
			'format'             => $format,
			'total'              => $total,
			'current'            => $current,
			'show_all'           => false,
			'prev_next'          => true,
			'prev_text'          => esc_html__( 'Previous', 'epic-ne' ),
			'next_text'          => esc_html__( 'Next', 'epic-ne' ),
			'end_size'           => 1,
			'mid_size'           => 1,
			'type'               => 'plain',
			'add_args'           => array(), // array of query args to add
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => ''
		);

		$args = wp_parse_args( $args, $defaults );

		if ( ! is_array( $args['add_args'] ) ) {
			$args['add_args'] = array();
		}

		// Merge additional query vars found in the original URL into 'add_args' array.
		if ( isset( $url_parts[1] ) ) {
			// Find the format argument.
			$format_args  = $url_query_args = array();
			$format       = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
			$format_query = isset( $format[1] ) ? $format[1] : '';
			wp_parse_str( $format_query, $format_args );

			// Find the query args of the requested URL.
			wp_parse_str( $url_parts[1], $url_query_args );

			// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
			foreach ( $format_args as $format_arg => $format_arg_value ) {
				unset( $url_query_args[ $format_arg ] );
			}

			$args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
		}

		// Who knows what else people pass in $args
		$total = (int) $args['total'];
		if ( $total < 2 ) {
			return;
		}
		$current  = (int) $args['current'];
		$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
		if ( $end_size < 1 ) {
			$end_size = 1;
		}
		$mid_size = (int) $args['mid_size'];
		if ( $mid_size < 0 ) {
			$mid_size = 2;
		}
		$add_args   = $args['add_args'];
		$r          = '';
		$page_links = array();
		$dots       = false;

		if ( $args['prev_next'] && $current && 1 < $current ) :
			$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
			$link = str_replace( '%#%', $current - 1, $link );
			if ( $add_args ) {
				$link = add_query_arg( $add_args, $link );
			}
			$link .= $args['add_fragment'];

			/**
			 * Filters the paginated links for the given archive pages.
			 *
			 * @since 3.0.0
			 *
			 * @param string $link The paginated link URL.
			 */
			$page_links[] = '<a class="page_nav prev" data-id="' . ( $current - 1 ) . '" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"><span class="navtext">' . $args['prev_text'] . '</span></a>';
		endif;
		for ( $n = 1; $n <= $total; $n ++ ) :
			if ( $n == $current ) :
				$page_links[] = "<span class='page_number active'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</span>";
				$dots         = true;
			else :
				if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
					$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
					$link = str_replace( '%#%', $n, $link );
					if ( $add_args ) {
						$link = add_query_arg( $add_args, $link );
					}
					$link .= $args['add_fragment'];

					/** This filter is documented in wp-includes/general-template.php */
					$page_links[] = "<a class='page_number' data-id='{$n}' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a>";
					$dots         = true;
				elseif ( $dots && ! $args['show_all'] ) :
					$page_links[] = '<span class="page_number dots">' . __( '&hellip;', 'epic-ne' ) . '</span>';
					$dots         = false;
				endif;
			endif;
		endfor;
		if ( $args['prev_next'] && $current && ( $current < $total || - 1 == $total ) ) :
			$link = str_replace( '%_%', $args['format'], $args['base'] );
			$link = str_replace( '%#%', $current + 1, $link );
			if ( $add_args ) {
				$link = add_query_arg( $add_args, $link );
			}
			$link .= $args['add_fragment'];

			/** This filter is documented in wp-includes/general-template.php */
			$page_links[] = '<a class="page_nav next" data-id="' . ( $current + 1 ) . '" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"><span class="navtext">' . $args['next_text'] . '</span></a>';
		endif;

		switch ( $args['type'] ) {
			case 'array' :
				return $page_links;

			case 'list' :
				$r .= "<ul class='page-numbers'>\n\t<li>";
				$r .= join( "</li>\n\t<li>", $page_links );
				$r .= "</li>\n</ul>\n";
				break;

			default :
				$nav_class = 'jeg_page' . $args['pagination_mode'];
				$nav_align = 'jeg_align' . $args['pagination_align'];
				$nav_text  = $args['pagination_navtext'] ? '' : 'no_navtext';
				$nav_info  = $args['pagination_pageinfo'] ? '' : 'no_pageinfo';

				$paging_text = sprintf( esc_html__( 'Page %s of %s', 'epic-ne' ), $current, $total );

				$r = join( "\n", $page_links );
				$r = "<div class=\"jeg_navigation jeg_pagination {$nav_class} {$nav_align} {$nav_text} {$nav_info}\">
                    <span class=\"page_info\">{$paging_text}</span>
                    {$r}
                </div>";
				break;
		}

		return $r;
	}
}


if ( ! function_exists( 'epic_get_archive_override' ) ) {

	function epic_get_archive_override( $term_id, $key, $prefix ) {

		$data = get_option( $prefix . $key, array() );

		if ( isset( $data[ $term_id ] ) ) {
			return $data[ $term_id ];
		}

		return null;
	}
}


if ( ! function_exists( 'epic_get_custom_archive_template' ) ) {

	function epic_get_all_custom_archive_template() {
		$post = get_posts( array(
			'posts_per_page' => - 1,
			'post_type'      => 'archive-template',
		) );

		$template   = array();
		$template[] = esc_html__( 'Choose Custom Template', 'epic-ne' );

		if ( $post ) {
			foreach ( $post as $value ) {
				$template[ $value->ID ] = $value->post_title;
			}
		}

		return $template;
	}
}


if ( ! function_exists( 'epic_override_category_template' ) ) {

	add_filter( 'epic_get_option_single_category_template', 'epic_override_category_template' );

	function epic_override_category_template( $value ) {

		if ( is_category() ) {

			$term = get_queried_object();

			if ( isset( $term->term_id ) && $term->term_id ) {

				if ( epic_get_archive_override( $term->term_id, 'override_template', 'epic_category_' ) ) {
					return true;
				}
			}
		}

		return $value;
	}
}


if ( ! function_exists( 'epic_override_category_template_id' ) ) {

	add_filter( 'epic_get_option_single_category_template_id', 'epic_override_category_template_id' );

	function epic_override_category_template_id( $value ) {

		if ( is_category() ) {

			$term = get_queried_object();

			if ( isset( $term->term_id ) && $term->term_id ) {

				if ( epic_get_archive_override( $term->term_id, 'override_template', 'epic_category_' ) ) {

					$template = epic_get_archive_override( $term->term_id, 'category_template', 'epic_category_' );

					if ( $template ) {
						$value = $template;
					}
				}
			}
		}

		return $value;
	}
}


if ( ! function_exists( 'epic_override_category_number_post' ) ) {

	add_filter( 'epic_get_option_single_category_template_number_post', 'epic_override_category_number_post' );

	function epic_override_category_number_post( $value ) {

		if ( is_category() ) {

			$term = get_queried_object();

			if ( isset( $term->term_id ) && $term->term_id ) {

				if ( epic_get_archive_override( $term->term_id, 'override_template', 'epic_category_' ) ) {

					$number_post = epic_get_archive_override( $term->term_id, 'number_post', 'epic_category_' );

					if ( $number_post ) {
						$value = $number_post;
					}
				}
			}
		}

		return $value;
	}
}


if ( ! function_exists( 'epic_override_tag_template' ) ) {

	add_filter( 'epic_get_option_single_tag_template', 'epic_override_tag_template' );

	function epic_override_tag_template( $value ) {

		if ( is_tag() ) {

			$term = get_queried_object();

			if ( isset( $term->term_id ) && $term->term_id ) {

				if ( epic_get_archive_override( $term->term_id, 'override_template', 'epic_tag_' ) ) {
					return true;
				}
			}
		}

		return $value;
	}
}


if ( ! function_exists( 'epic_override_tag_template_id' ) ) {

	add_filter( 'epic_get_option_single_tag_template_id', 'epic_override_tag_template_id' );

	function epic_override_tag_template_id( $value ) {

		if ( is_tag() ) {

			$term = get_queried_object();

			if ( isset( $term->term_id ) && $term->term_id ) {

				if ( epic_get_archive_override( $term->term_id, 'override_template', 'epic_tag_' ) ) {

					$template = epic_get_archive_override( $term->term_id, 'tag_template', 'epic_tag_' );

					if ( $template ) {
						$value = $template;
					}
				}
			}
		}

		return $value;
	}
}


if ( ! function_exists( 'epic_override_tag_number_post' ) ) {

	add_filter( 'epic_get_option_single_tag_template_number_post', 'epic_override_tag_number_post' );

	function epic_override_tag_number_post( $value ) {

		if ( is_tag() ) {

			$term = get_queried_object();

			if ( isset( $term->term_id ) && $term->term_id ) {

				if ( epic_get_archive_override( $term->term_id, 'override_template', 'epic_tag_' ) ) {

					$number_post = epic_get_archive_override( $term->term_id, 'number_post', 'epic_tag_' );

					if ( $number_post ) {
						$value = $number_post;
					}
				}
			}
		}

		return $value;
	}
}


if ( ! function_exists( 'epic_override_author_template' ) ) {

	add_filter( 'epic_get_option_single_author_template', 'epic_override_author_template' );

	function epic_override_author_template( $value ) {

		if ( is_author() ) {

			$user = get_userdata( get_query_var( 'author' ) );

			if ( isset( $user->ID ) && $user->ID ) {

				if ( epic_get_archive_override( $user->ID, 'override_template', 'epic_author_' ) ) {
					return true;
				}
			}
		}

		return $value;
	}
}


if ( ! function_exists( 'epic_override_author_template_id' ) ) {

	add_filter( 'epic_get_option_single_author_template_id', 'epic_override_author_template_id' );

	function epic_override_author_template_id( $value ) {

		if ( is_author() ) {

			$user = get_userdata( get_query_var( 'author' ) );

			if ( isset( $user->ID ) && $user->ID ) {

				if ( epic_get_archive_override( $user->ID, 'override_template', 'epic_author_' ) ) {

					$template = epic_get_archive_override( $user->ID, 'author_template', 'epic_author_' );

					if ( $template ) {
						$value = $template;
					}
				}
			}
		}

		return $value;
	}
}


if ( ! function_exists( 'epic_override_author_number_post' ) ) {

	add_filter( 'epic_get_option_single_author_template_number_post', 'epic_override_author_number_post' );

	function epic_override_author_number_post( $value ) {

		if ( is_author() ) {

			$user = get_user_by( 'slug', get_query_var( 'author_name' ) );

			if ( isset( $user->ID ) && $user->ID ) {

				if ( epic_get_archive_override( $user->ID, 'override_template', 'epic_author_' ) ) {

					$template = epic_get_archive_override( $user->ID, 'number_post', 'epic_author_' );

					if ( $template ) {
						$value = $template;
					}
				}
			}
		}

		return $value;
	}
}


if ( ! function_exists( 'epic_archive_custom_get_posts' ) ) {

	if ( ! is_admin() ) {
		add_action( 'pre_get_posts', 'epic_archive_custom_get_posts' );
	}

	function epic_archive_custom_get_posts( $query ) {

		if ( $query->is_main_query() ) {

			if ( is_category() ) {
				if ( epic_get_option( 'single_category_template', false ) ) {
					$query->query_vars['posts_per_page'] = (int) epic_get_option( 'single_category_template_number_post', 10 );
				}
			} elseif ( is_tag() ) {
				if ( epic_get_option( 'single_tag_template', false ) ) {
					$query->query_vars['posts_per_page'] = (int) epic_get_option( 'single_tag_template_number_post', 10 );
				}
			} elseif ( is_author() ) {
				if ( epic_get_option( 'single_author_template', false ) ) {
					$query->query_vars['posts_per_page'] = (int) epic_get_option( 'single_author_template_number_post', 10 );
				}
			} elseif ( is_date() ) {
				if ( epic_get_option( 'single_date_template', false ) ) {
					$query->query_vars['posts_per_page'] = (int) epic_get_option( 'single_date_template_number_post', 10 );
				}
			}

		}
	}
}


if ( ! function_exists( 'epic_gutenberg_body_class' ) ) {

	add_action( 'body_class', 'epic_gutenberg_body_class' );

	function epic_gutenberg_body_class( $classes ) {

		if ( function_exists( 'has_blocks' ) && has_blocks( get_the_ID() ) ) {
			$classes[] = 'epic-gutenberg';
		}

		return $classes;
	}
}


if ( ! function_exists( 'epic_override_single_post_template' ) ) {

	add_filter( 'epic_get_option_single_post_template', 'epic_override_single_post_template' );

	function epic_override_single_post_template( $value ) {

		$template = get_post_meta( get_the_ID(), '_wp_page_template', true );

		if ( strpos( $template, 'epic_custom_post_template' ) !== false ) {

			$template = explode( '-', $template );

			if ( isset( $template[1] ) && $template[1] ) {
				return true;
			}
		}

		return $value;
	}
}

if ( ! function_exists( 'epic_override_single_post_template_id' ) ) {

	add_filter( 'epic_get_option_single_post_template_id', 'epic_override_single_post_template_id' );

	function epic_override_single_post_template_id( $value ) {

		$template = get_post_meta( get_the_ID(), '_wp_page_template', true );

		if ( strpos( $template, 'epic_custom_post_template' ) !== false ) {

			$template = explode( '-', $template );

			if ( isset( $template[1] ) && $template[1] ) {
				return $template[1];
			}
		}

		return $value;
	}
}

if ( ! function_exists( 'epic_theme_post_templates' ) ) {

	add_filter( 'theme_post_templates', 'epic_theme_post_templates' );

	function epic_theme_post_templates( $page_templates ) {
		$post = get_posts( array(
			'posts_per_page' => - 1,
			'post_type'      => 'custom-post-template',
		) );

		$template = array();

		if ( $post ) {
			foreach ( $post as $value ) {
				$template[ 'epic_custom_post_template-' . $value->ID ] = $value->post_title;
			}
		}

		if ( ! empty( $template ) ) {
			$page_templates += $template;
		}

		return $page_templates;
	}
}

if ( ! function_exists( 'epic_get_category_option' ) ) {
	function epic_get_category_option( $value = null ) {
		$result = array();
		$count  = wp_count_terms( 'category' );

		if ( (int) $count <= epic_load_resource_limit() ) {
			$terms = get_categories( array( 'hide_empty' => 0 ) );
			foreach ( $terms as $term ) {
				$result[] = array(
					'value' => $term->term_id,
					'text'  => $term->name
				);
			}
		} else {
			$selected = $value;

			if ( ! empty( $selected ) ) {
				$terms = get_categories( array(
					'hide_empty'   => false,
					'hierarchical' => true,
					'include'      => $selected,
				) );

				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name
					);
				}
			}
		}

		return $result;
	}
}


if ( ! function_exists( 'epic_get_tag_option' ) ) {
	function epic_get_tag_option( $value = null ) {
		$result = array();
		$count  = wp_count_terms( 'post_tag' );

		if ( (int) $count <= epic_load_resource_limit() ) {
			$terms = get_tags( array( 'hide_empty' => 0 ) );
			foreach ( $terms as $term ) {
				$result[] = array(
					'value' => $term->term_id,
					'text'  => $term->name
				);
			}
		} else {
			$selected = $value;

			if ( ! empty( $selected ) ) {
				$terms = get_tags( array(
					'hide_empty'   => false,
					'hierarchical' => true,
					'include'      => $selected,
				) );

				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name
					);
				}
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'epic_get_author_option' ) ) {
	function epic_get_author_option( $value = null ) {
		$result  = array();
		$options = array_flip( epic_get_all_author() );

		if ( empty( $options ) ) {
			$values = explode( ',', $value );
			foreach ( $values as $val ) {
				if ( ! empty( $val ) ) {
					$user     = get_userdata( $val );
					$result[] = array(
						'value' => $val,
						'text'  => $user->display_name
					);
				}
			}
		} else {
			foreach ( $options as $key => $label ) {
				$result[] = array(
					'value' => $key,
					'text'  => $label,
				);
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'epic_get_post_option' ) ) {
	function epic_get_post_option( $value = null ) {
		$result = array();

		if ( ! empty( $value ) ) {
			$values = explode( ',', $value );

			foreach ( $values as $val ) {
				$result[] = array(
					'value' => $val,
					'text'  => get_the_title( $val )
				);
			}
		}

		return $result;
	}
}

add_action( 'wp_ajax_epic_get_category_option', 'epic_get_ajax_category_option' );
add_action( 'wp_ajax_epic_get_author_option', 'epic_get_ajax_author_option' );
add_action( 'wp_ajax_epic_get_tag_option', 'epic_get_ajax_tag_option' );
add_action( 'wp_ajax_epic_get_post_option', 'epic_get_ajax_post_option' );

function epic_get_ajax_category_option() {
	if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'epic_find_category' ) ) {
		$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
		wp_send_json_success( epic_get_category_option( $value ) );
	}
}

function epic_get_ajax_author_option() {
	if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'epic_find_author' ) ) {
		$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
		wp_send_json_success( epic_get_author_option( $value ) );
	}
}

function epic_get_ajax_tag_option() {
	if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'epic_find_tag' ) ) {
		$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
		wp_send_json_success( epic_get_tag_option( $value ) );
	}
}

function epic_get_ajax_post_option() {
	if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'epic_find_post' ) ) {
		$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
		wp_send_json_success( epic_get_post_option( $value ) );
	}
}

if ( ! function_exists( 'epic_module_post_share' ) ) {
	function epic_module_post_share( $output, $post, $instance, $items ) {

		if ( epic_get_option( 'show_block_meta_share' ) ) {
			$share_output = '';
			$share_items  = epic_get_option( 'show_block_meta_share_item' );

			if ( is_array( $share_items ) ) {
				foreach ( $share_items as $item ) {
					switch ( $item['social_icon'] ) {
						case 'facebook':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-facebook"><i class="fa fa-facebook-official"></i> <span>' . esc_html__( 'Facebook', 'epic-ne' ) . '</span></a>';
							break;

						case 'twitter':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-twitter"><i class="fa fa-twitter"></i> <span>' . esc_html__( 'Twitter', 'epic-ne' ) . '</span></a>';
							break;

						case 'googleplus':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-google-plus "><i class="fa fa-google-plus"></i> <span>' . esc_html__( 'Google+', 'epic-ne' ) . '</span></a>';
							break;

						case 'linkedin':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-linkedin "><i class="fa fa-linkedin"></i> <span>' . esc_html__( 'Linked In', 'epic-ne' ) . '</span></a>';
							break;

						case 'pinterest':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-pinterest "><i class="fa fa-pinterest"></i> <span>' . esc_html__( 'Pinterest', 'epic-ne' ) . '</span></a>';
							break;

						case 'tumblr':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-tumblr "><i class="fa fa-tumblr"></i> <span>' . esc_html__( 'Tumblr', 'epic-ne' ) . '</span></a>';
							break;

						case 'stumbleupon':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-stumbleupon "><i class="fa fa-stumbleupon"></i> <span>' . esc_html__( 'StumbleUpon', 'epic-ne' ) . '</span></a>';
							break;

						case 'whatsapp':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" data-action="share/whatsapp/share" target="_blank" class="jeg_btn-whatsapp "><i class="fa fa-whatsapp"></i> <span>' . esc_html__( 'WhatsApp', 'epic-ne' ) . '</span></a>';
							break;

						case 'email':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-email "><i class="fa fa-envelope"></i> <span>' . esc_html__( 'E-mail', 'epic-ne' ) . '</span></a>';
							break;

						case 'vk':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-vk "><i class="fa fa-vk"></i> <span>' . esc_html__( 'VK', 'epic-ne' ) . '</span></a>';
							break;

						case 'reddit':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-reddit "><i class="fa fa-reddit"></i> <span>' . esc_html__( 'Reddit', 'epic-ne' ) . '</span></a>';
							break;

						case 'wechat':
							$share_url = epic_get_social_share_url( $item['social_icon'], $post->ID );
							$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-wechat "><i class="fa fa-wechat"></i> <span>' . esc_html__( 'WeChat', 'epic-ne' ) . '</span></a>';
							break;
					}
				}
			}

			$share_output =
				'<div class="jeg_meta_share">
				<a href="#" ><i class="fa fa-share"></i></a>
				<div class="jeg_sharelist">
					' . $share_output . '
				</div>
			</div>';

			array_splice( $items, - 1, 0, $share_output );

			$output = implode( '', $items );
		}

		return $output;
	}

	add_filter( 'epic_module_post_meta_1', 'epic_module_post_share', 10, 4 );
	add_filter( 'epic_module_post_meta_2', 'epic_module_post_share', 10, 4 );
	add_filter( 'epic_module_post_meta_3', 'epic_module_post_share', 10, 4 );
}

if ( ! function_exists( 'epic_get_share_title' ) ) {
	function epic_get_share_title( $post_id ) {
		$title = get_the_title( $post_id );
		$title = html_entity_decode( $title, ENT_QUOTES, 'UTF-8' );
		$title = urlencode( $title );
		$title = str_replace( '#', '%23', $title );

		return esc_html( $title );
	}
}

if ( ! function_exists( 'epic_encode_url' ) ) {
	function epic_encode_url( $post_id ) {
		$url = get_permalink( $post_id );

		return urlencode( $url );
	}
}

if ( ! function_exists( 'epic_get_social_share_url' ) ) {
	function epic_get_social_share_url( $social, $post_id ) {
		$image     = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
		$image_url = $image ? $image[0] : '';
		$title     = epic_get_share_title( $post_id );
		$url       = apply_filters( 'jnews_get_permalink', epic_encode_url( $post_id ) );

		switch ( $social ) {
			case 'facebook' :
				$button_url = 'http://www.facebook.com/sharer.php?u=' . $url;
				break;
			case 'twitter' :
				$button_url = 'https://twitter.com/intent/tweet?text=' . $title . '&url=' . $url;
				break;
			case 'googleplus' :
				$button_url = 'https://plus.google.com/share?url=' . $url;
				break;
			case 'pinterest' :
				$button_url = 'https://www.pinterest.com/pin/create/bookmarklet/?pinFave=1&url=' . $url . '&media=' . $image_url . '&description=' . $title;
				break;
			case 'stumbleupon' :
				$button_url = 'http://www.stumbleupon.com/submit?url=' . $url . '&title=' . $title;
				break;
			case 'linkedin' :
				$button_url = 'https://www.linkedin.com/shareArticle?url=' . $url . '&title=' . $title;
				break;
			case 'reddit' :
				$button_url = 'https://reddit.com/submit?url=' . $url . '&title=' . $title;
				break;
			case 'tumblr' :
				$button_url = 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . $url . '&title=' . $title;
				break;
			case 'buffer' :
				$button_url = 'https://buffer.com/add?text=' . $title . '&url=' . $url;
				break;
			case 'vk' :
				$button_url = 'http://vk.com/share.php?url=' . $url;
				break;
			case 'whatsapp' :
				$button_url = 'whatsapp://send?text=' . $title . '%0A' . $url;
				break;
			case 'wechat' :
				// wechat only able to share post using qrcode
				// $button_url = 'weixin://dl/posts/link?url=' . $url;
				$button_url = 'https://chart.googleapis.com/chart?chs=400x400&cht=qr&choe=UTF-8&chl=' . $url;
				break;
			case 'line' :
				$button_url = 'line://msg/text/' . $url;
				break;
			case 'hatena' :
				$button_url = 'http://b.hatena.ne.jp/bookmarklet?url=' . $url . '&btitle=' . $title;
				break;
			case 'qrcode' :
				$button_url = 'https://chart.googleapis.com/chart?chs=400x400&cht=qr&choe=UTF-8&chl=' . $url;
				break;
			case 'email' :
				$button_url = 'mailto:?subject=' . $title . '&amp;body=' . $url;
				break;
			default:
				$button_url = $url;
				break;
		}

		return $button_url;
	}
}

/**
 * Sanitize Output
 */
if ( ! function_exists( 'jeg_sanitize_output' ) ) {
	function jeg_sanitize_output( $value ) {
		return $value;
	}
}
if ( ! function_exists('epic_check_other_plugin') ) {
	function epic_check_other_plugin(){
		if ( is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) ) {
			if ( ! function_exists( 'register_custom_post_type' ) ) {
				function register_custom_post_type( $post_types ) {
					$post_type = array(
						'tribe_events' => 'Events'
					);

					$post_types = array_merge( $post_types, $post_type );

					return $post_types;
				}

				add_filter( 'epic_get_enable_post_type', 'register_custom_post_type' );
			}

			if ( ! function_exists( 'register_custom_post_type' ) ) {
				function register_custom_taxonomy( $taxonomies, $post_type ) {
					$result = array();

					switch ( $post_type ) {
						case 'tribe_events':
							$result['tribe_events_cat'] = array(
								'name'       => 'Event Categories',
								'post_types' => $post_type
							);
							break;

						default:
							break;
					}

					$taxonomies = array_merge( $taxonomies, $result );

					return $taxonomies;
				}

				add_filter( 'epic_get_enable_custom_taxonomy', 'register_custom_taxonomy', 10, 2 );
			}
		}
	}
	add_action('admin_init', 'epic_check_other_plugin');
}

