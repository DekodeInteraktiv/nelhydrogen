<?php get_header(); ?>

    <article class="page-search">

        <header class="site-pad page-header">
            <div class="row align-center">
                <div class="columns large-10 xlarge-8 medium-text-center">
                    <h1 class="show-for-sr"><?php _e( 'Search', 'nel' ); ?></h1>
					<?php get_search_form(); ?>
                    <div class=""><p><?php echo nel_get_search_result_text(); ?></p></div>
                </div>
            </div>
        </header>

        <div class="site-pad">
            <div class="row align-center">
                <div class="column large-10 xlarge-8">

					<?php
					if ( have_posts() ) :

						echo '<div class="results">';

						while ( have_posts() ) : the_post();

							get_template_part( 'content', 'search' );

						endwhile;

						echo '</div>';

						$args      = array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;'
						);
						$pagelinks = paginate_links( $args );

						if ( $pagelinks ) :
							echo '<div class="pagination">' . $pagelinks . '</div>';
						endif;

					else:

						get_template_part( 'content', 'none' );

					endif;
					?>

                </div>
            </div>
        </div>

    </article>

<?php get_footer(); ?>