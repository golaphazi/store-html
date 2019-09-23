<?php
namespace ElementPack\Modules\Carousel\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;


use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Alice extends Elementor_Skin_Base {
	public function get_id() {
		return 'bdt-alice';
	}

	public function get_title() {
		return __( 'Alice', 'bdthemes-element-pack' );
	}

	public function render() {
		$this->parent->query_posts();

		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this->parent, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this->parent, 'filter_excerpt_length' ], 20 );

		$this->parent->get_posts_tags();

		$this->parent->render_header("alice");

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post();
		}

		$this->parent->render_footer();

		remove_filter( 'excerpt_length', [ $this->parent, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this->parent, 'filter_excerpt_more' ], 20 );

		wp_reset_postdata();
	}

	public function render_image($image_id, $size) {

		$image_src = wp_get_attachment_image_src( $image_id, $size );

		if ( ! $image_src ) {
			return;
		}

		?>
		<div class="bdt-carousel-thumbnail bdt-overflow-hidden">
			<a href="<?php echo esc_url(get_permalink()); ?>" class="bdt-background-cover">
				<img src="<?php echo esc_url($image_src[0]); ?>" alt="" class="bdt-transition-scale-up bdt-transition-opaque">
			</a>
		</div>
		<?php
	}

	public function render_loop_header() {
		$this->parent->add_render_attribute(
			[
				'carousel-item' => [
					'class' => [
						'bdt-carousel-item',
						'swiper-slide',
						'bdt-transition-toggle',
						'bdt-position-relative',
					],
				],
			]
		);

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'carousel-item' ); ?>>
		<?php
	}

	public function render_category() {
		?>
		<span class="bdt-carousel-categories"><?php echo get_the_category_list(', '); ?></span>
		<?php 
	}

	public function render_date() {
		?>
		<span class="bdt-carousel-date bdt-transition-slide-bottom"><?php echo apply_filters( 'the_date', get_the_date('M j, Y'), get_option( 'date_format' ), '', '' ); ?></span>
		<?php 
	}

	public function render_post() {
		$settings = $this->parent->get_settings();
		global $post;

		$this->render_loop_header();

		$this->render_image(get_post_thumbnail_id( $post->ID ), $image_size = 'full' );

		?>
		<div class="bdt-custom-overlay bdt-position-cover"></div>
		<div class="bdt-post-grid-desc bdt-position-center">
		<?php

		$this->parent->render_overlay_header();
		$this->render_category();
		$this->parent->render_title();
		$this->render_date();
		$this->parent->render_overlay_footer();
		?>
		</div>
		<?php

		$this->parent->render_post_footer();
	}
}

