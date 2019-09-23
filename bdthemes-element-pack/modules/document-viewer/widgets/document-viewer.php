<?php
namespace ElementPack\Modules\DocumentViewer\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Document_Viewer extends Widget_Base {

	public function get_name() {
		return 'bdt-document-viewer';
	}

	public function get_title() {
		return esc_html__( 'Document Viewer', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-document-file';
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
			'file_source',
			[
				'label'         => esc_html__( 'File Source', 'bdthemes-element-pack' ),
				'description'   => esc_html__( 'any type of document file: pdf, xls, docx, ppt etc', 'bdthemes-element-pack' ),
				'type'          => Controls_Manager::URL,
				'dynamic'       => [ 'active' => true ],
				'placeholder'   => esc_html__( 'https://example.com/sample.pdf', 'bdthemes-element-pack' ),
				'label_block'   => true,
				'show_external' => false,
			]
		);

		$this->add_responsive_control(
			'document_height',
			[
				'label' => esc_html__( 'Document Height', 'bdthemes-element-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 800,
				],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1500,
						'steps' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-document-viewer iframe' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	public function render() {
		$settings  = $this->get_settings_for_display();
		$final_url = ($settings['file_source']['url']) ? '//docs.google.com/viewer?embedded=true&amp;url='. $settings['file_source']['url'] : false;
		?>

		<?php if ($final_url) : ?>
        <div class="bdt-document-viewer">
        	<iframe src="<?php echo esc_url($final_url); ?>" class="bdt-document"></iframe>
        </div>
        <?php else : ?>
        	<div class="bdt-alert-warning" bdt-alert>
        	    <a class="bdt-alert-close" bdt-close></a>
        	    <p><?php esc_html_e( 'Please enter correct URL of your document.', 'bdthemes-element-pack' ); ?></p>
        	</div>
        <?php endif; ?>

		<?php
	}
}
