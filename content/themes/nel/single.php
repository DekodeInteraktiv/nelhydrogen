<?php

get_header();

if ( have_posts() ) :

	while ( have_posts() ) : the_post();

		if ( ! post_password_required() ) {

			if ( get_post_type() == 'post' ) {
				getComponent( 'Post' );
			} else {
				get_template_part( 'content', 'single-' . get_post_type() );
			}

		} else {

			get_template_part( 'partials/post-password' );

		}

	endwhile;

endif;

get_footer();

?>