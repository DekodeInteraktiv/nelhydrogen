<?php

global $block_count;
$block_count = ( is_front_page() ) ? 1 : 0;

if ( ! isset( $acf_id ) ) {
	if ( is_tax() ) {
		$block_count = 1;
		$acf_id      = get_queried_object();
	} else {
		$acf_id = get_the_ID();
	}
}

$blocks = get_field( 'blocks', $acf_id );

if ( $blocks ) :

	$before = $after = '';

	if ( get_field( 'blocks_navigation_enable', $acf_id ) ) {

		$before = '<div class="panelizer">
			<div class="plz-panels">';

		$after = '</div>
			<div class="plz-nav"></div>
		</div>';

	}

	echo $before;
	while ( have_rows( 'blocks', $acf_id ) ) : the_row();

		// Check block status
		$status = get_sub_field( 'status' );
		if ( $status == 'hidden' ) {
			continue;
		} elseif ( $status == 'private' && ! current_user_can( 'edit_posts' ) ) {
			continue;
		}

		// Add anchor for direct linking
		$title = get_sub_field( 'title' );
		if ( $title ) {
			echo '<div data-magellan-target="' . sanitize_title( $title ) . '" id="' . sanitize_title( $title ) . '"></div>';
		}

		if ( ! get_sub_field( 'background_color' ) && get_sub_field( 'hairline_above' ) ) {
			echo '<hr class="section-divider" />';
		}

		get_template_part( 'partials/block', get_row_layout() );
		$block_count ++;

	endwhile;
	echo $after;

endif;

?>