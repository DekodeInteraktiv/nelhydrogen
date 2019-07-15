<?php

global $term;

$args  = array(
	'hide_empty' => true,
	'orderby'    => 'term_order',
	'order'      => 'ASC'
);
$terms = get_terms( array( 'cision_category' ), $args );

if ( $terms ) {

	if ( ! is_tax() ) {
		$current_term_title = __( 'All', 'nel' );
	} else {
		$current_term       = get_queried_object();
		$current_term_title = $current_term->name;
	}


	echo '<div class="button-nav">';
	echo '<button class="button-nav__toggle">
    <span class="button-nav__current">' . $current_term_title . '</span>
    <span class="button-nav__label">' . __( 'Select', 'nel' ) . '</span>
  </button>';
	echo '<ul class="button-nav__list">';

	$classes       = [ 'button-nav__item' ];
	$classes[]     = ( ! is_tax() ) ? 'button-nav__item--current' : '';
	$products_page = get_page_by_template( 'page-templates/cision-feed.php' );
	if ( $products_page ) {
		?>
        <li class="<?php echo implode( $classes, ' ' ); ?>">
            <a class="button-nav__link"
               href="<?php echo get_permalink( $products_page->ID ); ?>"><?php _e( 'All', 'nel' ); ?></a>
        </li>
		<?php
	}

	foreach ( $terms as $key => $term_item ) {
		$classes   = [ 'button-nav__item' ];
		$classes[] = ( $term && $term == $term_item->slug ) ? 'button-nav__item--current' : '';
		?>
        <li class="<?php echo implode( $classes, ' ' ); ?>">
            <a class="button-nav__link"
               href="<?php echo get_term_link( $term_item ); ?>"><?php echo $term_item->name; ?></a>
        </li>
		<?php
	}
	echo '</ul>';

	echo '</div>';

}


?>