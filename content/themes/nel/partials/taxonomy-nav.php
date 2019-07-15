<?php

/**
 * Navigation that will work on all taxonomies
 */

$current_term = get_queried_object();

$args  = array(
	'hide_empty' => true,
	'orderby'    => 'term_order',
	'order'      => 'ASC'
);
$terms = get_terms( array( $current_term->taxonomy ), $args );

if ( $terms ) {

	?>
    <div class="button-nav">
        <button class="button-nav__toggle">
            <span class="button-nav__current"><?php echo $current_term->name; ?></span>
            <span class="button-nav__label"><?php _e( 'Select', 'nel' ); ?></span>
        </button>
        <ul class="button-nav__list">
			<?php
			foreach ( $terms as $key => $term_item ) {
				$classes   = [ 'button-nav__item' ];
				$classes[] = ( $current_term->slug == $term_item->slug ) ? 'button-nav__item--current' : '';
				?>
                <li class="<?php echo implode( $classes, ' ' ); ?>">
                    <a class="button-nav__link"
                       href="<?php echo get_term_link( $term_item ); ?>"><?php echo $term_item->name; ?></a>
                </li>
				<?php
			}
			?>
        </ul>
    </div>
	<?php

}


?>