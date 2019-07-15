<?php
$images = get_sub_field( 'images' );
if ( $images ) {
	echo '<div class="section section-gallery">';
	foreach ( $images as $key => $image ) {
		echo wp_get_attachment_image( $image['id'], 'full' );
	}
	echo '</div>';
}
?>