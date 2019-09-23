<?php
namespace ElementPack\Modules\Mailchimp\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Mailchimp extends Widget_Base {

	public function get_name() {
		return 'bdt-mailchimp';
	}

	public function get_title() {
		return esc_html__( 'Mailchimp', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-mailchimp';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'bdt-uikit-icons' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'before_text',
			[
				'label'       => esc_html__( 'Before Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Before Text', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'email_field_placeholder',
			[
				'label'       => esc_html__( 'Email Field Placeholder', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Email *', 'bdthemes-element-pack' ),
				'placeholder' => esc_html__( 'Email *', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'after_text',
			[
				'label'       => esc_html__( 'After Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'After Text', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'        => __( 'Alignment', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::CHOOSE,
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
				'options'      => [
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
				'conditions'   => [
					'relation' => 'or',
					'terms' => [
						[
							'name'     => 'before_text',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'after_text',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'space',
			[
				'label'   => __( 'Space Between', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''         => __( 'Default', 'bdthemes-element-pack' ),
					'small'    => __( 'Small', 'bdthemes-element-pack' ),
					'medium'   => __( 'Medium', 'bdthemes-element-pack' ),
					'large'    => __( 'Large', 'bdthemes-element-pack' ),
					'collapse' => __( 'Collapse', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'fullwidth_input',
			[
				'label'     => esc_html__( 'Fullwidth Email Field', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-newsletter-input-wrapper' => 'width: 100%;',
				],
			]
		);

		$this->add_control(
			'fullwidth_button',
			[
				'label'     => esc_html__( 'Fullwidth Button', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-newsletter-signup-wrapper' => 'width: 100%;',
				],
				'condition' => [
					'fullwidth_input' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label' => esc_html__( 'Signup Button', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'SIGNUP', 'bdthemes-element-pack' ),
				'default'     => esc_html__( 'SIGNUP', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label'       => __( 'Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => __( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => __( 'Left', 'bdthemes-element-pack' ),
					'right'  => __( 'Right', 'bdthemes-element-pack' ),
					'top'    => __( 'Top', 'bdthemes-element-pack' ),
					'bottom' => __( 'Bottom', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'icon!' => '',
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
						'max' => 100,
					],
				],
					'default' => [
						'size' => 8,
					],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-btn .bdt-button-icon-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-newsletter-btn .bdt-button-icon-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-newsletter-btn .bdt-button-icon-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-newsletter-btn .bdt-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_input',
			[
				'label' => esc_html__( 'Email Field', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper input[type*="email"]::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper input[type*="email"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper input[type *="email"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_show',
			[
				'label'     => esc_html__( 'Border Style', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'input_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-newsletter-wrapper input[type*="email"]',
				'condition' => [
					'input_border_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'input_radius',
			[
				'label'      => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-newsletter-wrapper input[type*="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-newsletter-wrapper input[type*="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Sign Up Button', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary' => 'background-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'radius',
			[
				'label'      => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary',
				'separator' => 'before',
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
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-button.bdt-button-primary:hover' => 'border-color: {{VALUE}};',
				],
			]
		);$this->add_control(
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
			'section_style_icon',
			[
				'label'     => __( 'Icon', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_signup_btn_icon_style' );

		$this->start_controls_tab(
			'tab_signup_btn_icon_normal',
			[
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'signup_btn_icon_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-btn .bdt-newsletter-btn-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'signup_btn_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-newsletter-btn .bdt-newsletter-btn-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'signup_btn_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-newsletter-btn .bdt-newsletter-btn-icon:after',
			]
		);

		$this->add_responsive_control(
			'signup_btn_icon_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-newsletter-btn .bdt-newsletter-btn-icon:after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'signup_btn_icon_radius',
			[
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-newsletter-btn .bdt-newsletter-btn-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'signup_btn_icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-newsletter-btn .bdt-newsletter-btn-icon:after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'signup_btn_icon_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .bdt-newsletter-btn .bdt-newsletter-btn-icon',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_signup_btn_icon_hover',
			[
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'signup_btn_icon_hover_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-btn:hover .bdt-newsletter-btn-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'signup_btn_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-newsletter-btn:hover .bdt-newsletter-btn-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-btn:hover .bdt-newsletter-btn-icon:after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_before_text',
			[
				'label'     => __( 'Before Text', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'before_text!' => '',
				],
			]
		);

		$this->add_control(
			'before_text_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-newsletter-before-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'before_text_spacing',
			[
				'label' => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-newsletter-before-text'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'before_text_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-newsletter-wrapper .bdt-newsletter-before-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_after_text',
			[
				'label'     => __( 'After Text', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'after_text!' => '',
				],
			]
		);

		$this->add_control(
			'after_text_color',
			[
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-newsletter-after-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'after_text_spacing',
			[
				'label' => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-newsletter-wrapper .bdt-newsletter-after-text'   => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'after_text_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-newsletter-wrapper .bdt-newsletter-after-text',
			]
		);

		$this->end_controls_section();
	}

	public function render_text($settings) {

		$this->add_render_attribute( 'content-wrapper', 'class', 'bdt-newsletter-btn-content-wrapper' );
		$this->add_render_attribute( 'content-wrapper', 'class', ( 'top' == $settings['icon_align'] ) ? 'bdt-flex bdt-flex-column' : '' );
		$this->add_render_attribute( 'content-wrapper', 'class', ( 'bottom' == $settings['icon_align'] ) ? 'bdt-flex bdt-flex-column-reverse' : '' );

		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'bdt-newsletter-btn-icon' );

		$this->add_render_attribute( 'text', 'class', ['bdt-newsletter-btn-text', 'bdt-display-inline-block'] );
		$this->add_inline_editing_attributes( 'text', 'none' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) ) : ?>
				<div class="bdt-newsletter-btn-icon bdt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['button_text']; ?></div>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->get_settings();
		$id       = 'bdt-mailchimp-' . $this->get_id();

		$space = ('' !== $settings['space']) ? ' bdt-grid-' . $settings['space'] : '';

		if ($settings['button_text']) {
			$button_text = $settings['button_text'];
		} else {
			$button_text = esc_html__( 'Subscribe', 'bdthemes-element-pack' );
		}

		?>
		<div class="bdt-newsletter-wrapper">

	        <!-- GET INTRO TEXT -->
	        <?php if ( ! empty( $settings['before_text'] ) ) : ?>
	           <div class="bdt-newsletter-before-text"><?php echo esc_attr($settings['before_text']); ?></div>
	        <?php endif; ?>

			<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" id="<?php echo esc_attr($id); ?>" class="bdt-grid<?php echo esc_attr($space); ?> bdt-child-width-auto" bdt-grid>
				<div class="bdt-newsletter-input-wrapper">
					<input type="email" name="email" placeholder="<?php echo esc_attr($settings['email_field_placeholder']); ?>" required class="bdt-input bdt-width-1-1" />
					<input type="hidden" name="action" value="element_pack_mailchimp_subscribe" />
					<!-- we need action parameter to receive ajax request in WordPress -->
				</div>
				<?php


				$this->add_render_attribute( 'signup_button', 'class', ['bdt-newsletter-btn', 'bdt-button', 'bdt-button-primary', 'bdt-width-1-1'] );				

				if ( $settings['hover_animation'] ) {
					$this->add_render_attribute( 'signup_button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
				}

				?>
				<div class="bdt-newsletter-signup-wrapper">
					<button <?php echo $this->get_render_attribute_string( 'signup_button' ); ?>>
						<?php $this->render_text($settings); ?>
					</button>
				</div>
			</form>

	        <!-- GET INTRO TEXT -->
	        <?php if ( ! empty( $settings['after_text'] ) ) : ?>
	            <div class="bdt-newsletter-after-text"><?php echo esc_attr($settings['after_text']); ?></div>
	        <?php endif; ?>

		</div><!-- end newsletter-signup -->

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				"use strict";
				$('#<?php echo esc_attr($id); ?>').submit(function(){
					var mailchimpform = $(this);
					bdtUIkit.notification({message: '<span bdt-spinner></span> <?php esc_html_e( 'Subscribing you please wait...', 'bdthemes-element-pack'); ?>', timeout: false, status: 'primary'});
					$.ajax({
						url:mailchimpform.attr('action'),
						type:'POST',
						data:mailchimpform.serialize(),
						success:function(data){
							bdtUIkit.notification.closeAll();
							bdtUIkit.notification({message: data, status: 'success'});
						}
					});
					return false;
				});
			});
		</script>
        <?php
	}
}
