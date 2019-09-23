<?php get_header(); ?>

<?php do_action( 'epic_single_archive_template_before_content' ); ?>

<div class="epic-single-archive-content editor-template">
	<?php
		if ( have_posts() ) :
            the_post();
			the_content();
		endif;
	?>
</div>

<?php do_action( 'epic_single_archive_template_after_content' ); ?>

<?php get_footer(); ?>
