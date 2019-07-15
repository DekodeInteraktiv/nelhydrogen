<?php
$image = get_sub_field( 'image' );
if ( $image ) {
	echo '<div class="section section--image">';
	echo wp_get_attachment_image( $image['id'], 'full' );
	echo '</div>';
}
?>