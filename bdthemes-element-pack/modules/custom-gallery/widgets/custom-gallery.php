<?php
namespace ElementPack\Modules\CustomGallery\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

use ElementPack\Modules\CustomGallery\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Custom_Gallery extends Widget_Base {

	public function get_name() {
		return 'bdt-custom-gallery';
	}

	public function get_title() {
		return esc_html__( 'Custom Gallery', 'bdthemes-element-pack' );
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

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Abetis( $this ) );
		$this->add_skin( new Skins\Skin_Fedara( $this ) );
	}

	public function _register_controls() {
		$this->start_controls_section(
			'section_custom_gallery_content',
			[
				'label' => esc_html__( 'Custom Gallery', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'gallery',
			[
				'label' => esc_html__( 'Gallery Items', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'image_title'   => esc_html__( 'Image #1', 'bdthemes-element-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'bdthemes-element-pack' ),
					],
					[
						'image_title'   => esc_html__( 'Image #2', 'bdthemes-element-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'bdthemes-element-pack' ),
					],
					[
						'image_title'   => esc_html__( 'Image #3', 'bdthemes-element-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'bdthemes-element-pack' ),
					],
					[
						'image_title'   => esc_html__( 'Image #4', 'bdthemes-element-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'bdthemes-element-pack' ),
					],
					[
						'image_title'   => esc_html__( 'Image #5', 'bdthemes-element-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'bdthemes-element-pack' ),
					],
					[
						'image_title'   => esc_html__( 'Image #6', 'bdthemes-element-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'bdthemes-element-pack' ),
					],
				],
				'fields' => [
					[
						'name'    => 'image_title',
						'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::TEXT,
						'dynamic' => [ 'active' => true ],
						'default' => esc_html__( 'Slide Title' , 'bdthemes-element-pack' ),
					],
					[
						'name'    => 'gallery_image',
						'label'   => esc_html__( 'Image', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::MEDIA,
						'dynamic' => [ 'active' => true ],
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'name'    => 'image_text',
						'label'   => esc_html__( 'Content', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::TEXTAREA,
						'dynamic' => [ 'active' => true ],
						'default' => esc_html__( 'Slide Content', 'bdthemes-element-pack' ),
					],

					[
						'name'    => 'image_link_type',
						'label'       => esc_html__( 'Lightbox Link', 'bdthemes-element-pack' ),
						'type'        => Controls_Manager::SELECT,
						'default'     => '',
						'label_block' => true,
						'options'     => [
							''           => esc_html__( 'Selected Image', 'bdthemes-element-pack' ),
							'website'    => esc_html__( 'Website', 'bdthemes-element-pack' ),
							'video'      => esc_html__( 'Video', 'bdthemes-element-pack' ),
							'youtube'    => esc_html__( 'Youtube', 'bdthemes-element-pack' ),
							'vimeo'      => esc_html__( 'Vimeo', 'bdthemes-element-pack' ),
							'google-map' => esc_html__( 'Google Map', 'bdthemes-element-pack' ),
						],
					],
					[
						'name'          => 'image_link_video',
						'label'         => __( 'Video Source', 'bdthemes-element-pack' ),
						'type'          => Controls_Manager::URL,
						'show_external' => false,
						'default'       => [
							'url' => __( 'https://quirksmode.org/html5/videos/big_buck_bunny.mp4', 'bdthemes-element-pack' ),
						],
						'placeholder'   => __( 'https://quirksmode.org/html5/videos/big_buck_bunny.mp4', 'bdthemes-element-pack' ),
						'label_block'   => true,
						'condition'     => [
							'image_link_type' => 'video',
						],
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'          => 'image_link_youtube',
						'label'         => __( 'YouTube Source', 'bdthemes-element-pack' ),
						'type'          => Controls_Manager::URL,
						'show_external' => false,
						'default'       => [
							'url' => __( 'https://www.youtube.com/watch?v=YE7VzlLtp-4', 'bdthemes-element-pack' ),
						],
						'placeholder'   => __( 'https://www.youtube.com/watch?v=YE7VzlLtp-4', 'bdthemes-element-pack' ),
						'label_block'   => true,
						'condition'     => [
							'image_link_type' => 'youtube',
						],
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'          => 'image_link_vimeo',
						'label'         => __( 'Vimeo Source', 'bdthemes-element-pack' ),
						'type'          => Controls_Manager::URL,
						'show_external' => false,
						'default'       => [
							'url' => __( 'https://vimeo.com/1084537', 'bdthemes-element-pack' ),
						],
						'placeholder'   => __( 'https://vimeo.com/1084537', 'bdthemes-element-pack' ),
						'label_block'   => true,
						'condition'     => [
							'image_link_type' => 'vimeo',
						],
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'          => 'image_link_google_map',
						'label'         => __( 'Goggle Map Embed URL', 'bdthemes-element-pack' ),
						'type'          => Controls_Manager::URL,
						'show_external' => false,
						'default'       => [
							'url' => __( 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4740.819266853735!2d9.99008871708242!3d53.550454675412404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3f9d24afe84a0263!2sRathaus!5e0!3m2!1sde!2sde!4v1499675200938', 'bdthemes-element-pack' ),
						],
						'placeholder'   => __( 'https://www.google.com/maps/embed?pb', 'bdthemes-element-pack' ),
						'label_block'   => true,
						'condition'     => [
							'image_link_type' => 'google-map',
						],
						'dynamic'     => [ 'active' => true ],
					],
					
					[
						'name'    => 'image_link_website',
						'label'   => esc_html__( 'Custom Link', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::URL,
						'condition'     => [
							'image_link_type' => 'website',
						],
						'dynamic' => [ 'active' => true ],
					],
				],
				'title_field' => '{{{ image_title }}}',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_custom_gallery_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
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

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'         => 'thumbnail_size',
				'label'        => esc_html__( 'Image Size', 'bdthemes-element-pack' ),
				'exclude'      => [ 'custom' ],
				'default'      => 'medium',
				'prefix_class' => 'bdt-custom-gallery--thumbnail-size-',
			]
		);

		$this->add_control(
			'masonry',
			[
				'label' => esc_html__( 'Masonry', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_responsive_control(
			'item_ratio',
			[
				'label'   => esc_html__( 'Item Height', 'bdthemes-element-pack' ),
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
					'#bdt-custom-gallery{{ID}} .bdt-gallery-thumbnail img' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'masonry!' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_additional',
			[
				'label' => esc_html__( 'Additional Options', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => element_pack_title_tags(),
				'default'   => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_text',
			[
				'label'   => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
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
			'tilt_show',
			[
				'label'   => esc_html__( 'Tilt Effect', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => esc_html__( 'Items', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-gallery.bdt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-custom-gallery.bdt-grid > *' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-gallery.bdt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .bdt-custom-gallery.bdt-grid > *' => 'margin-top: {{SIZE}}px',
				],
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
				'prefix_class' => 'bdt-custom-gallery-skin-fedara-style-',
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-overlay' => 'text-align: {{VALUE}}',
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
				'default' => 'middle',
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-overlay' => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-thumbnail, {{WRAPPER}} .bdt-custom-gallery .bdt-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'item_skin_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item'      => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bdt-custom-gallery .bdt-overlay'           => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'overlay_background',
			[
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item .bdt-overlay' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item .bdt-overlay' => 'margin: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item .bdt-gallery-item-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_title' => 'yes',
					'_skin'      => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .bdt-gallery-item .bdt-gallery-item-title',
				'condition' => [
					'show_title' => 'yes',
					'_skin'      => '',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item .bdt-gallery-item-text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'text_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .bdt-gallery-item .bdt-gallery-item-text',
				'condition' => [
					'show_text' => 'yes',
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
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link span'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link' => 'background-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link',
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
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector'  => '{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link',
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
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link:hover span'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .bdt-custom-gallery .bdt-gallery-item-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}
	
	public function render_thumbnail($image) {
		$settings  = $this->get_settings();
		$image_url = Group_Control_Image_Size::get_attachment_image_src( $image['gallery_image']['id'], 'thumbnail_size', $settings );

		if ( ! $image_url ) {
			$image_url = $image['gallery_image']['url'];
		}

		echo '<div class="bdt-gallery-thumbnail"><img src="'.esc_url($image_url).'" alt=""></div>';
	}
	
	public function render_title($title) {
		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->get_settings( 'title_tag' );
		?>
		<<?php echo $tag ?> class="bdt-gallery-item-title bdt-transition-slide-top-small">
			<?php echo $title['image_title']; ?>
		</<?php echo $tag ?>>
		<?php
	}
	
	public function render_text($text) {
		if ( ! $this->get_settings( 'show_text' ) ) {
			return;
		}

		?>
		<div class="bdt-gallery-item-text bdt-transition-slide-bottom-small"><?php echo $text['image_text']; ?></div>
		<?php
	}

	public function render_overlay($content) {
		$settings = $this->get_settings();

		$this->add_render_attribute(
			[
				'overlay-settings' => [
					'class' => [
						'bdt-overlay',
						'bdt-overlay-default',
						'bdt-position-cover',
						$settings['overlay_animation'] ? 'bdt-transition-' . $settings['overlay_animation'] : ''
					],
				],
			], '', '', true
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'overlay-settings' ); ?>>
			<div class="bdt-custom-gallery-content">
				<div class="bdt-custom-gallery-content-inner">
				
					<?php if ($settings['show_lightbox'])  :

						$image_url = wp_get_attachment_image_src( $content['gallery_image']['id'], 'full');
						$this->add_render_attribute('lightbox-settings', 'class', ['bdt-gallery-item-link', 'bdt-gallery-lightbox-item'], true );
						$this->add_render_attribute('lightbox-settings', 'data-elementor-open-lightbox', 'no', true );
						$this->add_render_attribute('lightbox-settings', 'data-caption', $content['image_title'], true );

						if ($content['image_link_type']) {
							if ('google-map' == $content['image_link_type'] and '' != $content['image_link_google_map']) {
								$this->add_render_attribute( 'lightbox-settings', 'href', $content['image_link_google_map']['url'], true );
								$this->add_render_attribute( 'lightbox-settings', 'data-type', 'iframe' );
							} elseif ('video' == $content['image_link_type'] and '' != $content['image_link_video']) {
								$this->add_render_attribute( 'lightbox-settings', 'href', $content['image_link_video']['url'], true );
								$this->add_render_attribute( 'lightbox-settings', 'data-type', 'video' );
							} elseif ('youtube' == $content['image_link_type'] and '' != $content['image_link_youtube']) {
								$this->add_render_attribute( 'lightbox-settings', 'href', $content['image_link_youtube']['url'], true );
							} elseif ('vimeo' == $content['image_link_type'] and '' != $content['image_link_vimeo']) {
								$this->add_render_attribute( 'lightbox-settings', 'href', $content['image_link_vimeo']['url'], true );
							} else {
								$this->add_render_attribute( 'lightbox-settings', 'href', $content['image_link_website']['url'], true );
								$this->add_render_attribute( 'lightbox-settings', 'data-type', 'iframe' );
							}
						} else {
							if ( ! $image_url ) {
								$this->add_render_attribute('lightbox-settings', 'href', $content['gallery_image']['url'], true);
							} else {
								$this->add_render_attribute('lightbox-settings', 'href', $image_url[0], true);
							}
						}
						
						?>
						<div class="bdt-flex-inline bdt-gallery-item-link-wrapper">
							<a <?php echo $this->get_render_attribute_string( 'lightbox-settings' ); ?>>
								<?php if ( 'icon' == $settings['link_type'] ) : ?>
									<span bdt-icon="icon: plus; ratio: 1.6"></span>
								<?php elseif ( 'text' == $settings['link_type'] ) : ?>
									<span class="bdt-text"><?php esc_html_e( 'ZOOM', 'bdthemes-element-pack' ); ?></span>
								<?php endif;?>
							</a>
						</div>
					<?php endif; ?>

					<?php 
					$this->render_title($content);
					$this->render_text($content);
					?>
				</div>
			</div>
		</div>
		<?php
	}

	public function render_header($skin = 'default') {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$this->add_render_attribute('custom-gallery', 'id', 'bdt-custom-gallery-' . $id );
		$this->add_render_attribute('custom-gallery', 'class', ['bdt-custom-gallery', 'bdt-custom-gallery-skin-' . esc_attr($skin)] );
		$this->add_render_attribute('custom-gallery', 'class', ['bdt-grid', 'bdt-grid-small'] );
		
		if ( 'yes' === $settings['masonry'] ) {
			$this->add_render_attribute('custom-gallery', 'bdt-grid', 'masonry: true');
		}

		if ($settings['show_lightbox']) {
			$this->add_render_attribute('custom-gallery', 'bdt-lightbox', 'toggle: .bdt-gallery-lightbox-item; animation: slide;');
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'custom-gallery' ); ?>>
		<?php
	}

	public function render_footer() {
		$settings = $this->get_settings();

		?>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute('custom-gallery-item', 'class', ['bdt-gallery-item', 'bdt-transition-toggle']);
		$this->add_render_attribute('custom-gallery-item', 'class', 'bdt-width-1-'. $settings['columns_mobile']);
		$this->add_render_attribute('custom-gallery-item', 'class', 'bdt-width-1-'. $settings['columns_tablet'] .'@s');
		$this->add_render_attribute('custom-gallery-item', 'class', 'bdt-width-1-'. $settings['columns'] .'@m');
		
		$this->add_render_attribute('custom-gallery-inner', 'class', 'bdt-custom-gallery-inner');

		if ('yes' === $settings['tilt_show']) {
			$this->add_render_attribute('custom-gallery-inner', 'data-tilt', '');
		}

		$this->render_header();
		foreach ( $settings['gallery'] as $item ) :

			?>
			<div <?php echo $this->get_render_attribute_string( 'custom-gallery-item' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'custom-gallery-inner' ); ?>>
					<?php 
					$this->render_thumbnail($item);
					$this->render_overlay($item);
					?>
				</div>
			</div>

		<?php endforeach; ?>
		<?php $this->render_footer($item);
	}
		
}
