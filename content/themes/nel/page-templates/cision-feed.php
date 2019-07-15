<?php
/*
Template Name: Cision Feed
*/
?>
<?php get_header(); ?>

<?php get_template_part( 'partials/header' ); ?>

    <div class="container site-pad-bottom">
        <div class="row cision-feed-nav align-center">
            <div class="column">
                <div class="row">
                    <div class="columns cision-feed-tools">
                        <input type="hidden" class="cision-feed-select" value="9b3a2801de">
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-center">
            <div class="columns medium-10 large-8">
				<?php

				$ci_args = array(
					'post_type'      => 'cision_post',
					'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
					'posts_per_page' => 20
				);

				if ( is_tax() ) {
					$current_term         = get_queried_object();
					$ci_args['tax_query'] = array(
						array(
							'taxonomy' => $current_term->taxonomy,
							'field'    => 'term_id',
							'terms'    => $current_term->term_id
						)
					);
				}

				$ci_query = new WP_Query( $ci_args );
				if ( $ci_query->have_posts() ) {

					echo '<ul class="PostLoop">';
					while ( $ci_query->have_posts() ) : $ci_query->the_post();
						echo '<li class="PostLoop__item">';
						get_template_part( 'content', 'cision' );
						echo '</li>';
					endwhile;
					echo '</ul>';

					$big    = 9999;
					$pagina = paginate_links( array(
						'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
						'format'  => '?paged=%#%',
						'current' => max( 1, get_query_var( 'paged' ) ),
						'total'   => $ci_query->max_num_pages
					) );

					if ( $pagina ) {
						echo '<div class="Pagination">';
						echo $pagina;
						echo '</div>';
					}

					wp_reset_postdata();

				}
				?>
            </div>
        </div>
    </div>

<?php get_template_part( 'partials/blocks' ); ?>

<?php get_footer(); ?>