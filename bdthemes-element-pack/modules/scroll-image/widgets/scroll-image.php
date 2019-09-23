<?php
namespace ElementPack\Modules\ScrollImage\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Scroll_Image extends Widget_Base {

	public function get_name() {
		return 'bdt-scroll-image';
	}

	public function get_title() {
		return esc_html__( 'Scroll Image', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-import-export';
	}

	public function get_categories() {
	 	return [ 'element-pack' ];
 	}

 	public function get_script_depends() {
		return [ 'bdt-uikit-icons' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => __( 'Choose Image', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				'default'   => 'large',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'max_width',
			[
				'label' => __( 'Width', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'step' => 10,
						'min'  => 1,
						'max'  => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'min_height',
			[
				'label' => __( 'Min Height', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'step' => 10,
						'min'  => 1,
						'max'  => 1200,
					],
				],
				'default' => [
					'size' => 320,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'caption',
			[
				'label'       => __( 'Caption', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your image caption', 'bdthemes-element-pack' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label'   => __( 'Link To', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'lightbox',
				'options' => [
					'lightbox' => __( 'Lightbox', 'bdthemes-element-pack' ),
					'external' => __( 'External', 'bdthemes-element-pack' ),
					''         => __( 'None', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'external_link',
			[
				'label'         => __( 'External Link', 'bdthemes-element-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'placeholder'   => __( 'https://your-link.com', 'bdthemes-element-pack' ),
				'default'       => [
					'url' => '#',
				],
				'condition' => [
					'link_to' => 'external',
				],
			]
		);

		$this->add_control(
			'link_icon',
			[
				'label'   => __( 'Choose Link Icon', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'link' => [
						'title' => __( 'Link', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-link',
					],
					'plus' => [
						'title' => __( 'Plus', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-plus',
					],
					'search' => [
						'title' => __( 'Zoom', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-search',
					],
				],
				'default' => 'link',
				'condition' => [
					'link_to!' => '',
				],
			]
		);

		$this->add_control(
			'link_icon_position',
			[
				'label'     => __( 'Link Icon', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => element_pack_position(),
				'default'   => 'top-left',
				'condition' => [
					'link_to!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'transition_duration',
			[
				'label'   => __( 'Transition Duration', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 2,
				],
				'range' => [
					'px' => [
						'step' => 0.1,
						'min'  => 0.1,
						'max'  => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image' => 'transition: background-position {{SIZE}}s ease-in-out;-webkit-transition: background-position {{SIZE}}s ease-in-out;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border',
				'selector'  => '{{WRAPPER}} .bdt-scroll-image',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-scroll-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'image_shadow',
				'exclude' => [
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .bdt-scroll-image',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label'     => __( 'Caption', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption!' => '',
				],
			]
		);

		$this->add_control(
			'caption_align',
			[
				'label'   => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'caption_border',
				'label'       => __( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-scroll-image-caption',
			]
		);

		$this->add_responsive_control(
			'caption_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-scroll-image-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'caption_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-scroll-image-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-scroll-image-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .bdt-scroll-image-caption',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label'      => esc_html__( 'Icon Style', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'link_to',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'link_icon',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'step' => 10,
						'min'  => 2,
						'max'  => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-container .bdt-icon svg' => 'height: {{SIZE}}px; width: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-container .bdt-icon'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-container .bdt-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-scroll-image-container .bdt-icon',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-scroll-image-container .bdt-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-scroll-image-container .bdt-icon',
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-scroll-image-container .bdt-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-scroll-image-container .bdt-icon',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-container .bdt-icon:hover'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-container .bdt-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-scroll-image-container .bdt-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render_image($settings) {
		$image_url = Group_Control_Image_Size::get_attachment_image_src($settings['image']['id'], 'image_size', $settings);

		if ( ! $image_url ) {
			$image_url = $settings['image']['url'];
		}
		
		$this->add_render_attribute('image', 'class', 'bdt-scroll-image');
		$this->add_render_attribute('image', 'style', 'background-image: url(' . esc_url($image_url) . ');');

		?>
		<div <?php echo $this->get_render_attribute_string( 'image' ); ?>></div>
		<?php

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$has_caption = ! empty( $settings['caption'] );

		$this->add_render_attribute( 'wrapper', 'class', 'bdt-scroll-image-holder' );

		if ('' !== $settings['link_to']) {
			
			if ('lightbox' == $settings['link_to']) {
				$link = $settings['image']['url'];
				$this->add_render_attribute( 'link', 'data-elementor-open-lightbox', 'no');
				$this->add_render_attribute( 'link', 'class', 'bdt-scroll-image-lightbox-item');
			} else {
				$link = $settings['external_link']['url'];
			}

			$this->add_render_attribute( 'link', 'href', esc_url($link));

			if ($settings['link_icon']) {
				$this->add_render_attribute( 'link', [
					'class'    => 'bdt-icon bdt-position-small bdt-position-' . esc_attr($settings['link_icon_position']),
					'bdt-icon' =>'icon: ' . esc_attr($settings['link_icon']) . '; ratio: 1.6;',
				]);
			}
		}

		if ('lightbox' === $settings['link_to']) {
			$this->add_render_attribute('container', 'bdt-lightbox', 'toggle: .bdt-scroll-image-lightbox-item; animation: slide;');
		}

		$this->add_render_attribute( 'container', 'class', 'bdt-scroll-image-container' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
			<?php if (('' !== $settings['link_to']) and ('' == $settings['link_icon'])): ?>
				<a target="_blank" <?php echo $this->get_render_attribute_string( 'link' ); ?>>
			<?php endif; ?>

				<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
					<?php if ( $has_caption ) : ?>
						<figure class="wp-caption">
					<?php endif; ?>
					
						<?php $this->render_image($settings); ?>

						<?php if (('' !== $settings['link_to']) and ('' !== $settings['link_icon'])) : ?>
							<a target="_blank" <?php echo $this->get_render_attribute_string( 'link' ); ?>></a>
						<?php endif; ?>

					<?php if ( $has_caption ) : ?>
							<figcaption class="bdt-scroll-image-caption bdt-caption-text"><?php echo $settings['caption']; ?></figcaption>
						</figure>
					<?php endif; ?>
				</div>

			<?php if (('' !== $settings['link_to']) and ('' == $settings['link_icon'])): ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}

	protected function _content_template() {
		?>
		<# if ( settings.image.url ) {
			var image = {
				id        : settings.image.id,
				url       : settings.image.url,
				size      : settings.image_size,
				dimension : settings.image_custom_dimension,
				model     : view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );
			var link_url = '';

			if ( ! image_url ) {
				return;
			}

			view.addRenderAttribute( 'wrapper', 'class', [ 'elementor-image', 'bdt-scroll-image-holder' ] );

			var hasCaption = '' !== settings.caption;

			if ('' !== settings.link_to) {

				if ('lightbox' == settings.link_to) {
					link_url = image_url;
					view.addRenderAttribute( 'link', 'data-elementor-open-lightbox', 'yes' );
				} else {
					link_url = settings.external_link.url;
				}

				view.addRenderAttribute( 'link', 'href', 'link_url' );

				if ('' !== settings.link_icon) {
					view.addRenderAttribute( 'link', 'class', ['bdt-icon', 'bdt-position-small', 'bdt-position-' + settings.link_icon_position] );
					view.addRenderAttribute( 'link', 'bdt-icon', 'icon: ' + settings.link_icon + '; ratio: 1.6;' );
				}
			}

			var link_print    = view.getRenderAttributeString( 'link' );
			var wrapper_print = view.getRenderAttributeString( 'wrapper' );

			#>
			<div class="bdt-scroll-image-container">
				<# if (('' !== settings.link_to) && ('' == settings.link_icon)) { #>
					<a target="_blank" <# print(link_print); #>>
				<# } #>

					<div <# print(wrapper_print); #>>

					<# if ( hasCaption ) { #>
						<figure class="wp-caption">
					<# } #>

						<div class="bdt-scroll-image" style="background-image: url('{{{image_url}}}');"></div>

						<# if (('' !== settings.link_to) && ('' !== settings.link_icon)) { #>
							<a target="_blank" <# print(link_print); #>></a>
						<# } #>

					<# if ( hasCaption ) { #>
							<figcaption class="bdt-scroll-image-caption bdt-caption-text">{{{ settings.caption }}}</figcaption>
						</figure>
					<# } #>

					</div>

				<# if (('' !== settings.link_to) && ('' == settings.link_icon)) { #>
					<a target="_blank" <# print(link_print); #>>
				<# } #>
			</div>
		<# } #>
		<?php
	}
}
