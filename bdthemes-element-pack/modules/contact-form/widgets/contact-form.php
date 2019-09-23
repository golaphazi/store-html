<?php
namespace ElementPack\Modules\ContactForm\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use ElementPack\Classes\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Contact_Form extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'bdt-contact-form';
	}

	public function get_title() {
		return esc_html__( 'Simple Contact Form', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-mail';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_forms_layout',
			[
				'label' => esc_html__( 'Forms Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label'   => esc_html__( 'Label', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'input_size',
			[
				'label'   => esc_html__( 'Input Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'bdthemes-element-pack' ),
					'small'   => esc_html__( 'Small', 'bdthemes-element-pack' ),
					'large'   => esc_html__( 'Large', 'bdthemes-element-pack' ),
				],
			]
		);
		
		$this->add_control(
			'name_email_field_inline',
			[
				'label' => esc_html__( 'Name/Email Field Inline', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_submit_button',
			[
				'label' => esc_html__( 'Submit Button', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Text', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Send Message', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => esc_html__( 'Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''      => esc_html__( 'Default', 'bdthemes-element-pack' ),
					'small' => esc_html__( 'Small', 'bdthemes-element-pack' ),
					'large' => esc_html__( 'Large', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => '',
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-right',
					],
					'stretch' => [
						'title' => esc_html__( 'Justified', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-button-align-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_forms_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'custom_text',
			[
				'label'     => esc_html__( 'Custom Text', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'show_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'user_name_heading',
				[
				'label'     => esc_html__( 'Name Field', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'user_name_label',
				[
				'label'       => esc_html__( 'Label', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Name', 'bdthemes-element-pack' ),
				'condition'   => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);


		$this->add_control(
			'user_name_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'John Doe', 'bdthemes-element-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'subject_heading',
				[
				'label'     => esc_html__( 'Subject Field', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'subject_label',
				[
				'label'     => esc_html__( 'Label', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Subject', 'bdthemes-element-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'subject_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Your message subject', 'bdthemes-element-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_address_heading',
				[
				'label'     => esc_html__( 'Email Field', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_address_label',
			[
				'label'     => esc_html__( 'Label', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Email', 'bdthemes-element-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'example@email.com', 'bdthemes-element-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'message_label_heading',
				[
				'label'     => esc_html__( 'Message Field', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'message_label',
			[
				'label'     => esc_html__( 'Label', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Your Message', 'bdthemes-element-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'message_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_additional_message',
			[
				'label'     => esc_html__( 'Additional Bottom Message', 'bdthemes-element-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'additional_message',
			[
				'label'     => esc_html__( 'Message', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Note: You have to fill-up above all respective field, then click below button for send your message', 'bdthemes-element-pack' ),
				'condition' => [
					'show_additional_message' => 'yes',
				],
			]
		);

		// $this->add_control(
		// 	'enable_recaptcha',
		// 	[
		// 		'label'   => esc_html__( 'Enable Recaptcha?', 'bdthemes-element-pack' ),
		// 		'type'    => Controls_Manager::SWITCHER,
		// 		'default' => '',
		// 	]
		// );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Form Style', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Rows Gap', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => '15',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-field-group:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'#bdt-contact-form{{ID}} .bdt-name-email-inline + .bdt-name-email-inline' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_labels',
			[
				'label'     => esc_html__( 'Label', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_labels!' => '',
				],
			]
		);

		$this->add_control(
			'label_spacing',
			[
				'label' => esc_html__( 'Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-field-group > label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-form-label' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '#bdt-contact-form{{ID}} .bdt-form-label',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_style',
			[
				'label' => esc_html__( 'Fields', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_field_style' );

		$this->start_controls_tab(
			'tab_field_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-field-group .bdt-input' => 'color: {{VALUE}};',
					'#bdt-contact-form{{ID}} .bdt-field-group textarea'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-field-group .bdt-input::placeholder' => 'color: {{VALUE}};',
					'#bdt-contact-form{{ID}} .bdt-field-group textarea::placeholder'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-field-group .bdt-input' => 'background-color: {{VALUE}};',
					'#bdt-contact-form{{ID}} .bdt-field-group textarea'   => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'field_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#bdt-contact-form{{ID}} .bdt-field-group .bdt-input, #bdt-contact-form{{ID}} .bdt-field-group textarea',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#bdt-contact-form{{ID}} .bdt-field-group .bdt-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'#bdt-contact-form{{ID}} .bdt-field-group textarea'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'field_box_shadow',
				'selector' => '#bdt-contact-form{{ID}} .bdt-field-group .bdt-input, #bdt-contact-form{{ID}} .bdt-field-group textarea',
			]
		);

		$this->add_responsive_control(
			'field_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#bdt-contact-form{{ID}} .bdt-field-group .bdt-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
					'#bdt-contact-form{{ID}} .bdt-field-group textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'field_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '#bdt-contact-form{{ID}} .bdt-field-group .bdt-input, #bdt-contact-form{{ID}} .bdt-field-group textarea',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_field_hover',
			[
				'label' => esc_html__( 'Focus', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'field_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'field_border_border!' => '',
				],
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-field-group .bdt-input:focus' => 'border-color: {{VALUE}};',
					'#bdt-contact-form{{ID}} .bdt-field-group textarea:focus'   => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_submit_button_style',
			[
				'label' => esc_html__( 'Submit Button', 'bdthemes-element-pack' ),
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
					'#bdt-contact-form{{ID}} .bdt-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '#bdt-contact-form{{ID}} .bdt-button',
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'  => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#bdt-contact-form{{ID}} .bdt-button',
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
					'#bdt-contact-form{{ID}} .bdt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#bdt-contact-form{{ID}} .bdt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
					'#bdt-contact-form{{ID}} .bdt-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_border!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_style',
			[
				'label'     => esc_html__( 'Additional Message', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_additional_message!' => '',
				],
			]
		);

		$this->add_control(
			'additional_text_color',
			[
				'name'      => 'additional_text_color',
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),				
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-contact-form{{ID}} .bdt-contact-form-additional-message' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'additional_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '#bdt-contact-form{{ID}} .bdt-contact-form-additional-message',
			]
		);

		$this->end_controls_section();
	}

	public function form_fields_render_attributes() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		if ( ! empty( $settings['button_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'bdt-button-' . $settings['button_size'] );
		}

		if ( $settings['button_hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
		}

		$this->add_render_attribute(
			[
				'wrapper' => [
					'class' => [
						'elementor-form-fields-wrapper',
					],
				],
				'field-group' => [
					'class' => [
						'bdt-field-group',
						'bdt-width-1-1',
					],
				],
				'submit-group' => [
					'class' => [
						'elementor-field-type-submit',
						'bdt-field-group',
						'bdt-flex',
					],
				],

				'button' => [
					'class' => [
						'elementor-button',
						'bdt-button',
						'bdt-button-primary',
					],
					'name' => 'submit',
				],
				'user_name_label' => [
					'for'   => 'user_name' . $id,
					'class' => [
						'bdt-form-label',
					]
				],
				'subject_label' => [
					'for'   => 'subject' . $id,
					'class' => [
						'bdt-form-label',
					]
				],
				'email_address_label' => [
					'for'   => 'email' . $id,
					'class' => [
						'bdt-form-label',
					]
				],
				'message_label' => [
					'for'   => 'message' . $id,
					'class' => [
						'bdt-form-label',
					]
				],
				'user_name_input' => [
					'type'        => 'text',
					'name'        => 'name',
					'id'          => 'name' . $id,
					'placeholder' => $settings['user_name_placeholder'],
					'class'       => [
						'bdt-input',
						'bdt-form-' . $settings['input_size'],
					],
				],
				'subject_input' => [
					'type'        => 'text',
					'name'        => 'subject',
					'id'          => 'subject' . $id,
					'placeholder' => $settings['subject_placeholder'],
					'class'       => [
						'bdt-input',
						'bdt-form-' . $settings['input_size'],
					],
				],
				'email_address_input' => [
					'type'        => 'email',
					'name'        => 'email',
					'id'          => 'email' . $id,
					'placeholder' => $settings['email_placeholder'],
					'class'       => [
						'bdt-input',
						'bdt-form-' . $settings['input_size'],
					],
				],
				'message_area' => [
					'type'        => 'textarea',
					'name'        => 'message',
					'id'          => 'message' . $id,
					'rows'		  => '5',
					'placeholder' => $settings['message_placeholder'],
					'class'       => [
						'bdt-textarea',
						'bdt-form-' . $settings['input_size'],
					],
				],
			]
		);

		if ( ! $settings['show_labels'] ) {
			$this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
		}

		$this->add_render_attribute( 'field-group', 'class', 'elementor-field-required' )
			->add_render_attribute( 'input', 'required', true )
			->add_render_attribute( 'input', 'aria-required', 'true' );
	}

	

	public function render() {
		$this->form_fields_render_attributes();

		?>
		<div class="bdt-contact-form bdt-contact-form-skin-default">
			<div class="elementor-form-fields-wrapper">
				<?php $this->contact_form_html(); ?>
			</div>
		</div>
		<?php

		$this->contact_form_ajax_script();
	}

	public function contact_form_html() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$this->add_render_attribute( 'name-email-field-group', 'class', ['bdt-field-group', 'elementor-field-required'] );
		
		if($settings['name_email_field_inline']) {
			$this->add_render_attribute( 'name-email-field-group', 'class', ['bdt-width-1-2@m', 'bdt-name-email-inline'] );
		} else {
			$this->add_render_attribute( 'name-email-field-group', 'class', 'bdt-width-1-1' );
		}

		?>
		<form id="bdt-contact-form<?php echo esc_attr($id); ?>" class="bdt-form-stacked bdt-grid bdt-grid-small bdt-width-1-1" method="post" action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" bdt-grid>
			<div <?php echo $this->get_render_attribute_string( 'name-email-field-group' ); ?>>
				<?php
				if ( $settings['show_labels'] ) {
					echo '<label ' . $this->get_render_attribute_string( 'user_name_label' ) . '>' . $settings['user_name_label'] . '</label>';
				}
				echo '<div class="bdt-form-controls">';
				echo '<input ' . $this->get_render_attribute_string( 'user_name_input' ) . ' required>';
				echo '</div>';

				?>
			</div>

			<div <?php echo $this->get_render_attribute_string( 'name-email-field-group' ); ?>>
				<?php
				if ( $settings['show_labels'] ) :
					echo '<label ' . $this->get_render_attribute_string( 'email_address_label' ) . '>' . $settings['email_address_label'] . '</label>';
				endif;
				echo '<div class="bdt-form-controls">';
				echo '<input ' . $this->get_render_attribute_string( 'email_address_input' ) . ' required>';
				echo '</div>';
				?>
			</div>

			<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
				<?php
				if ( $settings['show_labels'] ) {
					echo '<label ' . $this->get_render_attribute_string( 'subject_label' ) . '>' . $settings['subject_label'] . '</label>';
				}
				echo '<div class="bdt-form-controls">';
				echo '<input ' . $this->get_render_attribute_string( 'subject_input' ) . ' required>';
				echo '</div>';

				?>
			</div>

			<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
				<?php
				if ( $settings['show_labels'] ) :
					echo '<label ' . $this->get_render_attribute_string( 'message_label' ) . '>' . $settings['message_label'] . '</label>';
				endif;
				echo '<div class="bdt-form-controls">';
				echo '<textarea ' . $this->get_render_attribute_string( 'message_area' ) . ' required></textarea>';
				echo '</div>';
				?>
			</div>
			
			<?php if ( 'yes' === $settings['show_additional_message'] ) : ?>
			<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
				<span class="bdt-contact-form-additional-message"><?php echo $settings['additional_message']; ?></span>
			</div>
			<?php endif; ?>
			
			<div <?php echo $this->get_render_attribute_string( 'submit-group' ); ?>>
				<button type="submit" <?php echo $this->get_render_attribute_string( 'button' ); ?>>
					<?php if ( ! empty( $settings['button_text'] ) ) : ?>
						<span><?php echo $settings['button_text']; ?></span>
					<?php endif; ?>
				</button>
			</div>		
			
			<input type="hidden" name="action" value="element_pack_contact_form" />
		</form>
		<?php
	}

	public function contact_form_ajax_script() {
		$settings    = $this->get_settings();
		$id          = $this->get_id();

		?>		
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				"use strict";
				$('#bdt-contact-form<?php echo esc_attr($id); ?>').submit(function(){
					var contact_form = $(this);
					//$(contact_form + ' button.bdt-button').attr("disabled", true);
					bdtUIkit.notification({message: '<div bdt-spinner></div> <?php esc_html_e( 'Sending message please wait...', 'bdthemes-element-pack'); ?>', timeout: false, status: 'primary'});
					$.ajax({
						url:contact_form.attr('action'),
						type:'POST',
						data:contact_form.serialize(),
						success:function(data){
							bdtUIkit.notification.closeAll();
							bdtUIkit.notification({message: data});
						}
					});
					return false;
				});
			});
		</script>
		<?php
	}
}
