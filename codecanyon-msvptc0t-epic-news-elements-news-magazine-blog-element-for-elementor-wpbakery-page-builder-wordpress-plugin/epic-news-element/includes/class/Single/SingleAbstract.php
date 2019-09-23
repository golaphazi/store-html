<?php
/**
 * @author Jegtheme
 */

namespace EPIC\Single;

abstract class SingleAbstract {

	protected $post_type;

	protected $post_slug;

	protected $post_option_key;

	public function add_shortcode_custom_css( $post_id ) {

		$shortcodes_custom_css = get_post_meta( $post_id, '_wpb_shortcodes_custom_css', true );

		if ( ! empty( $shortcodes_custom_css ) ) {
			$shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
			echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			echo jeg_sanitize_output( $shortcodes_custom_css );
			echo '</style>';
		}
	}

	public function add_page_custom_css( $post_id ) {

		$post_custom_css = get_post_meta( $post_id, '_wpb_post_custom_css', true );

		if ( ! empty( $post_custom_css ) ) {
			$post_custom_css = strip_tags( $post_custom_css );
			echo '<style type="text/css" data-type="vc_custom-css">';
			echo jeg_sanitize_output( $post_custom_css );
			echo '</style>';
		}
	}

	public function custom_post_css() {

		if ( epic_get_option( $this->post_option_key, false ) ) {

			$custom_page_id = $this->get_custom_page_id();

			$this->add_page_custom_css( $custom_page_id );
			$this->add_shortcode_custom_css( $custom_page_id );
		}
	}

	public function single_row_action( $actions, $post ) {

		if ( $post->post_type === $this->post_type ) {
			unset( $actions['view'] );
			unset( $actions['inline hide-if-no-js'] );
		}

		return $actions;
	}

	public function ajax_template_frontend( $template_id, $template_type ) {
		if ( $template_type === $this->post_slug ) {
			$saved_templates = $this->get_template( $template_id );
			vc_frontend_editor()->setTemplateContent( $saved_templates );
			vc_frontend_editor()->enqueueRequired();
			vc_include_template( 'editors/frontend_template.tpl.php', array(
				'editor' => vc_frontend_editor(),
			) );
			die();
		}

		return $template_id;
	}

	public function ajax_template_backend( $template_id, $template_type ) {
		if ( $template_type === $this->post_slug ) {
			$content = $this->get_template( $template_id );

			return $content;
		}

		return $template_id;
	}

	public function get_template( $template_id ) {
		ob_start();
		include "template/" . $template_id . ".txt";

		return ob_get_clean();
	}

	public function render_template_library( $category ) {

		if ( $this->is_template_library() ) {

			$category['output'] = '';

			if ( $this->post_slug === $category['category'] ) {

				$category['output'] .= '
		            <div class="vc_' . $this->post_slug . '">
		                <div class="vc_column vc_col-sm-12">
		                    <div class="vc_ui-template-list vc_templates-list-my_templates vc_ui-list-bar">';

				if ( ! empty( $category['templates'] ) ) {
					$arrays = array_chunk( $category['templates'], 3 );

					foreach ( $arrays as $templates ) {
						$category['output'] .= '<div class="vc_row">';
						foreach ( $templates as $template ) {
							$category['output'] .= $this->render_item_list( $template );
						}
						$category['output'] .= '</div>';
					}
				}

				$category['output'] .= '
						    </div>
					    </div>
					</div>';
			}
		}

		return $category;
	}

	public function render_item_list( $template ) {
		$name                = isset( $template['name'] ) ? esc_html( $template['name'] ) : esc_html__( 'No title', 'epic-ne' );
		$template_id         = esc_attr( $template['unique_id'] );
		$template_id_hash    = md5( $template_id ); // needed for jquery target for TTA
		$template_name       = esc_html( $name );
		$template_name_lower = esc_attr( vc_slugify( $template_name ) );
		$template_type       = esc_attr( isset( $template['type'] ) ? $template['type'] : 'custom' );
		$custom_class        = esc_attr( isset( $template['custom_class'] ) ? $template['custom_class'] : '' );
		$column              = 12 / 3;

		$template_item = $this->render_single_item( $name, $template );

		$output = "<div class='vc_col-sm-{$column}'>
                        <div class='vc_ui-template vc_templates-template-type-{$template_type} {$custom_class}'
                            data-template_id='{$template_id}'
                            data-template_id_hash='{$template_id_hash}'
                            data-category='{$template_type}'
                            data-template_unique_id='{$template_id}'
                            data-template_name='{$template_name_lower}'
                            data-template_type='{$template_type}'
                            data-vc-content='.vc_ui-template-content'>
                            <div class='vc_ui-list-bar-item'>
                                {$template_item}        
                            </div>
                            <div class='vc_ui-template-content' data-js-content>
                            </div>
                        </div>
                    </div>";

		return $output;
	}

	protected function render_single_item( $name, $data ) {
		$template_name  = esc_html( $name );
		$template_image = esc_attr( $data['image_path'] );

		return "<div class='epic_template_vc_item' data-template-handler=''>
                    <img src='{$template_image}'/>
                    <div class='vc_ui-list-bar-item-trigger'>
			            <h3>{$template_name}</h3>
			        </div>
                </div>";
	}

	public function template_library( $data ) {

		if ( $this->is_template_library() ) {
			$data[] = array(
				'category'             => $this->post_slug,
				'category_name'        => $this->get_category_name(),
				'category_description' => $this->get_category_desc(),
				'category_weight'      => 9,
				'templates'            => $this->library()
			);
		}

		return $data;
	}

	public function library() {

		$template = array();

		if ( $this->is_template_library() ) {

			for ( $i = 1; $i <= 3; $i ++ ) {
				$data               = array();
				$data['name']       = $this->get_category_name() . ' ' . $i;
				$data['unique_id']  = $this->post_slug . '_' . $i;
				$data['image_path'] = EPIC_URL . '/assets/img/admin/' . $this->post_slug . '/' . $this->post_slug . '_' . $i . '.jpg';
				$data['type']       = $this->post_slug;

				$template[] = $data;
			}
		}

		return $template;
	}

	protected function is_template_library() {
		return get_post_type() === $this->post_type;
	}

	abstract protected function get_category_name();

	abstract protected function get_category_desc();

	abstract protected function get_custom_page_id();
}
