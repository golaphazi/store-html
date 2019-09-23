<?php
namespace ElementPack\Modules\PostList\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post_List extends Widget_Base {

	public function get_name() {
		return 'bdt-post-list';
	}

	public function get_title() {
		return esc_html__( 'Post List', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-post-list';
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

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_horizontal',
			[
				'label' => esc_html__( 'Horizontal Layout', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'column',
			[
				'label'       => esc_html__( 'Column', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => 'For good looking set it 1 for default skin and 2 for another skin',
				'options'     => [
					'2' => esc_html__( 'Two', 'bdthemes-element-pack' ),
					'3' => esc_html__( 'Three', 'bdthemes-element-pack' ),
					'4' => esc_html__( 'Four', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'show_horizontal' => 'yes',
				],
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

		$this->add_control(
			'show_divider',
			[
				'label'   => esc_html__( 'Divider', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'space_between',
			[
				'label'      => esc_html__( 'Space Between', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'separator' => 'before',
				'selectors' => [
				'{{WRAPPER}} .bdt-post-list .bdt-list > li:nth-child(n+2)' => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: {{SIZE}}{{UNIT}};',					
				'{{WRAPPER}} .bdt-post-list .bdt-child-width-1-3\@m li:nth-child(n+4)' => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: 0;',		
				'{{WRAPPER}} .bdt-post-list .bdt-child-width-1-2\@m li:nth-child(n+3)' => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: 0;',		
				'{{WRAPPER}} .bdt-post-list .bdt-child-width-1-4\@m li:nth-child(n+5)' => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: 0;',

				'{{WRAPPER}} .bdt-post-list .bdt-child-width-1-2\@m li:nth-child(n+3) > div' => 'padding-top: {{SIZE}}{{UNIT}};',				
				'{{WRAPPER}} .bdt-post-list .bdt-child-width-1-3\@m li:nth-child(n+4) > div' => 'padding-top: {{SIZE}}{{UNIT}};',				
				'{{WRAPPER}} .bdt-post-list .bdt-child-width-1-4\@m li:nth-child(n+5) > div' => 'padding-top: {{SIZE}}{{UNIT}};',					
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => esc_html__( 'Show All', 'bdthemes-element-pack' ),
					'by_name' => esc_html__( 'Manual Selection', 'bdthemes-element-pack' ),
				],
			]
		);

		$post_categories = get_terms( 'category' );

		$post_options = [];
		foreach ( $post_categories as $category ) {
			$post_options[ $category->slug ] = $category->name;
		}

		$this->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $post_options,
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'posts_limit',
			[
				'label'   => esc_html__( 'Posts Limit', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'     => esc_html__( 'Date', 'bdthemes-element-pack' ),
					'title'    => esc_html__( 'Title', 'bdthemes-element-pack' ),
					'category' => esc_html__( 'Category', 'bdthemes-element-pack' ),
					'rand'     => esc_html__( 'Random', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'bdthemes-element-pack' ),
					'ASC'  => esc_html__( 'Ascending', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_list',
			[
				'label' => esc_html__( 'List Style', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'list_layout_image_size',
			[
				'label' => esc_html__( 'Image Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 64,
						'max'  => 150,
						'step' => 10,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-post-list .list-part .bdt-post-list-thumbnail img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_control(
			'list_layout_title_category',
			[
				'label' => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'list_layout_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-list .list-part .bdt-post-list-title .bdt-post-list-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-post-list .list-part .bdt-post-list-title .bdt-post-list-link',

			]
		);

		$this->add_control(
			'date_heading',
			[
				'label'     => esc_html__( 'Date', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_date' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'     => esc_html__( 'Date Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-list .list-part .bdt-post-list-meta span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_date' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'date_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-post-list .list-part .bdt-post-list-meta span',
				'condition' => [
					'show_date' => 'yes',
				],
				
			]
		);

		$this->add_control(
			'category_heading',
			[
				'label'     => esc_html__( 'Category', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_category' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'     => esc_html__( 'Category Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-list .list-part .bdt-post-list-meta a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'category_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-post-list .list-part .bdt-post-list-meta a',
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-post-list .bdt-has-divider li > div'             => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-post-list .bdt-list-divider > li:nth-child(n+2)' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'show_divider' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'featured_excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render() {
		global $post;

		$settings = $this->get_settings();
		$id       = $this->get_id();
		

		if ( $settings['show_horizontal'] ) {
			$this->add_render_attribute('list-wrapper', 'bdt-grid', '' );
			$this->add_render_attribute('list-wrapper', 'class', ['bdt-grid', 'bdt-child-width-1-' . $settings['column'] . '@m'] );
		} else {
			$this->add_render_attribute('list-wrapper', 'class', ['bdt-list', 'bdt-list-large'] );
		}

		$this->add_render_attribute('list-wrapper', 'class', ['bdt-post-list-item', 'list-part'] );

		if ( $settings['show_divider'] ) {
			if ( $settings['show_horizontal'] ) {
				$this->add_render_attribute('list-wrapper', 'class', 'bdt-has-divider' );
			} else {
				$this->add_render_attribute('list-wrapper', 'class', 'bdt-list-divider' );
			}
		}

		$args = array(
			'posts_per_page' => $settings['posts_limit'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'post_status'    => 'publish'
		);
		
		if ( 'by_name' === $settings['source'] ) :
			$args['tax_query'][] = array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $settings['post_categories'],
			);
		endif;

		$wp_query = new \WP_Query($args);

		if( $wp_query->have_posts() ) :

			add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
			add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

			?> 
			<div id="bdt-post-list-<?php echo esc_attr($id); ?>" class="bdt-post-list bdt-post-list-skin-base">
		  		<div bdt-scrollspy="cls: bdt-animation-fade; target: > ul > .bdt-post-list-item; delay: 350;">
		  			<ul <?php echo $this->get_render_attribute_string('list-wrapper'); ?>>
						<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
							<?php $post_thumbnail  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
				  			<li <?php echo $this->get_render_attribute_string('list'); ?>>
					  			<div class="bdt-post-list-item-inner">
						  			<div class="bdt-grid bdt-grid-small" bdt-grid>
						  				<div class="bdt-post-list-thumbnail bdt-width-auto">
						  					<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
							  					<img src="<?php echo esc_url($post_thumbnail[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
							  				</a>
						  				</div>
								  		<div class="bdt-post-list-desc bdt-width-expand">
											<?php if ($settings['show_title']) : ?>
												<h4 class="bdt-post-list-title">
													<a href="<?php echo esc_url(get_permalink()); ?>" class="bdt-post-list-link" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()) ; ?></a>
												</h4>
											<?php endif ?>

							            	<?php if ($settings['show_category'] or $settings['show_date']) : ?>

												<div class="bdt-post-list-meta bdt-subnav">
													<?php if ($settings['show_date']) : ?>
														<?php echo '<span>'.esc_attr(get_the_date('d F Y')).'</span>'; ?>
													<?php endif ?>

													<?php if ($settings['show_category']) : ?>
														<?php echo '<span>'.get_the_category_list(', ').'</span>'; ?>
													<?php endif ?>
													
												</div>

											<?php endif ?>
								  		</div>
									</div>
								</div>
							</li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</ul>
				</div>
			</div>
		
		 	<?php 
			remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
			remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		endif;
	}
}