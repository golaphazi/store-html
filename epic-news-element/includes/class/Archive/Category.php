<?php
/**
 * @author Jegtheme
 */

namespace EPIC\Archive;

use Jeg\Util\Style_Generator;

class Category extends ArchiveAbstract {
	protected $prefix = 'epic_category_';

	protected function setup_hook() {
		add_action( 'edit_category_form', array( $this, 'render_options' ) );
		add_action( 'edit_category', array( $this, 'save_category' ) );
		add_filter( 'jeg_generate_inline_style', array( $this, 'build_dynamic_css' ) );
	}

	protected function get_id( $tag ) {
		if ( ! empty( $tag->term_id ) ) {
			return $tag->term->id;
		} else {
			return null;
		}
	}

	public function get_override_color( $key ) {
		$text = get_option( $this->prefix . 'text_color', array() );

		return isset( $text[ $key ] ) ? $text[ $key ] : '';
	}

	public function get_override_background( $key ) {
		$background = get_option( $this->prefix . 'bg_color', array() );

		return isset( $background[ $key ] ) ? $background[ $key ] : '';
	}

	public function build_dynamic_css( $style ) {
		$options = get_option( $this->prefix . 'override_color', array() );

		foreach ( $options as $key => $option ) {
			if ( $option ) {
				$background = get_option( $this->prefix . 'bg_color', array() );
				$text       = get_option( $this->prefix . 'text_color', array() );

				$background = isset( $background[ $key ] ) ? $background[ $key ] : '';
				$text       = isset( $text[ $key ] ) ? $text[ $key ] : '';

				$category = get_term( $key );
				$slug     = $category->slug;

				// background color + border color
				$style .=
					".jeg_heroblock .jeg_post_category a.category-{$slug},
                    .jeg_thumb .jeg_post_category a.category-{$slug},
                    .jeg_pl_lg_box .jeg_post_category a.category-{$slug},
                    .jeg_pl_md_box .jeg_post_category a.category-{$slug},
                    .jeg_postblock_carousel_2 .jeg_post_category a.category-{$slug},
                    .jeg_slide_caption .jeg_post_category a.category-{$slug} { 
                        background-color: {$background}; 
                        border-color: {$background}; 
                        color: {$text}; 
                    }";
			}
		}

		return $style;
	}

	public function is_category_page() {
		return in_array( $GLOBALS['pagenow'], array( 'term.php' ) );
	}

	public function prepare_segments() {
		$segments = array();

		$segments[] = array(
			'id'   => 'override-category-setting',
			'name' => esc_html__( 'Override Category Setting', 'epic-ne' ),
		);

		return $segments;
	}

	public function render_options( $tag ) {
		if ( ! empty( $tag->term_id ) ) {
			$segments = $this->prepare_segments();
			$fields   = $this->prepare_fields( $tag->term_id );
			$id       = 'archive-' . $tag->term_id;

			$data = array(
				'segments' => $segments,
				'fields'   => $fields,
			)
			?>
			<div id="<?php echo esc_html( $id ); ?>" data-id="<?php echo esc_html( $id ); ?>" class="archive-form-holder"></div>
			<script type="text/javascript">
                (function ($) {
                    $(document).ready(function () {
                        window.widgetData = <?php echo wp_json_encode( $data ); ?>;
                        if (undefined !== jeg.archive.build) {
                            jeg.archive.build('<?php echo esc_html($id); ?>', widgetData);
                        }
                    });
                })(jQuery);
			</script>
			<?php
		}
	}

	public function save_category() {
		if ( isset( $_POST['taxonomy'] ) && $_POST['taxonomy'] === 'category' ) {
			$options = $this->get_options();
			$this->do_save($options, $_POST['tag_ID']);
			$this->generate_dynamic_style();
		}
	}

	protected function generate_dynamic_style() {
		$style_instance = Style_Generator::get_instance();
		$style_instance->remove_dynamic_file();
	}

	protected function get_options() {
		$options = array();

		$options['override_color'] = array(
			'segment' => 'override-category-setting',
			'title'   => esc_html__( 'Override Category Color', 'epic-ne' ),
			'desc'    => esc_html__( 'Override category general color setting.', 'epic-ne' ),
			'type'    => 'checkbox',
			'default' => false
		);

		$options['bg_color'] = array(
			'segment'    => 'override-category-setting',
			'title'      => esc_html__( 'Category Background Color', 'epic-ne' ),
			'desc'       => esc_html__( 'Main color for this category.', 'epic-ne' ),
			'default'    => '',
			'type'       => 'color',
			'dependency' => array(
				array(
					'field'    => 'override_color',
					'operator' => '==',
					'value'    => true
				)
			)
		);

		$options['text_color'] = array(
			'segment'    => 'override-category-setting',
			'title'      => esc_html__( 'Category Text Color', 'epic-ne' ),
			'desc'       => esc_html__( 'Choose text color for this category.', 'epic-ne' ),
			'default'    => '',
			'type'       => 'color',
			'dependency' => array(
				array(
					'field'    => 'override_color',
					'operator' => '==',
					'value'    => true
				)
			)
		);

		$options['override_template'] = array(
			'segment' => 'override-category-setting',
			'title'   => esc_html__( 'Override Category Template', 'epic-ne' ),
			'desc'    => esc_html__( 'Override general category template for this category.', 'epic-ne' ),
			'type'    => 'checkbox',
			'default' => false
		);

		$options['category_template'] = array(
			'segment'    => 'override-category-setting',
			'title'      => esc_html__( 'Category Template', 'epic-ne' ),
			'desc'       => esc_html__( 'Choose archive template that you want to use for this category.', 'epic-ne' ),
			'type'       => 'select',
			'options'    => epic_get_all_custom_archive_template(),
			'dependency' => array(
				array(
					'field'    => 'override_template',
					'operator' => '==',
					'value'    => true
				)
			)
		);

		$options['number_post'] = array(
			'segment'    => 'override-category-setting',
			'title'      => esc_html__( 'Number of Post', 'epic-ne' ),
			'desc'       => esc_html__( 'Set the number of post per page on category page.', 'epic-ne' ),
			'type'       => 'slider',
			'default'    => 10,
			'options'     => array(
				'min'  => 1,
				'max'  => 100,
				'step' => 1,
			),
			'dependency' => array(
				array(
					'field'    => 'override_template',
					'operator' => '==',
					'value'    => true
				)
			)
		);

		return $options;

	}
}
