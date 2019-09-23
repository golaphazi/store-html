<?php
namespace ElementPack\Modules\SinglePost\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Single_Post extends Widget_Base {

	public function get_name() {
		return 'bdt-single-post';
	}

	public function get_title() {
		return esc_html__( 'Single Post', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-post';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$post_list = get_posts(['numberposts' => 50]);

		$post_list_options = ['0' => esc_html__( 'Select Post', 'bdthemes-element-pack' ) ];

		foreach ( $post_list as $list ) :
			$post_list_options[ $list->ID ] = $list->post_title;
		endforeach;

		$this->add_control(
			'post_list',
			[
				'label'   => esc_html__( 'Post Name', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $post_list_options,
				'default' => ['0'],
			]
		);

		$this->add_control(
			'show_tag',
			[
				'label'   => esc_html__( 'Tag', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'link_title',
			[
				'label'   => esc_html__( 'Link Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'   => esc_html__( 'Date', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'   => esc_html__( 'Category', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tag',
			[
				'label'     => esc_html__( 'Tag', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_tag' => 'yes',
				],
			]
		);

		$this->add_control(
			'tag_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-single-post .bdt-single-post-tag-wrap span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-single-post .bdt-single-post-tag-wrap span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'tag_border',
				'label'    => __( 'Border', 'bdthemes-element-pack' ),
				'selector' => '{{WRAPPER}} .bdt-single-post .bdt-single-post-tag-wrap span',
			]
		);

		$this->add_control(
			'tag_border_radius',
			[
				'label' => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-single-post .bdt-single-post-tag-wrap span' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tag_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-single-post .bdt-single-post-tag-wrap span',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-single-post .bdt-single-post-title' => 'color: {{VALUE}};',
				],
				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-single-post .bdt-single-post-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_date',
			[
				'label'     => esc_html__( 'Date', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'     => esc_html__( 'Date Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e5e5e5',
				'selectors' => [
					'{{WRAPPER}} .bdt-single-post .bdt-single-post-meta span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'date_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-single-post .bdt-single-post-meta span',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_category',
			[
				'label'     => esc_html__( 'Category', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'     => esc_html__( 'Category Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e5e5e5',
				'selectors' => [
					'{{WRAPPER}} .bdt-single-post .bdt-single-post-meta a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-single-post .bdt-single-post-meta a',
			]
		);

		$this->add_control(
			'meta_separator_color',
			[
				'label'     => esc_html__( 'Meta Separator Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .bdt-subnav-divider > :nth-child(n+2):not(.bdt-first-column)::before' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_overlay',
			[
				'label' => esc_html__( 'Overlay', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-single-post .bdt-overlay-primary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		$id       = $this->get_id();
		$the_post = get_post( $settings['post_list'] );

		if ($the_post) {		

			$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $the_post->ID ), 'large' ); ?>

			<div id="bdt-single-post-<?php echo esc_attr($id); ?>" class="bdt-single-post">
		  		<div class="bdt-single-post-item">
		  			<div class="bdt-single-post-thumbnail-wrap bdt-position-relative">
		  				<div class="bdt-single-post-thumbnail">
		  					<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_html($the_post->post_title) ; ?>">
			  					<img src="<?php echo esc_url($post_thumbnail[0]); ?>" alt="<?php echo esc_html($the_post->post_title) ; ?>">
			  				</a>
		  				</div>
		  				<div class="bdt-overlay-primary bdt-position-cover"></div>
				  		<div class="bdt-single-post-desc bdt-text-center bdt-position-center bdt-position-medium bdt-position-z-index">
							<?php if ($settings['show_tag']) : ?>
								<div class="bdt-single-post-tag-wrap">
			                		<?php
									$tags_list = get_the_tag_list( '<span class="bdt-background-primary">', '</span> <span class="bdt-background-primary">', '</span>', $the_post->ID);
				                		if ($tags_list) :
				                    		echo  wp_kses_post($tags_list);
				                		endif; ?>
			                	</div>
							<?php endif ?>

							<?php if ($settings['show_title']) : ?>

								<?php if ($settings['link_title']) : ?>
									<a href="<?php echo esc_url(get_permalink($the_post->ID)); ?>" class="bdt-single-post-link" title="<?php echo esc_html($the_post->post_title) ; ?>">
								<?php endif; ?>									

										<h2 class="bdt-single-post-title bdt-margin-small-top"><?php echo esc_html($the_post->post_title) ; ?></h2>

								<?php if ($settings['link_title']) : ?>									
									</a>
								<?php endif; ?>		

							<?php endif ?>

			            	<?php if ($settings['show_category'] or $settings['show_date']) : ?>

								<div class="bdt-single-post-meta bdt-flex-center bdt-subnav bdt-subnav-divider">
									<?php if ($settings['show_category']) : ?>
										<?php echo '<span>'.get_the_category_list(', ', '', $the_post->ID).'</span>'; ?>
									<?php endif ?>

									<?php if ($settings['show_date']) : ?>
										<?php echo '<span>'.esc_attr(get_the_date('d F Y', $the_post->ID)).'</span>'; ?>
									<?php endif ?>
								</div>

							<?php endif ?>
				  		</div>
					</div>
				</div>
			</div>

	 	<?php 		
		} else {
			echo '<div class="bdt-alert-warning" bdt-alert>Oops! You did not select any post from settings.</div>';
		}

	}
}
