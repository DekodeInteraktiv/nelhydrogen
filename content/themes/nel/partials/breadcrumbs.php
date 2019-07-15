<?php

if ( ! is_tax() && get_post_type() == 'cision_post' ) {

	$cision_page = get_page_by_template( 'page-templates/cision-feed.php' );
	if ( $cision_page ) {
		echo '<a title="' . esc_attr( $cision_page->post_title ) . '" href="' . get_permalink( $cision_page->ID ) . '">' . $cision_page->post_title . '</a>';
	}

} elseif ( is_tax( 'market' ) ) {

	// $markets_page = get_page_by_template('page-templates/markets.php');

	// if ($markets_page) {
	//   echo '<a href="'.get_permalink($markets_page->ID).'">'.$markets_page->post_title.'</a>';
	// }

} elseif ( is_tax( 'product_category' ) ) {

	// $products_page = get_page_by_template('page-templates/products.php');

	// if ($products_page) {
	//   echo '<a href="'.get_permalink($products_page->ID).'">'.$products_page->post_title.'</a>';
	// }


} else if (
	function_exists( 'yoast_breadcrumb' ) &&
	! is_front_page() &&
	get_post_type() != 'page' &&
	( $post && $post->post_parent != 0 )
) {
	yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
}

?>