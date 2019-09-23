<?php
namespace ElementPack\Modules\PostSlider\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Hazel extends Elementor_Skin_Base {
	public function get_id() {
		return 'bdt-hazel';
	}

	public function get_title() {
		return __( 'Hazel', 'bdthemes-element-pack' );
	}

	public function render_loop_item() {
		$settings         = $this->parent->get_settings();
		$slider_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

		?>
		<div class="bdt-post-slider-item">
			<div class="bdt-grid bdt-grid-collapse" bdt-grid>
				<div class="bdt-position-relative bdt-width-1-2 bdt-width-2-3@m bdt-post-slider-thumbnail">
					
					<img src="<?php echo esc_url($slider_thumbnail[0]); ?>" alt="<?php echo get_the_title(); ?>" class="bdt-post-slider-match-height">
					
				</div>

				<div class="bdt-width-1-2 bdt-width-1-3@m">
					<div class="bdt-post-slider-content bdt-background-secondary bdt-post-slider-match-height">

			            <?php if ($settings['show_tag']) : ?>
			        		<?php $tags_list = get_the_tag_list('<span class="bdt-background-primary">','</span> <span class="bdt-background-primary">','</span>'); ?>
			        		<?php if ($tags_list) : ?> 
			            		<div class="bdt-post-slider-tag-wrap"><?php  echo  wp_kses_post($tags_list); ?></div>
			            	<?php endif; ?>
			            <?php endif; ?>

						<?php $this->render_title(); ?>

						<?php if ($settings['show_meta']) : ?>
							<div class="bdt-post-slider-meta bdt-flex-inline bdt-flex-middile">
								<span><?php echo esc_attr(get_the_author()); ?></span> 
								<span><?php esc_html_e('On', 'bdthemes-element-pack'); ?> <?php echo esc_attr(get_the_date('M d, Y')); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( 'yes' == $this->parent->get_settings( 'show_text' ) ) : ?> 
							<?php $this->render_excerpt(); ?>
							<?php $this->render_read_more_button(); ?>
						<?php else : ?>
							<?php $this->render_content(); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function render_excerpt() {
		if ( ! $this->parent->get_settings( 'show_text' ) ) {
			return;
		}

		?>
		<div class="bdt-post-slider-text bdt-visible@m" bdt-slideshow-parallax="x: 500,-500">
			<?php echo \element_pack_helper::custom_excerpt(intval($this->parent->get_settings( 'excerpt_length' ))); ?>
		</div>
		<?php
	}

	public function render_header() {
		$settings = $this->parent->get_settings();
		$id       = 'bdt-post-slider-' . $this->parent->get_id();

		$ratio = ($settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'].":".$settings['slider_size_ratio']['height'] : '';

	    $this->parent->add_render_attribute(
			[
				'slider-settings' => [
					'id'    => esc_attr($id),
					'class' => [
						'bdt-post-slider',
						'bdt-post-slider-skin-hazel',
						'bdt-position-relative'
					],
					'bdt-slideshow' => [
						wp_json_encode(array_filter([
							'animation'         => $settings['slider_animations'],
							'min-height'        => $settings['slider_min_height']['size'],
							'max-height'        => $settings['slider_max_height']['size'],
							'ratio'             => $ratio,
							'autoplay'          => $settings['autoplay'],
							'autoplay-interval' => $settings['autoplay_interval'],
							'pause-on-hover'    => $settings['pause_on_hover']
						]))
					],
					'bdt-height-match' => '.bdt-post-slider-match-height'
				]
			]
		);
	    
		?>
		<div <?php echo ( $this->parent->get_render_attribute_string( 'slider-settings' ) ); ?>>
			<div class="bdt-slideshow-items bdt-child-width-1-1 bdt-post-slider-match-height">
		<?php
	}

	public function render_title() {
		if ( ! $this->parent->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->parent->get_settings( 'title_tag' );

		?>
		<div class="bdt-post-slider-title-wrap">
			<a href="<?php echo esc_url(get_permalink()); ?>">
				<<?php echo $tag ?> class="bdt-post-slider-title bdt-margin-remove-bottom">
					<?php the_title() ?>
				</<?php echo $tag ?>>
			</a>
		</div>
		<?php
	}

	public function render_footer() {
		?>

			</div>
			<?php $this->render_navigation(); ?>			
		</div>
		
		<?php
	}

	public function render_navigation() {
		$id = $this->parent->get_id();

		?>
		<div id="<?php echo $id; ?>_nav"  class="bdt-post-slider-navigation bdt-position-bottom-right bdt-width-1-2 bdt-width-1-3@m">
			<div class="bdt-post-slider-navigation-inner bdt-grid bdt-grid-collapse">
				<a class="bdt-hidden-hover bdt-width-1-2" href="#" bdt-slideshow-item="previous">
					<svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
						<polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
					</svg>
					<span class="bdt-slider-nav-text"><?php esc_html_e( 'PREV', 'bdthemes-element-pack' ) ?></span></a>
				<a class="bdt-hidden-hover bdt-width-1-2" href="#" bdt-slideshow-item="next">
					<span class="bdt-slider-nav-text"><?php esc_html_e( 'NEXT', 'bdthemes-element-pack' ) ?></span>
					<svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
						<polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "></polyline>
					</svg>
				</a>
			</div>
		</div>
		<?php
	}

	public function render_content() {
		?>
		<div class="bdt-post-slider-text bdt-visible@m">
			<?php the_content(); ?>
		</div>
		<?php
	}

	public function render_read_more_button() {
		if ( ! $this->parent->get_settings( 'show_button' ) ) {
			return;
		}
		$settings  = $this->parent->get_settings();
		$animation = ($settings['button_hover_animation']) ? ' elementor-animation-'.$settings['button_hover_animation'] : '';
		?>
		<div class="bdt-post-slider-button-wrap">
			<a href="<?php echo esc_url(get_permalink()); ?>" class="bdt-post-slider-button bdt-display-inline-block<?php echo esc_attr($animation); ?>">
				<?php echo esc_attr($this->parent->get_settings( 'button_text' )); ?>

				<?php if ($settings['icon']) : ?>
					<span class="bdt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
						<i class="<?php echo esc_attr($settings['icon']); ?>"></i>
					</span>
				<?php endif; ?>
			</a>
		</div>
		<?php
	}

	public function render() {
		$this->parent->query_posts();

		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->render_header();

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();
			$this->render_loop_item();
		}

		$this->render_footer();

		wp_reset_postdata();
	}
}