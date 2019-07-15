<?php

class MUSTACHE_NextPost {

	public function __construct() {

		$_post = get_previous_post();

		// If no next post get first post to create a loop
		if ( empty( $_post ) ) {

			$_posts = get_posts( array(
					'posts_per_page' => 1,
					'orderby'        => 'date',
					'order'          => 'DESC'
				)
			);

			if ( ! empty( $_posts ) ) {
				$_post = $_posts[0];
			}

		}

		// 
		$featured_image = false;
		$bgset          = false;
		if ( has_post_thumbnail( $_post ) ) {
			$thumb_id = get_post_thumbnail_id( $_post );
			$bgset    = hey_get_attachment_image_bgset( $thumb_id, 'full' );
		}

		// Set output data
		$this->label          = __( 'Read next', 'nel' );
		$this->title          = get_the_title( $_post );
		$this->permalink      = get_permalink( $_post );
		$this->excerpt        = get_the_excerpt( $_post );
		$this->featured_image = array( 'atts' => $bgset );

	}

}