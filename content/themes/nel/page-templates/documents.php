<?php
/*
Template Name: Documents
*/
?>
<?php get_header(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php get_template_part( 'partials/header' ); ?>

		<?php

		$terms = get_doc_page_term_ids();
		if ( $terms ) {

			$documents = get_posts( array(
				'post_type'      => 'attachment',
				'posts_per_page' => - 1,
				'meta_key'       => 'publish_date',
				'order'          => 'DESC',
				'orderby'        => 'meta_value',
				'tax_query'      => array(
					array(
						'taxonomy' => 'media_category',
						'field'    => 'term_id',
						'terms'    => $terms,
					)
				)
			) );

			if ( $documents ) {

				// Add year as key for later use
				$year_sort = array();
				foreach ( $documents as $key => $doc ) {
					$publish_date = get_field( 'publish_date', $doc->ID, false );
					$doc_year     = ( $publish_date ) ? date( 'Y', strtotime( $publish_date ) ) : date( 'Y' );
					if ( ! isset( $year_sort[ $doc_year ] ) ) {
						$year_sort[ $doc_year ] = array();
					}
					$year_sort[ $doc_year ][] = $doc;
				}

				krsort( $year_sort, SORT_NUMERIC );

				echo '<div class="container document-lists">
        <div class="row document-list small-up-2 medium-up-4 large-up-5" id="documents">';

				foreach ( $year_sort as $year => $docs ) {
					?>
                    <div data-filter="*" class="columns document-list__delimiter"><h3
                                class="document-list__delimiter-title"><?php echo $year; ?></h3></div>
					<?php
					global $post;
					foreach ( $docs as $key => $post ) {
						setup_postdata( $post );
						get_template_part( 'loop', 'document' );
					}
				}

				echo '</div></div>';

			}

		}

		?>

    </article>

<?php get_footer(); ?>