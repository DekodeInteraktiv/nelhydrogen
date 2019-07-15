<?php
$terms = get_doc_page_term_ids();
if ( $terms ) {

	$documents = get_posts( array(
		'post_type'      => 'attachment',
		'posts_per_page' => 5,
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

		?>
        <hr class="section-divider"/>
        <section data-nav-title="<?php echo _e( 'Reports and presentations', 'nel' ); ?>" class="section">
            <div class="section__content">
                <header class="section__header row large-text-center">
                    <div class="columns">
                        <h3><?php _e( 'Latest reports and presentations', 'nel' ); ?></h3>
                    </div>
                </header>
                <div class="section__body row small-up-2 medium-up-3 large-up-5">
					<?php
					global $post;
					foreach ( $documents as $key => $post ) {
						setup_postdata( $post );
						get_template_part( 'loop', 'document' );
					}
					wp_reset_postdata();
					?>
                </div>
				<?php
				$doc_page = get_page_by_template( 'page-templates/documents.php' );
				if ( $doc_page ) {
					?>
                    <footer class="section_footer large-text-center row">
                        <div class="column">
							<?php
							echo '<a class="btn btn-a btn-small" href="' . get_permalink( $doc_page->ID ) . '">' . __( 'View full archive', 'nel' ) . '</a>';
							?>
                        </div>
                    </footer>
				<?php } ?>
            </div>
        </section>
		<?php

	}

}