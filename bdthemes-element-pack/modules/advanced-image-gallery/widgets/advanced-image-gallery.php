<?php
namespace ElementPack\Modules\AdvancedImageGallery\Widgets;

use Elementor\Widget_Base;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Image_Gallery extends Widget_Base {
	public $lightbox_slide_index;

	public function get_name() {
		return 'bdt-advanced-image-gallery';
	}

	public function get_title() {
		return esc_html__( 'Advanced Image Gallery', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'bdt-uikit-icons', 'tilt' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_gallery',
			[
				'label' => __( 'Image Gallery', 'bdthemes-element-pack' ),
			]
		);
		
		$this->add_control(
			'gallery_layout',
			[
				'label'   => esc_html__( 'Layout', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'options' => [
					'standard' => esc_html__('Standard', 'bdthemes-element-pack'),
					'hidden'   => esc_html__('Hidden', 'bdthemes-element-pack'),
				],
			]
		);

		$this->add_control(
			'avd_gallery_images',
			[
				'label'   => __( 'Add Images', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::GALLERY,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'exclude'   => [ 'custom' ],
				'condition' => ['gallery_layout' => 'standard'],
			]
		);

		$this->add_control(
			'masonry',
			[
				'label'     => esc_html__( 'Masonry', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => ['gallery_layout' => 'standard'],
			]
		);

		$this->add_responsive_control(
			'item_ratio',
			[
				'label'   => esc_html__( 'Image Height', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 265,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'#bdt-avdg-{{ID}} .bdt-gallery-thumbnail img' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'masonry!'       => 'yes',
					'gallery_layout' => 'standard',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_custom_gallery_layout',
			[
				'label'     => esc_html__( 'Layout', 'bdthemes-element-pack' ),
				'condition' => ['gallery_layout' => 'standard'],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '3',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery.bdt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-advanced-image-gallery.bdt-grid > *' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery.bdt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-advanced-image-gallery.bdt-grid > *' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'show_lightbox',
			[
				'label'   => esc_html__( 'Show Lightbox', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_caption',
			[
				'label'       => esc_html__( 'Show Caption', 'bdthemes-element-pack' ),
				'description' => esc_html__( 'Make sure you set the caption in gallery images when you insert.', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => esc_html__('Icon', 'bdthemes-element-pack'),
					'text' => esc_html__('Text', 'bdthemes-element-pack'),
				],
				'condition' => [
					'show_lightbox' => 'yes',
				]
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-gallery-item-link .bdt-icon'     => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-gallery-item-link .bdt-icon svg' => 'width: {{SIZE}}px; height: auto;',
				],
				'condition' => [
					'link_type' => 'icon',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_additional',
			[
				'label'     => esc_html__( 'Additional Options', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => ['gallery_layout' => 'standard'],
			]
		);

		$this->add_control(
			'overlay_content_alignment',
			[
				'label'   => __( 'Overlay Content Alignment', 'bdthemes-element-pack' ),
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
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-overlay' => 'text-align: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_content_position',
			[
				'label'       => __( 'Overlay Content Vertical Position', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'top' => [
						'title' => __( 'Top', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'default'   => 'middle',
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-overlay' => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'tilt_show',
			[
				'label' => esc_html__( 'Tilt Effect', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_hidden_gallery',
			[
				'label'     => esc_html__( 'Additional Options', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => ['gallery_layout' => 'hidden'],
			]
		);

		$this->add_control(
			'lightbox_link_type',
			[
				'label'   => esc_html__( 'Lightbox Link Type', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple_text',
				'options' => [
					'simple_text' => esc_html__('Simple Text', 'bdthemes-element-pack'),
					'link_image'  => esc_html__('Link Image', 'bdthemes-element-pack'),
				],
			]
		);

		$this->add_control(
			'link_image',
			[
				'label'   => __( 'Link Image', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],				
				'condition' => ['lightbox_link_type' => 'link_image'],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'link_image_size',
				'condition' => ['lightbox_link_type' => 'link_image'],
			]
		);
		
		$this->add_control(
			'gallery_link_text',
			[
				'label'       => esc_html__( 'Link Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Open Gallery', 'bdthemes-element-pack' ),
				'placeholder' => esc_html__( 'Gallery Link Text', 'bdthemes-element-pack' ),				
				'condition'   => ['lightbox_link_type' => 'simple_text'],
			]
		);

		$this->add_responsive_control(
			'gallery_link_align',
			[
				'label'   => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'elementor-align%s-',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_layout',
			[
				'label'     => esc_html__( 'Items', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => ['gallery_layout' => 'standard'],
			]
		);

		$this->add_control(
			'overlay_animation',
			[
				'label'   => esc_html__( 'Overlay Animation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => element_pack_transition_options(),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-thumbnail',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-thumbnail, {{WRAPPER}} .bdt-advanced-image-gallery .bdt-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_background',
			[
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_gap',
			[
				'label' => esc_html__( 'Overlay Gap', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-overlay' => 'margin: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'     => esc_html__( 'Caption Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-advanced-image-gallery .bdt-gallery-item .bdt-gallery-item-caption' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_caption' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'caption_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .bdt-gallery-item .bdt-gallery-item-caption',
				'condition' => [
					'show_caption' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Link Style', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_lightbox' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-gallery-item-link span'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-gallery-item-link' => 'background-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} .bdt-gallery-item-link',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-gallery-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .bdt-gallery-item-link',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-gallery-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-gallery-item-link',
				'condition' => [
					'show_lightbox' => 'yes',
					'link_type'     => 'text',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
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
					'{{WRAPPER}} .bdt-gallery-item-link:hover span'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-gallery-item-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-gallery-item-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		if ( empty( $settings['avd_gallery_images'] ) ) {
			return;
		}

		$this->add_render_attribute('advanced-image-gallery', 'id', 'bdt-avdg-' . $id );

		$this->add_render_attribute('advanced-image-gallery', 'class', 'bdt-advanced-image-gallery' );
		$this->add_render_attribute('advanced-image-gallery', 'class', ['bdt-grid', 'bdt-grid-collapse'] );

		$this->add_render_attribute('advanced-image-gallery', 'bdt-grid', '');
		
		if ('hidden' === $settings['gallery_layout']) {
			$this->add_render_attribute('advanced-image-gallery', 'class', '-hidden');
		}
		
		if ( 'yes' === $settings['masonry'] ) {
			$this->add_render_attribute('advanced-image-gallery', 'bdt-grid', 'masonry: true');
		}

		if ( 'yes' === $settings['show_lightbox'] or 'hidden' === $settings['gallery_layout'] ) {
			$this->add_render_attribute('advanced-image-gallery', 'bdt-lightbox', 'animation: slide');
		}

		$this->add_render_attribute('advanced-image-gallery-item', 'class', ['bdt-gallery-item', 'bdt-transition-toggle']);

		$this->add_render_attribute('advanced-image-gallery-inner', 'class', 'bdt-advanced-image-gallery-inner');
		
		if ('yes' === $settings['tilt_show']) {
			$this->add_render_attribute('advanced-image-gallery-inner', 'data-tilt', '');
		}

		$this->add_render_attribute('advanced-image-gallery', 'class', 'bdt-child-width-1-'. $settings['columns_mobile']);
		$this->add_render_attribute('advanced-image-gallery', 'class', 'bdt-child-width-1-'. $settings['columns_tablet'] .'@s');
		$this->add_render_attribute('advanced-image-gallery', 'class', 'bdt-child-width-1-'. $settings['columns'] .'@m');

		?>
		<div <?php echo $this->get_render_attribute_string( 'advanced-image-gallery' ); ?>>
			<?php
			foreach ( $settings['avd_gallery_images'] as $index => $item ) : ?>
				
				<?php if ('standard' === $settings['gallery_layout']) : ?>
					<div <?php echo $this->get_render_attribute_string( 'advanced-image-gallery-item' ); ?>>
						<div <?php echo $this->get_render_attribute_string( 'advanced-image-gallery-inner' ); ?>>
							<?php
							$this->render_thumbnail($item);
							if ( 'yes' == $settings['show_lightbox'] or 'yes' == $settings['show_caption'] )  :
								$this->render_overlay($item);
							endif;
							?>
						</div>
					</div>
				<?php elseif ('hidden' === $settings['gallery_layout']) : ?>
					<?php $this->link_only($item); ?>
				<?php endif; ?>

			<?php endforeach; ?>
		</div>
		<?php
	}

	public function render_thumbnail($item) {
		$settings  = $this->get_settings();
		$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'thumbnail', $settings ); 					

		echo '<div class="bdt-gallery-thumbnail bdt-transition-toggle">
			<img src="'.esc_url($image_url).'" alt="'.esc_attr( Control_Media::get_image_alt( $item ) ).'">
		</div>';
	}

	public function render_caption($text) {
		$image_caption = get_post($text['id']);
		?>

		<?php if ( ! empty( $image_caption ) ) : ?>
			<div class="bdt-gallery-item-caption">
				<?php echo $image_caption->post_excerpt; ?>
			</div>
		<?php endif;
	}

	public function render_overlay($content) {
		$settings                  = $this->get_settings();
		$overlay_settings          = [];
		$overlay_settings['class'] = ['bdt-position-cover bdt-overlay bdt-overlay-default'];
		$image_caption = get_post($content['id']);
		
		if ($settings['overlay_animation']) {
			$overlay_settings['class'][] = 'bdt-transition-'.$settings['overlay_animation'];
		}

		?>
		<div <?php echo \element_pack_helper::attrs($overlay_settings); ?>>
			<div class="bdt-advanced-image-gallery-content">
				<div class="bdt-advanced-image-gallery-content-inner">
				
					<?php 
					


					$this->add_render_attribute(
						[
							'overlay-lightbox-attr' => [
								'class' => [
									'bdt-gallery-item-link',
									'elementor-clickable',
									'icon-type-' . $settings['link_type'],
								],
								'data-elementor-open-lightbox' => 'no',
								'data-caption'                 => $image_caption->post_excerpt,
							],
						], '', '', true
					);

					$image_url = wp_get_attachment_image_src( $content['id'], 'full' );

					if ( ! $image_url ) {
						$this->add_render_attribute( 'overlay-lightbox-attr', 'href', $content['url'], true );
					} else {
						$this->add_render_attribute( 'overlay-lightbox-attr', 'href', $image_url[0], true );
					}
					
					?>
					<?php if ( 'yes' == $settings['show_lightbox'] )  : ?>
						<div class="bdt-flex-inline bdt-gallery-item-link-wrapper">
							<a <?php echo $this->get_render_attribute_string( 'overlay-lightbox-attr' ); ?>>
								<?php if ( 'icon' == $settings['link_type'] ) : ?>
									<span bdt-icon="icon: plus; ratio: 1.6"></span>
								<?php elseif ( 'text' == $settings['link_type'] ) : ?>
									<span class="bdt-text"><?php esc_html_e( 'ZOOM', 'bdthemes-element-pack' ); ?></span>
								<?php endif;?>
							</a>
						</div>
					<?php endif; ?>

					<?php if ( 'yes' == $settings['show_caption'] )  : ?>
						<?php $this->render_caption($content); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function link_only($content) {
		$settings      = $this->get_settings();
		$image_caption = get_post($content['id']);
		$link_count    = 1;

		$this->add_render_attribute(
			[
				'lightbox-attributes' => [
					'class' => [
						'elementor-clickable',
						'icon-type-' . $settings['link_type'],
						$settings['button_hover_animation'] ? 'elementor-animation-'.$settings['button_hover_animation'] : '',
					],
					'data-elementor-open-lightbox' => 'no',
					'data-caption'                 => $image_caption->post_excerpt,
				],
			], '', '', true
		);

		$image_url = wp_get_attachment_image_src( $content['id'], 'full' );

		if ( ! $image_url ) {
			$this->add_render_attribute( 'lightbox-attributes', 'href', $content['url'], true );
		} else {
			$this->add_render_attribute( 'lightbox-attributes', 'href', $image_url[0], true );
		}

		$this->lightbox_slide_index++;
		
		if (1 === $this->lightbox_slide_index) {
			$this->add_render_attribute( 'lightbox-attributes', 'class', ['bdt-gallery-item-link', 'bdt-hidden-gallery-button'] );

			if ('simple_text' == $settings['lightbox_link_type']) {
				$link_content = '<span>' . $settings['gallery_link_text'] . '</span>';
			} else {
				$link_image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['link_image']['id'], 'link_image_size', $settings );
				$link_image_src = ($link_image_src) ? $link_image_src : $settings['link_image']['url'];
				$link_content   = '<img src=' . esc_url($link_image_src) . ' alt="">';
			}			
			echo '<a ' . $this->get_render_attribute_string( 'lightbox-attributes' ) . '>' . $link_content . '</a>';
		} else {
			$this->add_render_attribute( 'lightbox-attributes', 'class', 'bdt-hidden' );
			echo '<a ' . $this->get_render_attribute_string( 'lightbox-attributes' ) . '></a>';
		}
	}
		
}
