<?php

$queried_term = get_queried_object();

/**
 * Get another template for market taxonomy children
 */
if ( $queried_term->parent != 0 ) {
	get_template_part( 'taxonomy-market', 'child' );
	exit;
}


?>
<?php get_header(); ?>

    <article>

		<?php get_template_part( 'partials/header' ); ?>

		<?php

		/**
		 * Markets grid list
		 */

		get_template_part( 'partials/market-list' );

		?>

		<?php

		/**
		 * Pagebuilder modules
		 */

		get_template_part( 'partials/blocks' );

		?>

		<?php

		/**
		 * Product wizard
		 */

		if ( get_field( 'show_product_wizard', $queried_term ) ) {
			get_template_part( 'library/components/product-wizard' );
		}
		?>

		<?php

		/**
		 * Related products
		 */

		if ( have_posts() ) :
			?>
            <section id="related-products" class="related-products section slick-overflow-limit">
                <div class="section__content">
                    <header class="row section__header">
                        <div class="column text-center">
                            <h3><?php _e( 'Related products', 'nel' ); ?></h3>
                        </div>
                    </header>
                    <div class="related-products-slick row small-up-2 medium-up-2 large-up-4">
						<?php
						while ( have_posts() ) : the_post();
							echo '<div class="columns">';
							get_template_part( 'content', 'product-small' );
							echo '</div>';
						endwhile;
						?>
                    </div>
                    <footer class="row section__footer">
                        <div class="columns text-center">
                            <a class="btn btn-a btn-small"
                               href="<?php echo get_page_template_url( 'page-templates/products.php' ); ?>"><?php _e( 'View all products', 'nel' ); ?></a>
                        </div>
                    </footer>
                </div>
            </section>
            <hr class="section-divider"/>
		<?php
		endif;
		?>

		<?php

		/**
		 * FAQ
		 */
		get_template_part( 'partials/faq' );

		?>

    </article>

<?php get_footer(); ?>