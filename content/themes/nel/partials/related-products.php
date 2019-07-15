<?php

$args = array(
	'posts_per_page' => 4,
	'post_type'      => 'product',
	'post__not_in'   => array( get_the_ID() )
);

$related_products = get_field( 'related_products' );
if ( $related_products ) {
	$args['post__in'] = array_map( function ( $product ) {
		return $product->ID;
	}, $related_products );
}

$products_query = new WP_Query( $args );

if ( $products_query->have_posts() ) :
	?>
    <section class="section slick-overflow-limit">
        <div class="section__content">
            <header class="row section__header">
                <div class="columns">
                    <h3 class="section__title text-center"><?php _e( 'Related products', 'nel' ); ?></h3>
                </div>
            </header>
            <div class="related-products">
                <div class="related-products-slick row small-up-1 medium-up-2 large-up-4">
					<?php
					while ( $products_query->have_posts() ) : $products_query->the_post();
						echo '<div class="column">';
						get_template_part( 'content', 'product-small' );
						echo '</div>';
					endwhile;
					?>
                </div>
            </div>
        </div>
    </section>
<?php
endif;
?>