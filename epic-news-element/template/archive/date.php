<?php get_header(); ?>

<?php do_action( 'epic_single_date_template_before_content' ); ?>

<div class="jeg_vc_content">
	<?php
	if ( have_posts() ) :
		the_post();

		$template_id  = epic_get_option('single_date_template_id');

		if ( $template_id )
			echo jeg_render_builder_content( $template_id );

	endif;
	?>
</div>

<?php do_action( 'epic_single_date_template_after_content' ); ?>

<?php get_footer(); ?>
