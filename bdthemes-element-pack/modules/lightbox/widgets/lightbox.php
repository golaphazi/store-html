<?php
namespace ElementPack\Modules\Lightbox\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Lightbox extends Widget_Base {
	public function get_name() {
		return 'lightbox';
	}

	public function get_title() {
		return esc_html__( 'Lightbox', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-site-search';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}
	
	public function get_script_depends() {
		return [ 'imagesloaded', 'bdt-uikit-icons' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'lightbox_content',
			[
				'label'       => esc_html__( 'Select Lightbox Content', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'image',
				'label_block' => true,
				'options'     => [
					'image'      => esc_html__( 'Image', 'bdthemes-element-pack' ),
					'video'      => esc_html__( 'Video', 'bdthemes-element-pack' ),
					'youtube'    => esc_html__( 'Youtube', 'bdthemes-element-pack' ),
					'vimeo'      => esc_html__( 'Vimeo', 'bdthemes-element-pack' ),
					'google-map' => esc_html__( 'Google Map', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'content_image',
			[
				'label'   => __( 'Image Source', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'lightbox_content' => 'image',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_video',
			[
				'label'         => __( 'Video Source', 'bdthemes-element-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'default'       => [
					'url' => __( 'https://quirksmode.org/html5/videos/big_buck_bunny.mp4', 'bdthemes-element-pack' ),
				],
				'placeholder'   => __( 'https://quirksmode.org/html5/videos/big_buck_bunny.mp4', 'bdthemes-element-pack' ),
				'label_block'   => true,
				'condition'     => [
					'lightbox_content' => 'video',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_youtube',
			[
				'label'         => __( 'YouTube Source', 'bdthemes-element-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'default'       => [
					'url' => __( 'https://www.youtube.com/watch?v=YE7VzlLtp-4', 'bdthemes-element-pack' ),
				],
				'placeholder'   => __( 'https://www.youtube.com/watch?v=YE7VzlLtp-4', 'bdthemes-element-pack' ),
				'label_block'   => true,
				'condition'     => [
					'lightbox_content' => 'youtube',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_vimeo',
			[
				'label'         => __( 'Vimeo Source', 'bdthemes-element-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'default'       => [
					'url' => __( 'https://vimeo.com/1084537', 'bdthemes-element-pack' ),
				],
				'placeholder'   => __( 'https://vimeo.com/1084537', 'bdthemes-element-pack' ),
				'label_block'   => true,
				'condition'     => [
					'lightbox_content' => 'vimeo',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_google_map',
			[
				'label'         => __( 'Goggle Map Embed URL', 'bdthemes-element-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'default'       => [
					'url' => __( 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4740.819266853735!2d9.99008871708242!3d53.550454675412404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3f9d24afe84a0263!2sRathaus!5e0!3m2!1sde!2sde!4v1499675200938', 'bdthemes-element-pack' ),
				],
				'placeholder'   => __( 'https://www.google.com/maps/embed?pb', 'bdthemes-element-pack' ),
				'label_block'   => true,
				'condition'     => [
					'lightbox_content' => 'google-map',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_caption',
			[
				'label'   => __( 'Content Caption', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => 'This is a image',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_toggler',
			[
				'label' => __( 'Toggler', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'lightbox_toggler',
			[
				'label'       => esc_html__( 'Select Lightbox Toggler', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'poster',
				'label_block' => true,
				'options'     => [
					'poster' => esc_html__( 'Poster', 'bdthemes-element-pack' ),
					'button' => esc_html__( 'Button', 'bdthemes-element-pack' ),
					'icon'   => esc_html__( 'Icon', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'poster_image',
			[
				'label'   => __( 'Poster Image', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'lightbox_toggler' => 'poster',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'poster_image_size',
				'default'   => 'large',
				'separator' => 'none',
				'condition' => [
					'lightbox_toggler' => 'poster',
				],
			]
		);

		$this->add_responsive_control(
			'poster_height',
			[
				'label'   => __( 'Poster Height', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 400,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 1200,
						'step' => 5,
					]
				],
				'condition' => [
					'lightbox_toggler' => 'poster',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-toggler-poster' => 'min-height: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => __( 'Button Text', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Open Lightbox',
				'condition' => [
					'lightbox_toggler' => 'button',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'toggler_icon',
			[
				'label'     => __( 'Icon', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::ICON,
				'default'   => 'fa fa-play',
				'condition' => [
					'lightbox_toggler' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
				'condition'    => [
					'lightbox_toggler!' => 'poster',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label'     => __( 'Icon', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::ICON,
				'condition' => [
					'lightbox_toggler' => 'button',
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => __( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Before', 'bdthemes-element-pack' ),
					'right' => __( 'After', 'bdthemes-element-pack' ),
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'lightbox_toggler',
							'value' => 'button',
						],
						[
							'name'     => 'icon',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'lightbox_toggler',
							'value' => 'button',
						],
						[
							'name'     => 'icon',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_text!' => '',
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
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .elementor-button',
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
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_additional',
			[
				'label' => esc_html__( 'Additional Options', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lightbox_animation',
			[
				'label'   => esc_html__( 'Lightbox Animation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'bdthemes-element-pack' ),
					'fade'  => esc_html__( 'Fade', 'bdthemes-element-pack' ),
					'scale' => esc_html__( 'Scale', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'video_autoplay',
			[
				'label'   => esc_html__( 'Video Autoplay', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['icon_align'],
				],
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['button_text']; ?></span>
		</span>
		<?php
	}

	protected function render() {

		$settings = $this->get_settings();
		$id       = $this->get_id();

		// remove global lightbox
		$this->add_render_attribute( 'lightbox-content', 'data-elementor-open-lightbox', 'no' );
		
		if ( 'poster' != $settings['lightbox_toggler'] ) {
			$this->add_render_attribute( 'lightbox-content', 'class', 'elementor-button elementor-size-md' );

			if ( $settings['hover_animation'] ) {
				$this->add_render_attribute( 'lightbox-content', 'class', 'elementor-animation-' . $settings['hover_animation'] );
			}
		}

		if ( $settings['content_caption'] ) {
			$this->add_render_attribute( 'lightbox-content', 'data-caption', $settings['content_caption'] );
		}

		if ('image' == $settings['lightbox_content']) {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_image']['url'] );
		} elseif ('video' == $settings['lightbox_content'] and '' != $settings['content_video']) {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_video']['url'] );
		} elseif ('youtube' == $settings['lightbox_content'] and '' != $settings['content_youtube']) {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_youtube']['url'] );
		} elseif ('vimeo' == $settings['lightbox_content'] and '' != $settings['content_vimeo']) {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_vimeo']['url'] );
		} else {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_google_map']['url'] );
			$this->add_render_attribute( 'lightbox-content', 'data-type', 'iframe' );
		}

		//$this->add_render_attribute( 'lightbox', 'class', 'bdt-lightbox' );
		$this->add_render_attribute( 'lightbox', 'bdt-lightbox', '' );
		
		if ( $settings['lightbox_animation'] ) {
			$this->add_render_attribute( 'lightbox', 'bdt-lightbox', 'animation: ' . $settings['lightbox_animation'] . ';' );
		}

		if ( $settings['video_autoplay'] ) {
			$this->add_render_attribute( 'lightbox', 'bdt-lightbox', 'video-autoplay: true;' );
		}
		
		if ( 'poster' == $settings['lightbox_toggler'] ) {

			$poster_url = Group_Control_Image_Size::get_attachment_image_src($settings['poster_image']['id'], 'poster_image_size', $settings);

			if ( ! $poster_url ) {
				$poster_url = $settings['poster_image']['url'];
			}
		}	

        ?>
        <div id="bdt-lightbox-<?php echo esc_attr($id); ?>">              
			<div <?php echo $this->get_render_attribute_string( 'lightbox' ); ?>>			

			    <a <?php echo $this->get_render_attribute_string( 'lightbox-content' ); ?>>

			    	<?php if ( 'poster' == $settings['lightbox_toggler'] ) : ?>
						<div class="bdt-toggler-poster bdt-background-cover" style="background-image: url('<?php echo esc_url($poster_url); ?>');"></div>
					<?php endif; ?>

					<?php if ( 'icon' == $settings['lightbox_toggler'] ) : ?>
				    	<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
							<i class="<?php echo esc_attr( $settings['toggler_icon'] ); ?>" aria-hidden="true"></i>
						</span>
					<?php endif; ?>

					<?php if ( 'button' == $settings['lightbox_toggler'] ) : ?>
			    		<?php $this->render_text(); ?>
			    	<?php endif; ?>
		    	</a>

			</div>     
        </div>
        <?php
	}
}
