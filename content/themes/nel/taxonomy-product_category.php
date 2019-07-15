<?php get_header(); ?>

<?php

if ( is_tax() ) {

	global $wp_query;
	$products_query = $wp_query;

	$page       = get_page_by_template( 'page-templates/products.php' );
	$page_title = apply_filters( 'the_title', $page->post_title );
	$page_id    = $page->ID;

} else {

	$page_id        = $post->ID;
	$page_title     = get_the_title();
	$products_query = new WP_Query( array(
		'post_type'      => 'product',
		'posts_per_page' => - 1,
	) );

}

?>

    <article class="Article">

        <header class="Article__header container">
            <div class="row columns">
                <h1><?php echo $page_title; ?></h1>
				<?php get_template_part( 'partials/product-category-nav' ); ?>
            </div>
        </header>

        <div class="Article__content container">
            <div class="row product-list">
				<?php
				if ( $products_query->have_posts() ) :
					while ( $products_query->have_posts() ) : $products_query->the_post();
						$card_style = get_field( 'product_card_style' );
						$classnames = array(
							'column',
							'small-12',
							'product-list__item--' . $card_style,
							'product-list__item',
						);
						if ( $card_style == 'medium' ) {
							$classnames[] = 'medium-12 large-8';
						} elseif ( $card_style == 'large' ) {
							// $classnames[] = 'medium-8 large-4';
						} else {
							$classnames[] = 'medium-6 large-4';
						}
						echo '<div class="' . implode( ' ', $classnames ) . '">';
						get_template_part( 'content', 'product' );
						echo '</div>';
					endwhile;
				else:
					_e( 'No products found', 'nel' );
				endif;
				wp_reset_postdata();
				?>
            </div>
        </div>

		<?php

		get_pagebuilder( $page_id );
		get_template_part( 'library/components/product-wizard' );

		?>

    </article>

<?php get_footer(); ?>