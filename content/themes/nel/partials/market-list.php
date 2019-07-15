<?php

$queried_term = get_queried_object();

if ( $queried_term->parent != 0 ) {
	$market = get_term_by( 'id', $queried_term->parent, $queried_term->taxonomy );
} else {
	$market = $queried_term;
}

$term_children = get_terms( array(
	'taxonomy'   => 'market',
	'hide_empty' => false,
	'parent'     => $market->term_id,
) );

if ( ! empty( $term_children ) ) {

	?>

    <section id="details" class="section bg-secondary">
        <div class="section__content">
			<?php
			$subsection_title = get_field( 'subsection_title', $market );
			if ( $subsection_title ) {
				?>
                <header class="section__header text-center">
                    <h3><?php echo $subsection_title; ?></h3>
                </header>
				<?php
			}
			?>
            <ul class="row small-up-2 medium-up-4 large-up-5 text-center markets-list">
				<?php

				foreach ( $term_children as $child ) {
					$image = get_field( 'featured_image', $child );
					if ( $image ) {
						$image = wp_get_attachment_image( $image, 'large' );
					} else {
						$image = '<img src="' . get_template_directory_uri() . '/images/MarketPlaceholder.png" alt="">';
					}
					echo '<li class="columns markets-list__item">
            <a class="markets-list__link ajax-popup-link" href="' . get_term_link( $child ) . '">
              <div class="markets-list__image">' . $image . '</div>
              <h4 class="markets-list__title">' . $child->name . '</h4>
            </a>
          </li>';
				}

				?>
            </ul>
        </div><!-- .section__content -->
    </section><!-- .section -->

	<?php
}