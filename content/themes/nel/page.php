<?php get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		if ( ! post_password_required() ) {
			get_template_part( 'content', 'page' );
		} else {
			get_template_part( 'partials/post-password' );
		}
	endwhile;
endif;
?>

<?php get_footer(); ?>