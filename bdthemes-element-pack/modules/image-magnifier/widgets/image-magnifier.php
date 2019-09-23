<?php
namespace ElementPack\Modules\ImageMagnifier\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Image_Magnifier extends Widget_Base {

	public function get_name() {
		return 'bdt-image-magnifier';
	}

	public function get_title() {
		return esc_html__( 'Image Magnifier', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-zoom-in';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_style_depends() {
		return [ 'imagezoom' ];
	}

	public function get_script_depends() {
		return [ 'imagezoom' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'type',
			[
				'label'   => esc_html__( 'Type', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'inner',
				'options' => [
					'inner'    => esc_html__( 'Inner', 'bdthemes-element-pack' ),
					'standard' => esc_html__( 'Standard', 'bdthemes-element-pack' ),
					'follow'   => esc_html__( 'Follow', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'smooth_move',
			[
				'label'   => esc_html__( 'Smooth Move', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'preload',
			[
				'label'   => esc_html__( 'Preload', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'zoom_ratio',
			[
				'label'       => esc_html__( 'Zoom Ratio', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => 'Zoom ratio widht and height, such as 480:300',
			]
		);

		$this->add_control(
			'horizontal_offset',
			[
				'label'   => esc_html__( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => '10',
				],
				'condition' => [
					'type' => 'standard',
				],
			]
		);

		$this->add_control(
			'vertical_offset',
			[
				'label'   => esc_html__( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => '0',
				],
				'condition' => [
					'type' => 'standard',
				],
			]
		);

		$this->add_control(
			'position',
			[
				'label'   => esc_html__( 'Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'right' => esc_html__( 'Right', 'bdthemes-element-pack' ),
					'left'  => esc_html__( 'Left', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'type' => 'standard',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-image-magnifier' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .bdt-image-magnifier' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'image_border',
				'label'       => __( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-image-magnifier',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-image-magnifier' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label'   => __( 'Opacity (%)', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-image-magnifier img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings();		
		$id       = 'bdt-image-magnifier-' . $this->get_id();

		$horizontal_offset = ($settings['horizontal_offset']['size']) ? $settings['horizontal_offset']['size'] : '0';
		$vertical_offset   = ($settings['vertical_offset']['size']) ? $settings['vertical_offset']['size'] : '0';
		$offset            = $horizontal_offset . ',' . $vertical_offset;
		
		$zoom_ratio_width  = ($settings['zoom_ratio']['width']) ? $settings['zoom_ratio']['width'] : '480';
		$zoom_ratio_height = ($settings['zoom_ratio']['height']) ? $settings['zoom_ratio']['height'] : '300';
		$zoom_ratio        = $zoom_ratio_width . ',' . $zoom_ratio_height;

        if ($settings['image']['url']) {

        	?>
            <div id="<?php echo esc_attr($id); ?>" class="bdt-image-magnifier bdt-position-relative">
                <img class="bdt-image-magnifier-image" src="<?php echo esc_attr($settings['image']['url']); ?>" alt="">
            </div>
            <?php
        } else {
        	?>
        	<div class="bdt-alert-warning bdt-text-center">Opps!! You didn't choose any image for magnifying action</div>
        	<?php
        }

        ?>
        <script>
			jQuery(document).ready(function($) {
				"use strict";
				$("#<?php echo esc_attr($id); ?> .bdt-image-magnifier-image").ImageZoom({
					type       : '<?php echo esc_attr($settings['type']); ?>',
					smoothMove : <?php echo $settings['smooth_move'] ? 'true' : 'false'; ?>,
					preload    : <?php echo $settings['preload'] ? 'true' : 'false'; ?>,
					zoomSize   : [<?php echo esc_attr($zoom_ratio); ?>],
					offset     : [<?php echo esc_attr($offset); ?>],
					position   : '<?php echo esc_attr($settings['position']); ?>',	
				});
			});
		</script>
		<?php
	}
}
