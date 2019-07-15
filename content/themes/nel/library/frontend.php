<?php

function nel_body_classes( $classes ) {

	// set main menu color according to background

	if ( is_search() || is_404() ) {
		$classes[] = 'bg-secondary';
	}

	if ( is_front_page() || is_search() || is_404() || is_page_template( 'page-templates/hydrogen.php' ) || is_page_template( 'page-templates/markets.php' ) ) {

		$classes[] = 'bg-header-black';

	} else if ( ! is_home() ) {

		// product header is always white
		if ( get_post_type() != 'product' ) {

			// chack background color of first block
			$blocks = get_field( 'blocks' );
			if ( isset( $blocks[0]['background_color'] ) ) {
				$classes[] = 'bg-header-' . $blocks[0]['background_color'];
			}

		}

	}

	return $classes;

}

add_filter( 'body_class', 'nel_body_classes' );


function nel_excerpt_more( $more ) {
	return '&hellip;';
}

add_filter( 'excerpt_more', 'nel_excerpt_more', 10, 1 );


/**
 * Hide password protected posts from feeds for users that are not logged in
 */
function nel_add_password_where_clause( $where ) {
	global $wpdb;

	return $where .= " AND {$wpdb->posts}.post_password = '' ";
}

function nel_exclude_password_protected_posts( $query ) {
	if ( ! is_single() && ! is_page() && ! is_admin() && ! current_user_can( 'edit_posts' ) ) {
		add_filter( 'posts_where', 'nel_add_password_where_clause', 10, 1 );
	}
}

add_action( 'pre_get_posts', 'nel_exclude_password_protected_posts' );