<?php get_header(); ?>

<?php do_action( 'epic_single_post_template_before_content' ); ?>

<div class="epic-single-post-content editor-template">
	<?php
		if ( have_posts() ) :
            the_post();
			the_content();
		endif;
	?>
</div>

<?php do_action( 'epic_single_post_template_after_content' ); ?>

<?php get_footer(); ?>
