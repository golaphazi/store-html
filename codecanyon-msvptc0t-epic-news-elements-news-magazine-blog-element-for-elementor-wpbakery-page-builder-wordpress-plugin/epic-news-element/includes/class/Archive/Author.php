<?php
/**
 * @author Jegtheme
 */

namespace EPIC\Archive;

class Author extends ArchiveAbstract {

	protected $prefix = 'epic_author_';

	protected function setup_hook() {
		add_action( 'show_user_profile', array( $this, 'render_options' ) );
		add_action( 'edit_user_profile', array( $this, 'render_options' ) );

		add_action( 'edit_user_profile_update', array( $this, 'save_user' ) );
		add_action( 'personal_options_update',  array( $this, 'save_user' ) );
	}

	protected function get_id( $user ) {
		if ( ! isset( $user->ID ) || empty( $user->ID ) ) {
			return null;
		} else {
			return $user->ID;

		}
	}

	public function save_user( $user_id ) {
		if ( current_user_can( 'edit_user', $user_id ) ) {
			$options = $this->get_options();
			$this->do_save($options, $_POST['user_id']);
		}
	}


	public function prepare_segments() {
		$segments = array();

		$segments[] = array(
			'id'   => 'override-author-setting',
			'name' => esc_html__( 'Override Author Setting', 'epic-ne' ),
		);

		return $segments;
	}

	protected function get_options() {
		$options = array();

		$options['override_template'] = array(
			'segment' => 'override-author-setting',
			'title'   => esc_html__( 'Override Author Template', 'epic-ne' ),
			'desc'    => esc_html__( 'Override general author template for this user.', 'epic-ne' ),
			'type'    => 'checkbox',
			'default' => false
		);

		$options['author_template'] = array(
			'segment'    => 'override-author-setting',
			'title'      => esc_html__( 'Author Template', 'epic-ne' ),
			'desc'       => esc_html__( 'Choose archive template that you want to use for this user.', 'epic-ne' ),
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
			'segment'    => 'override-author-setting',
			'title'      => esc_html__( 'Number of Post', 'epic-ne' ),
			'desc'       => esc_html__( 'Set the number of post per page on author page.', 'epic-ne' ),
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
