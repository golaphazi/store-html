<?php
namespace ElementPack\Modules\TableOfContent\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Table_Of_Content extends Widget_Base {
	public function get_name() {
		return 'bdt-table-of-content';
	}

	public function get_title() {
		return esc_html__( 'Table of Content', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-navigation-vertical';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'table-of-content', 'bdt-uikit-icon' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_table_of_content',
			[
				'label' => esc_html__( 'Table of Content', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'index_align',
			[
				'label' => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'bdthemes-element-pack' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'right',
			]
		);

		$this->add_control(
			'start_tag',
			[
				'label'   => __( 'Start Tag', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'1'   => esc_html__( 'H1', 'bdthemes-element-pack' ),
			        '2'   => esc_html__( 'H2', 'bdthemes-element-pack' ),
			        '3'   => esc_html__( 'H3', 'bdthemes-element-pack' ),
			        '4'   => esc_html__( 'H4', 'bdthemes-element-pack' ),
			        '5'   => esc_html__( 'H5', 'bdthemes-element-pack' ),
			        '6'   => esc_html__( 'H6', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'end_tag',
			[
				'label'   => __( 'End Tag', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '5',
				'options' => [
					'1'   => esc_html__( 'H1', 'bdthemes-element-pack' ),
			        '2'   => esc_html__( 'H2', 'bdthemes-element-pack' ),
			        '3'   => esc_html__( 'H3', 'bdthemes-element-pack' ),
			        '4'   => esc_html__( 'H4', 'bdthemes-element-pack' ),
			        '5'   => esc_html__( 'H5', 'bdthemes-element-pack' ),
			        '6'   => esc_html__( 'H6', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label'   => __( 'Scroll Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_table_of_content',
			[
				'label' => esc_html__( 'Table of Content', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'index_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-table-of-content',
				'separator' => 'after',
			]
		);


		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table-of-content .bdt-nav li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_active_color',
			[
				'label'     => __( 'Active Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table-of-content .bdt-nav > li.bdt-active > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_style_active_color',
			[
				'label'     => __( 'Title Style Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-table-of-content .bdt-nav li > a:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-table-of-content .bdt-nav li a',
			]
		);

		$this->end_controls_section();
	}	

	protected function render() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		?>


		





		


		<div class="bdt-table-of-content bdt-position-fixed bdt-position-<?php echo esc_attr($settings['index_align']); ?> bdt-card bdt-card-default bdt-padding bdt-flex">


			<div class="bdt-hidden@s bdt-offcanvas-button-wrapper">
				<a class="bdt-offcanvas-button elementor-button elementor-size-sm" bdt-toggle="target: #bdt-oc-<?php echo esc_attr($id); ?>" href="javascript:void(0)">
					<span class="elementor-button-content-wrapper">
						<span class="bdt-offcanvas-button-icon elementor-button-icon">
							<i class="fa fa-bars" aria-hidden="true"></i>
						</span>					
					</span>
				</a>
			</div>


			<div class="bdt-visible@s bdt-flex bdt-flex-middle" id="bdt-toc-<?php echo esc_attr($id); ?>"></div>
		</div>


		<div class="bdt-table-of-content bdt-position-fixed bdt-position-<?php echo esc_attr($settings['index_align']); ?> bdt-card bdt-card-default bdt-padding bdt-flex">
			<div class="bdt-flex bdt-flex-middle" id="bdt-oc-<?php echo esc_attr($id); ?>" bdt-offcanvas>
				<div class="bdt-offcanvas-bar">
				</div>
			</div>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#bdt-toc-<?php echo esc_attr($id); ?>').TableOfContent({
					tH: <?php echo esc_attr($settings['start_tag']); ?>, //lowest-level header to be included (H2)
					bH: <?php echo esc_attr($settings['end_tag']); ?>, //highest-level header to be included (H6)
					offset: <?php echo esc_attr($settings['offset']['size']); ?> //offset for scrollspy	
					//testing: true
				});
			});
		</script>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#bdt-oc-<?php echo esc_attr($id); ?> .bdt-offcanvas-bar').TableOfContent({
					tH: <?php echo esc_attr($settings['start_tag']); ?>, //lowest-level header to be included (H2)
					bH: <?php echo esc_attr($settings['end_tag']); ?>, //highest-level header to be included (H6)
					offset: <?php echo esc_attr($settings['offset']['size']); ?> //offset for scrollspy	
					//testing: true
				});
			});
		</script>

		<?php
	}
}
