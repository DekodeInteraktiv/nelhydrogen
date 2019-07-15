<?php

function hey_enable_lazysizes_support( $attr, $attachment, $size ) {

	// if image is gif lazyload the full size as the resized version either wont animate or looks jaggy
	$ext = pathinfo( $attr['src'], PATHINFO_EXTENSION );

	if ( isset( $attr['srcset'] ) ) {

		// add required size attributes
		$attr['data-sizes']  = 'auto';
		$attr['data-srcset'] = $attr['srcset'];

		// remove original srcset attribute as it conflicts with data-srcset
		unset( $attr['srcset'] );

		// add lazyload class
		$class   = explode( ' ', $attr['class'] );
		$class[] = 'lazyload lazyhide';

		// add orientation class
		$sizes       = wp_get_attachment_image_src( $attachment->ID, $size );
		$orientation = ( $sizes[1] > $sizes[2] ) ? 'landscape' : 'portrait';
		$class[]     = $orientation;

		$attr['class'] = implode( ' ', $class );

	} else {

		if ( $ext == 'gif' ) {

			$class         = explode( ' ', $attr['class'] );
			$class[]       = 'lazyload lazyhide';
			$attr['class'] = implode( ' ', $class );

			$full_size        = wp_get_attachment_image_src( $attachment->ID, 'full' );
			$attr['data-src'] = $full_size[0];

		}

	}

	return $attr;

}

add_filter( 'wp_get_attachment_image_attributes', 'hey_enable_lazysizes_support', 10, 3 );


function hey_get_attachment_image_bgset( $attachment_id, $size = 'thumbnail', $attr = '' ) {

	$html  = '';
	$image = wp_get_attachment_image_src( $attachment_id, $size );

	if ( $image ) {

		$ext = pathinfo( $image[0], PATHINFO_EXTENSION );

		if ( $ext == 'svg' ) {

			$html = 'data-bgset="' . $image[0] . '"';

		} else {

			// lazyhide lazyload image-cover

			list( $src, $width, $height ) = $image;

			$attachment   = get_post( $attachment_id );
			$default_attr = array(
				'data-sizes' => 'auto',
				'data-bgset' => '',
			);

			$attr = wp_parse_args( $attr, $default_attr );

			if ( empty( $attr['data-bgset'] ) ) {
				$image_meta = get_post_meta( $attachment_id, '_wp_attachment_metadata', true );
				if ( is_array( $image_meta ) ) {
					$size_array = array( absint( $width ), absint( $height ) );
					$srcset     = wp_calculate_image_srcset( $size_array, $src, $image_meta, $attachment_id );
					if ( is_string( $srcset ) ) {
						$attr['data-bgset'] = $srcset;
					} else {
						$attr['data-bgset'] = $src;
					}
				}
			}

			$attr = array_map( 'esc_attr', $attr );
			$html = '';
			foreach ( $attr as $name => $value ) {
				$html .= " $name=" . '"' . $value . '"';
			}

		}

	}

	return $html;

}


/**
 * Wrap embeds
 */
function wrap_embed_with_div( $html, $url, $attr ) {
	$class = isset( $attr['class'] ) ? ' ' . $attr['class'] : '';

	return '<div class="embed-wrap aspect small-aspect-landscape' . $class . '"><div class="aspect-content">' . $html . '</div></div>';
}

add_filter( 'embed_oembed_html', 'wrap_embed_with_div', 10, 3 );


/*
Add image attributes
*/
function hey_filter_ptags( $content ) {

	$content = preg_replace( '/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content ); // Remove p tags around iframes
	$content = hey_add_attributes_to_images( $content );

	return $content;

}

add_filter( 'the_content', 'hey_filter_ptags' );


function hey_add_attributes_to_images( $content ) {

	if ( ! preg_match_all( '/<img [^>]+>/', $content, $matches ) ) {
		return $content;
	}

	$selected_images = $attachment_ids = array();
	foreach ( $matches[0] as $image ) {
		// false === strpos( $image, ' srcset=' ) && 
		if ( preg_match( '/wp-image-([0-9]+)/i', $image, $class_id ) &&
		     ( $attachment_id = absint( $class_id[1] ) ) ) {
			$selected_images[ $image ]        = $attachment_id;
			$attachment_ids[ $attachment_id ] = true;
		}
	}

	if ( count( $attachment_ids ) > 1 ) {
		update_meta_cache( 'post', array_keys( $attachment_ids ) );
	}

	foreach ( $selected_images as $image => $attachment_id ) {
		$image_meta = get_post_meta( $attachment_id, '_wp_attachment_metadata', true );
		$content    = str_replace( $image, hey_add_attributes_to_image( $image, $image_meta, $attachment_id ), $content );
	}

	return $content;

}

function hey_add_attributes_to_image( $image, $image_meta, $attachment_id ) {

	if ( isset( $image_meta['width'] ) && isset( $image_meta['height'] ) ) {

		$attr = '';
		// $med_size = 'large';

		// if (isset($image_meta['sizes'][$med_size])) {
		// 	$img = wp_get_attachment_image_src( $attachment_id, $med_size );
		// 	$attr .= 'data-med="'.$img[0].'" data-med-size="'.$img[1].'x'.$img[2].'" ';
		// }

		// make lazysizes compatible
		$image = str_replace( ' srcset="', ' data-srcset="', $image );
		$image = str_replace( ' class="', ' class="lazyhide lazyload ', $image );
		$image = preg_replace( '/(<[^>]+) sizes=".*?"/i', '$1', $image );
		$attr  .= 'data-sizes="auto" data-size="' . $image_meta['width'] . 'x' . $image_meta['height'] . '"';
		$image = preg_replace( '/<img ([^>]+?)[\/ ]*>/', '<img $1' . $attr . ' />', $image );
	}

	return $image;

}