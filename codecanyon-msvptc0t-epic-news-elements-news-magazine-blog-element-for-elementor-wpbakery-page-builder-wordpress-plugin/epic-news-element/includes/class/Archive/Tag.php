<?php
/**
 * @author Jegtheme
 */

namespace EPIC\Archive;

class Tag extends ArchiveAbstract {

	protected $prefix = 'epic_tag_';

	protected function setup_hook() {
		add_action( 'edit_tag_form', array( $this, 'render_options' ) );
		add_action( 'edit_post_tag', array( $this, 'save_tag' ) );
	}

	protected function get_id( $tag ) {
		if ( ! empty( $tag->term_id ) ) {
			return $tag->term_id;
		} else {
			return null;
		}
	}

	public function prepare_segments() {
		$segments = array();

		$segments[] = array(
			'id'   => 'override-tag-setting',
			'name' => esc_html__( 'Override Tag Setting', 'epic-ne' ),
		);

		return $segments;
	}

	public function save_tag() {
		if ( isset( $_POST['taxonomy'] ) && $_POST['taxonomy'] === 'post_tag' ) {
			$options = $this->get_options();
			$this->do_save($options, $_POST['tag_ID']);
		}
	}

	protected function get_options() {
		$options = array();

		$options['override_template'] = array(
			'segment' => 'override-tag-setting',
			'title'   => esc_html__( 'Override Tag Template', 'epic-ne' ),
			'desc'    => esc_html__( 'Override general tag template for this post tag.', 'epic-ne' ),
			'type'    => 'checkbox',
			'default' => false
		);

		$options['tag_template'] = array(
			'segment' => 'override-tag-setting',
			'title'      => esc_html__( 'Tag Template', 'epic-ne' ),
			'desc'       => esc_html__( 'Choose archive template that you want to use for this tag.', 'epic-ne' ),
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
			'segment' => 'override-tag-setting',
			'title'      => esc_html__( 'Number of Post', 'epic-ne' ),
			'desc'       => esc_html__( 'Set the number of post per page on tag page.', 'epic-ne' ),
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
