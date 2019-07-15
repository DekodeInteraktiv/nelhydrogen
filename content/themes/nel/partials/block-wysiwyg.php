<?php

global $parent_layout, $block_count;

$content_class = [ 'row', 'section__content' ];
$wrapper_class = [ 'section--wysiwyg' ];

$is_parent = ! ( isset( $parent_layout ) && $parent_layout == 'columns' );

if ( $is_parent ) {
	$wrapper_class[] = 'section';
	$wrapper_class[] = 'section-' . $block_count;
} else {
	$wrapper_class[] = 'section-child';
}

$content_column_class = [ 'small-12' ];
$image_column_class   = [ 'small-12' ];

// CONTAINER ASPECT

$before = '';
$after  = '';
$aspect = get_sub_field( 'container_aspect_ratio' );
if ( $aspect ) {

	if ( $aspect == 'windowheight' ) {

		$wrapper_class[] = 'Panel';
		$content_class[] = 'Panel__row align-middle';
		$before          = '<div class="Panel__container container">';
		$after           = '</div>';

	} else {

		$wrapper_class[] = 'aspect';

		if ( ! get_sub_field( 'content' ) ) {
			$wrapper_class[] = 'small-aspect-' . $aspect;
		} else {
			$wrapper_class[] = 'large-aspect-' . $aspect;
		}

		$wrapper_class[] = 'aspect';
		$content_class[] = 'align-middle full-height';
		$before          = '<div class="container aspect-content">';
		$after           = '</div>';

	}

} else if ( $is_parent ) {

	$wrapper_class[] = 'container';

}


// BACKGROUND COLOR

$data_bg = '';
if ( $background_color = get_sub_field( 'background_color' ) ) {
	$wrapper_class[] = 'bg-' . $background_color;
	$data_bg         = $background_color;
} else {
	$wrapper_class[] = 'bg-default';
}


// IMAGE

$image               = '';
$image_background    = '';
$image_id            = get_sub_field( 'image' );
$image_as_background = get_sub_field( 'image_background' );

if ( $image_id ) {
	if ( $image_as_background ) {
		$bgset = hey_get_attachment_image_bgset( $image_id, 'full' );
		if ( $aspect ) {
			$image_background = '<div class="section__bg-image lazyload" ' . $bgset . '></div>';
		} else {
			$image_background = '<div class="section__bg-image">' . wp_get_attachment_image( $image_id, 'full' ) . '</div>';
		}
	} else {
		$image = wp_get_attachment_image( $image_id, 'full' );
	}
}

// VIDEO

$video_background = '';
$videos           = get_sub_field( 'video' );

if ( ! empty( $videos ) ) {
	$video_background = '<div class="section__bg-video"><video autoplay loop preload muted>';
	foreach ( $videos as $key => $video ) {
		$video_background .= '<source src="' . $video['url'] . '" type="' . $video['mime_type'] . '">';
	}
	$video_background .= '</video></div>';
}

// LAYOUT
/*
center
left
right
*/
$content_column = '';
$image_column   = '';

$layout          = get_sub_field( 'wysiwyg_layout' );
$image_is_column = false;

switch ( $layout ) {

	case 'left': // text left
		if ( $image != '' ) {
			$content_column_class[] = 'large-6';
			$image_column_class[]   = 'large-6';
			$content_class[]        = 'flex-dir-row-reverse';
		} else {
			$content_column_class[] = 'large-6';
		}
		$image_is_column = true;
		$wrapper_class[] = 'content-columns';
		break;

	case 'right': // text right
		if ( $image != '' ) {
			$content_column_class[] = 'large-6';
			$image_column_class[]   = 'large-6';
		} else {
			$content_column_class[] = 'large-6';
			$content_class[]        = 'flex-dir-row-reverse';
		}
		$image_is_column = true;
		$wrapper_class[] = 'content-columns';
		break;

	case 'center':
		$content_class[]        = 'align-center';
		$content_column_class[] = 'large-10 xlarge-8';
		break;

	default:
		$content_column_class[] = 'content-below';

}


// TEXT ALIGNMENT

if ( $text_alignment = get_sub_field( 'text_align' ) ) {
	$content_column_class[] = 'medium-text-' . $text_alignment;
}


// GENERATE COLUMNS

$content_column = '<div class="columns content-column ' . implode( ' ', $content_column_class ) . '"><div class="wysiwyg">';

if ( $image_is_column == false && $image != '' ) {

	// add image to content column
	$content_column .= '<div class="image-inner">' . $image . '</div>';

} else if ( $image != '' ) {

	$image_column = '<div class="columns image-column ' . implode( ' ', $image_column_class ) . '">' . $image . '</div>';

}

$content_column .= get_sub_field( 'content' ) . '</div></div>';

if ( ! get_sub_field( 'content' ) ) {
	$content_column = '';
}

if ( $image_column != '' && $content_column != '' ) {
	$content_class[] = 'align-middle';
}

// FINAL OUTPUT
?>

<div id="section-<?php echo sanitize_title( get_sub_field( 'title' ) ); ?>"
     data-nav-title="<?php the_sub_field( 'title' ); ?>" data-bg="<?php echo $data_bg; ?>"
     class="<?php echo implode( ' ', $wrapper_class ); ?>">
	<?php
	echo $image_background;
	echo $video_background;
	?>
	<?php echo $before; ?>
    <div data-aos="fade-zoom-in" data-aos-offset="200" data-aos-easing="ease-in-sine" data-aos-duration="300"
         class="<?php echo implode( ' ', $content_class ); ?>">
		<?php
		echo $image_column;
		echo $content_column;
		?>
    </div>
	<?php echo $after; ?>
</div>