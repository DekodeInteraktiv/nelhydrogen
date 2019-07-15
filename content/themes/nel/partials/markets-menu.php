<?php
$args  = array(
	'taxonomy'   => 'market',
	'hide_empty' => false,
	'orderby'    => 'term_order',
	'order'      => 'ASC',
	'parent'     => 0,
);
$terms = get_terms( $args );
if ( $terms ) {
	echo '<div class="bg-secondary">';
	echo '<nav class="row markets-nav small-up-1 medium-up-3 medium-text-center">';
	foreach ( $terms as $term ) {
		$url = nel_get_term_url( $term );
		?>
        <a class="columns markets-nav__item" href="<?php echo $url; ?>">
            <div class="markets-nav__text">
                <h3 class="markets-nav__title"><?php echo $term->name; ?></h3>
            </div>
            <div class="markets-nav__image">
				<?php
				$image = get_field( 'featured_image', $term );
				if ( $image ) {
					echo wp_get_attachment_image( $image, 'large' );
				}
				?>
            </div>
        </a>
		<?php
	}
	echo '</nav>';
	echo '</div>';
}
?>