<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Util;

Class Cache {

	/**
	 * Handle cache for term
	 *
	 * @param $terms
	 */
	public static function cache_term( $terms ) {
		foreach ( $terms as $term ) {
			wp_cache_add( $term->term_id, $term, 'terms' );
		}
	}

	/**
	 * Get all users
	 *
	 * @return array|bool|mixed
	 */
	public static function get_users() {
		if ( ! $users = wp_cache_get( 'users', 'epic-ne' ) ) {
			$users = get_users();
			wp_cache_set( 'users', $users, 'epic-ne' );
		}

		return $users;
	}

	/**
	 * Get the total of users
	 *
	 * @return array|bool|mixed
	 */
	public static function get_count_users() {
		if ( ! $count = wp_cache_get( 'count_users', 'epic-ne' ) ) {
			$count = count_users();
			wp_cache_set( 'count_users', $count, 'epic-ne' );
		}

		return $count;
	}

	/**
	 * Get all categories
	 *
	 * @return array|bool|mixed
	 */
	public static function get_categories() {
		if ( ! $categories = wp_cache_get( 'categories', 'epic-ne' ) ) {
			$categories = get_categories( array( 'hide_empty' => 0 ) );
			wp_cache_set( 'categories', $categories, 'epic-ne' );
			self::cache_term( $categories );
		}

		return $categories;
	}

	/**
	 * Get the total of categories
	 *
	 * @return array|bool|int|mixed|\WP_Error
	 */
	public static function get_categories_count() {
		if ( ! $count = wp_cache_get( 'categories_count', 'epic-ne' ) ) {
			$count = wp_count_terms( 'category' );
			wp_cache_set( 'categories_count', $count, 'epic-ne' );
		}

		return $count;
	}

	/**
	 * Get all tags
	 *
	 * @return array|bool|mixed
	 */
	public static function get_tags() {
		if ( ! $tags = wp_cache_get( 'tags', 'epic-ne' ) ) {
			$tags = get_tags( array( 'hide_empty' => 0 ) );
			wp_cache_set( 'tags', $tags, 'epic-ne' );
			self::cache_term( $tags );
		}

		return $tags;
	}

	/**
	 * Get the total of tags
	 *
	 * @return array|bool|int|mixed|\WP_Error
	 */
	public static function get_tags_count() {
		if ( ! $count = wp_cache_get( 'tags_count', 'epic-ne' ) ) {
			$count = wp_count_terms( 'post_tag' );
			wp_cache_set( 'tags_count', $count, 'epic-ne' );
		}

		return $count;
	}

	/**
	 * Get all menus
	 *
	 * @return array|bool|mixed
	 */
	public static function get_menu() {
		if ( ! $menu = wp_cache_get( 'menu', 'epic-ne' ) ) {
			$menu = wp_get_nav_menus();
			wp_cache_set( 'menu', $menu, 'epic-ne' );
		}

		return $menu;
	}

	/**
	 * Get all post types
	 *
	 * @return array|bool|mixed
	 */
	public static function get_post_type() {
		if ( ! $post_type = wp_cache_get( 'post_type', 'epic-ne' ) ) {
			$post_type = get_post_types( array(
				'public'  => true,
				'show_ui' => true
			) );
			wp_cache_set( 'post_type', $post_type, 'epic-ne' );
		}

		return $post_type;
	}

	/**
	 * Get all excluded post types
	 *
	 * @return array|bool|mixed
	 */
	public static function get_exclude_post_type() {
		if ( ! $post_type = wp_cache_get( 'exclude_post_type', 'epic-ne' ) ) {
			$post_types = self::get_post_type();
			$result     = array();

			$exclude_post_type = array(
				'attachment',
				'custom-post-template',
				'archive-template',
				'elementor_library'
			);

			foreach ( $post_types as $type ) {
				if ( ! in_array( $type, $exclude_post_type ) ) {
					$result[ $type ] = get_post_type_object( $type )->label;
				}
			}

			$post_type = $result;

			wp_cache_set( 'exclude_post_type', $post_type, 'epic-ne' );
		}

		return $post_type;
	}

	/**
	 * Get all enabled custom taxonomies
	 *
	 * @return array|bool|mixed
	 */
	public static function get_enable_custom_taxonomies() {
		if ( ! $result = wp_cache_get( 'enable_custom_taxonomies', 'epic-ne' ) ) {
			$result     = array();
			$post_types = epic_get_enable_post_type();

			unset( $post_types['page'] );

			if ( ! empty( $post_types ) ) {

				foreach ( $post_types as $post_type => $label ) {

					$taxonomies = get_object_taxonomies( $post_type );

					if ( ! empty( $taxonomies ) && is_array( $taxonomies ) ) {

						foreach ( $taxonomies as $taxonomy ) {

							$taxonomy_data = get_taxonomy( $taxonomy );

							if ( $taxonomy_data->show_in_menu ) {
								$result[ $taxonomy ] = array(
									'name' => $taxonomy_data->labels->name,
									'post_types' => $taxonomy_data->object_type
								);
							}
						}
					}
							$result = apply_filters('epic_get_enable_custom_taxonomy', $result, $post_type);
				}
			}

			unset( $result['category'] );
			unset( $result['post_tag'] );

			wp_cache_set( 'enable_custom_taxonomies', $result, 'epic-ne' );
		}

		return $result;
	}
}
