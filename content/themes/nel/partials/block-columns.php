<?php
$rows = get_sub_field( 'content' );
if ( have_rows( 'content' ) ) :
	$count = 0;
	global $parent_layout;
	$parent_layout = 'columns';
	echo '<div data-nav-title="Columns title" class="section section--columns">';
	echo '<div class="row medium-up-' . count( $rows ) . '">';
	while ( have_rows( 'content' ) ) : the_row();
		echo '<div class="columns col-' . $count . ' col-' . get_row_layout() . '">';
		get_template_part( 'partials/block', get_row_layout() );
		echo '</div>';
		$count ++;
	endwhile;
	echo '</div>';
	echo '</div>';
	$parent_layout = '';
endif;