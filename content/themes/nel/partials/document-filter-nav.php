<?php

$terms = get_doc_page_terms();

if ( $terms ) {
	echo '<div class="button-nav">';
	echo '<button class="button-nav__toggle">
    <span id="button-nav-label" class="button-nav__current">' . __( 'Latest', 'nel' ) . '</span>
    <span class="button-nav__label">' . __( 'Filter', 'nel' ) . '</span>
  </button>';
	echo '<ul data-scope="DocumentFilter" data-filter-list="#documents" class="button-nav__list">';

	$classes = [ 'button-nav__item' ];
	?>
    <li class="<?php echo implode( $classes, ' ' ); ?> button-nav__item--current">
        <a data-title-change="#button-nav-label" data-filter="" class="button-nav__link"
           href="#"><?php _e( 'Latest', 'nel' ); ?></a>
    </li>
	<?php

	foreach ( $terms as $key => $term_item ) {
		$classes = [ 'button-nav__item' ];
		?>
        <li class="<?php echo implode( $classes, ' ' ); ?>">
            <a data-title-change="#button-nav-label" data-filter="<?php echo $term_item->slug; ?>"
               class="button-nav__link" href="#"><?php echo $term_item->name; ?>s</a>
        </li>
		<?php
	}
	echo '</ul>';
	echo '</div>';

}
?>
