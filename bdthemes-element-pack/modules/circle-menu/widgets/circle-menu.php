<?php
namespace ElementPack\Modules\CircleMenu\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Circle_Menu extends Widget_Base {
	public function get_name() {
		return 'bdt-circle-menu';
	}

	public function get_title() {
		return esc_html__( 'Circle Menu', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-favorite';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'circle-menu', 'bdt-uikit-icons' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_iconnav',
			[
				'label' => esc_html__( 'Circle Menu', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'toggle_icon',
			[
				'label'   => __( 'Choose Toggle Icon', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'plus' => [
						'title' => __( 'Plus', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-plus',
					],
					'plus-circle' => [
						'title' => __( 'Plus Circle', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-plus-circle',
					],
					'close' => [
						'title' => __( 'Close', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-times',
					],
					'cog' => [
						'title' => __( 'Settings', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-cog',
					],
					'menu' => [
						'title' => __( 'Bars', 'bdthemes-element-pack' ),
						'icon'  => 'fa fa-bars',
					],
				],
				'default' => 'plus',
			]
		);

		$this->add_control(
			'circle_menu',
			[
				'label'   => esc_html__( 'Circle Menu Items', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'icon'         => 'fa fa-home',
						'iconnav_link' => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						], 
						'title' => esc_html__( 'Home', 'bdthemes-element-pack' ) 
					],
					[
						'icon'         => 'fa fa-shopping-bag',
						'iconnav_link' => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						],
						'title' => esc_html__( 'Products', 'bdthemes-element-pack' ) 
					],
					[
						'icon'         => 'fa fa-wrench',
						'iconnav_link' => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						],
						'title' => esc_html__( 'Settings', 'bdthemes-element-pack' ) 
					],
					[
						'icon'         => 'fa fa-book',
						'iconnav_link' => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						],
						'title' => esc_html__( 'Documentation', 'bdthemes-element-pack' ) 
					],
					[
						'icon'         => 'fa fa-envelope-o',
						'iconnav_link' => [
							'url' => esc_html__( '#', 'bdthemes-element-pack' ),
						],
						'title' => esc_html__( 'Contact Us', 'bdthemes-element-pack' ) 
					],
				],
				'fields' => [
					[
						'name'    => 'title',
						'label'   => esc_html__( 'Menu Title', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'    => 'icon',
						'label'   => esc_html__( 'Icon', 'bdthemes-element-pack' ),
						'type'    => Controls_Manager::ICON,
						'default' => 'fa fa-home',
					],
					[
						'name'        => 'iconnav_link',
						'label'       => esc_html__( 'Link', 'bdthemes-element-pack' ),
						'type'        => Controls_Manager::URL,
						'default'     => [ 'url' => '#' ],
						'dynamic'     => [ 'active' => true ],
						'description' => 'Add your section id WITH the # key. e.g: #my-id also you can add internal/external URL',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'toggle_icon_position',
			[
				'label'   => __( 'Toggle Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => element_pack_position(),			
			]
		);

		$this->add_control(
			'toggle_icon_x_position',
			[
				'label'   => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' =>  0,
				],
				'range' => [
					'px' => [
						'min'  => -500,
						'step' => 10,
						'max'  => 500,
					],
				],
			]
		);

		$this->add_control(
			'toggle_icon_y_position',
			[
				'label'   => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,'default' => [
					'size' =>  0,
				],
				'range' => [
					'px' => [
						'min'  => -500,
						'step' => 10,
						'max'  => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu-container' => 'transform: translate({{toggle_icon_x_position.size}}px, {{SIZE}}px);',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional_settings',
			[
				'label' => esc_html__( 'Additional Settings', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'direction',
			[
				'label'   => __( 'Direction', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-right',
				'options' => [
					'top'          => esc_html__('Top', 'bdthemes-element-pack'),
					'right'        => esc_html__('Right', 'bdthemes-element-pack'),
					'bottom'       => esc_html__('Bottom', 'bdthemes-element-pack'),
					'left'         => esc_html__('Left', 'bdthemes-element-pack'),
					'top'          => esc_html__('Top', 'bdthemes-element-pack'),
					'full'         => esc_html__('Full', 'bdthemes-element-pack'),
					'top-left'     => esc_html__('Top-Left', 'bdthemes-element-pack'),
					'top-right'    => esc_html__('Top-Right', 'bdthemes-element-pack'),
					'top-half'     => esc_html__('Top-Half', 'bdthemes-element-pack'),
					'bottom-left'  => esc_html__('Bottom-Left', 'bdthemes-element-pack'),
					'bottom-right' => esc_html__('Bottom-Right', 'bdthemes-element-pack'),
					'bottom-half'  => esc_html__('Bottom-Half', 'bdthemes-element-pack'),
					'left-half'    => esc_html__('Left-Half', 'bdthemes-element-pack'),
					'right-half'   => esc_html__('Right-Half', 'bdthemes-element-pack'),
				],
			]
		);

		$this->add_control(
			'item_diameter',
			[
				'label'   => __( 'Circle Menu Size', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min'  => 20,
						'step' => 1,
						'max'  => 50,
					],
				],
			]
		);

		$this->add_control(
			'circle_radius',
			[
				'label'   => __( 'Circle Menu Distance', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min'  => 20,
						'step' => 5,
						'max'  => 500,
					],
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => __( 'Speed', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 500,
				],
				'range' => [
					'px' => [
						'min'  => 100,
						'step' => 10,
						'max'  => 1000,
					],
				],
			]
		);

		$this->add_control(
			'delay',
			[
				'label'   => __( 'Delay', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1000,
				],
				'range' => [
					'px' => [
						'min'  => 100,
						'step' => 10,
						'max'  => 2000,
					],
				],
			]
		);

		$this->add_control(
			'step_out',
			[
				'label'   => __( 'Step Out', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min'  => -200,
						'step' => 5,
						'max'  => 200,
					],
				],
			]
		);

		$this->add_control(
			'step_in',
			[
				'label'   => __( 'Step In', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -20,
				],
				'range' => [
					'px' => [
						'min'  => -200,
						'step' => 5,
						'max'  => 200,
					],
				],
			]
		);

		$this->add_control(
			'trigger',
			[
				'label'   => __( 'Trigger', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover' => esc_html__('Hover', 'bdthemes-element-pack'),
					'click' => esc_html__('Click', 'bdthemes-element-pack'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'toggle_icon_size',
			[
				'label' => esc_html__( 'Toggle Icon Size', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 48,
					],
				],
				'default' => [
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon a svg' => 'height: {{SIZE}}px; width: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'transition_function',
			[
				'label'   => esc_html__( 'Transition', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ease',
				'options' => [
					'ease'        => esc_html('Ease', 'bdthemes-element-pack'),
					'linear'      => esc_html('Linear', 'bdthemes-element-pack'),
					'ease-in'     => esc_html('Ease-In', 'bdthemes-element-pack'),
					'ease-out'    => esc_html('Ease-Out', 'bdthemes-element-pack'),
					'ease-in-out' => esc_html('Ease-In-Out', 'bdthemes-element-pack'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_toggle_icon',
			[
				'label' => esc_html__( 'Toggle Icon', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
	
		$this->start_controls_tabs( 'tabs_toggle_icon_style' );

		$this->start_controls_tab(
			'tab_toggle_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);
		
		$this->add_control(
			'toggle_icon_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'toggle_icon_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon',
			]
		);

		$this->add_responsive_control(
			'toggle_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'toggle_icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon',
			]
		);

		$this->add_responsive_control(
			'toggle_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'toggle_icon_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'toggle_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-toggle-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_circle_menu_icon',
			[
				'label' => esc_html__( 'Circle Icon', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
	
		$this->start_controls_tabs( 'tabs_circle_menu_icon_style' );

		$this->start_controls_tab(
			'tab_circle_menu_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);
		
		$this->add_control(
			'circle_menu_icon_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-menu-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_menu_icon_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-menu-icon > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'circle_menu_icon_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-circle-menu li.bdt-menu-icon',
			]
		);

		$this->add_responsive_control(
			'circle_menu_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-menu-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'circle_menu_icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-circle-menu li.bdt-menu-icon',
			]
		);

		$this->add_responsive_control(
			'circle_menu_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-menu-icon' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'circle_menu_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'step' => 1,
						'max'  => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bdt-circle-menu li.bdt-menu-icon i' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'circle_menu_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'circle_menu_icon_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_menu_icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li:hover > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_menu_icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'circle_menu_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-circle-menu li:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render_loop_iconnav_list($settings, $list) {

		$this->add_render_attribute(
			[
				'iconnav-link' => [
					'class' => [
						'bdt-position-center',
					],
					'target' => [
						$list['iconnav_link']['is_external'] ? '_blank' : '_self',
					],
					'rel' => [
						$list['iconnav_link']['nofollow'] ? 'nofollow' : '',
					],
					'title' => [
						esc_html($list['title']),
					],
					'href' => [
						esc_url($list['iconnav_link']['url']),
					],
				],
			], '', '', true
		);

		?>
	    <li class="bdt-menu-icon">
			<a <?php echo $this->get_render_attribute_string( 'iconnav-link' ); ?>>
				<?php if ($list['icon']) : ?>
					<span><i class="<?php echo esc_attr($list['icon']); ?>"></i></span>
				<?php endif; ?>
			</a>
		</li>
		<?php
	}

	protected function render_script($settings, $id) {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {	  
                $('#<?php echo esc_attr($id); ?> .bdt-circle-menu').circleMenu({
					direction           : '<?php echo esc_attr($settings['direction']); ?>',
					item_diameter       : <?php echo esc_attr($settings['item_diameter']['size']); ?>,
					circle_radius       : <?php echo esc_attr($settings['circle_radius']['size']); ?>,
					angle               : {
						start               : 0,
						end                 : 90
					},
					speed               : <?php echo esc_attr($settings['speed']['size']); ?>,
					delay               : <?php echo esc_attr($settings['delay']['size']); ?>,
					step_out            : <?php echo esc_attr($settings['step_out']['size']); ?>,
					step_in             : <?php echo esc_attr($settings['step_in']['size']); ?>,
					trigger             : '<?php echo esc_attr($settings['trigger']); ?>',
					transition_function : '<?php echo esc_attr($settings['transition_function']); ?>',
                });
                $('#<?php echo esc_attr($id); ?> > div:first-child').css('display','block');
                $('#<?php echo esc_attr($id); ?> li:first-child').addClass('active');
	        });
        </script>
        <?php
	}

	protected function render() {
		$settings    = $this->get_settings();
		$id          = 'bdt-circle-menu-' . $this->get_id();
		$toggle_icon = ($settings['toggle_icon']) ? : 'plus';

		$this->add_render_attribute(
			[
				'circle-menu-container' => [
					'id' => [
						esc_attr($id),
					],
					'class' => [
						'bdt-circle-menu-container',
						$settings['toggle_icon_position'] ? 'bdt-position-fixed bdt-position-' . $settings['toggle_icon_position'] : '',
					],
				],
			]
		);		

		$this->add_render_attribute(
			[
				'toggle-icon' => [
					'href' => [
						'javascript:void(0)',
					],
					'class' => [
						'bdt-icon bdt-link-reset',
						'bdt-position-center',
					],
					'bdt-icon' => [
						'icon: ' . esc_attr($toggle_icon) . '; ratio: 1.1',
					],
					'title' => [
						esc_html('Click me to show menus.', 'bdthemes-element-pack'),
					],
				],
			]
		);
		
		?>
		<div <?php echo $this->get_render_attribute_string( 'circle-menu-container' ); ?>>
            <ul class="bdt-circle-menu">
            	<li class="bdt-toggle-icon">
            		<a <?php echo $this->get_render_attribute_string( 'toggle-icon' ); ?>></a>
            	</li>
				<?php
				foreach ($settings['circle_menu'] as $key => $nav) : 
					$this->render_loop_iconnav_list($settings, $nav);
				endforeach;
				?>
			</ul>
		</div>
	    <?php

	    $this->render_script($settings, $id);
	}
}
