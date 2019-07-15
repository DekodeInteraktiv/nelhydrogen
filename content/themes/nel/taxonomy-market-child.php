<?php

$term        = get_queried_object();
$parent_term = get_term( $term->parent, 'market' );
$image       = get_field( 'featured_image', $term );

?>

<?php get_header(); ?>

    <article class="Article js-mfp-content">

        <header class="Article__header container">
			<?php
			if ( $image ) {
				echo '<div class="Article__icon">' . wp_get_attachment_image( $image, 'large' ) . '</div>';
			}
			?>
            <a href="<?php echo get_term_link( $parent_term ); ?>"
               class="Article__bradcrumb"><?php echo $parent_term->name; ?></a>
            <h1 class="Article__title"><?php single_term_title(); ?></h1>
        </header>

        <div class="Article__content container">
            <div class="row align-center">
                <div class="columns medium-10 large-8 wysiwyg">
					<?php echo apply_filters( 'the_content', $term->description ); ?>
                </div>
            </div>
        </div>

		<?php

		/**
		 * Loop through all products related to this category
		 */
		if ( have_posts() ) {
			?>
            <div class="product-flags container">
                <h3 class="product-flags__header"><?php _e( 'Related products', 'nel' ); ?></h3>
                <div class="product-flags__list row small-up-1 medium-up-2">
					<?php
					while ( have_posts() ) : the_post();
						echo '<div class="columns">';
						get_template_part( 'content-product', 'tiny' );
						echo '</div>';
					endwhile;
					?>
                </div>
            </div>
			<?php
		}

		?>
        <footer class="Article__footer">
            <p><a title="<?php _e( 'Close', 'nel' ); ?>" href="#"
                  class="modal-close btn btn-d btn-small"><?php _e( 'Close', 'nel' ); ?></a></p>
        </footer>

    </article>

<?php get_template_part( 'partials/market-list' ); ?>

<?php get_footer(); ?>