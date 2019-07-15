<?php
global $tmpl_atts;
$args = array(
	'post_type'      => 'person',
	'order_by'       => 'menu_order',
	'order'          => 'ASC',
	'posts_per_page' => - 1,
);

if ( isset( $tmpl_atts['cat'] ) ) {

	$args['tax_query'] = array(
		array(
			'taxonomy' => 'person_category',
			'field'    => 'slug',
			'terms'    => $tmpl_atts['cat'],
		)
	);

}

$people = get_posts( $args );

if ( $people ) {

	if ( isset( $tmpl_atts['layout'] ) && $tmpl_atts['layout'] == 'board' ) {

		$count = 0;
		echo '<div class="board-list row align-center board-list--centered">';
		global $post;
		foreach ( $people as $key => $post ) {
			setup_postdata( $post );
			echo '<div class="columns small-12 medium-6 large-4 board-list__item">';
			get_template_part( 'loop', 'person' );
			echo '</div>';
			if ( $count == 0 || ( $count > 0 && $count % 2 == 0 ) ) {
				echo '<div class="columns small-12"></div>';
			}
			$count ++;
		}
		wp_reset_postdata();
		echo '</div>';

	} else {

		echo '<div class="row small-up-1 medium-up-2 large-up-3 board-list board-list--images">';
		global $post;
		foreach ( $people as $key => $post ) {
			setup_postdata( $post );
			echo '<div class="columns board-list__item">';
			get_template_part( 'loop', 'person' );
			echo '</div>';
		}
		wp_reset_postdata();
		echo '</div>';


	}


}
?>