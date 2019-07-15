<?php

class MUSTACHE_Post {

	public function __construct() {

		$this->title = get_the_title();
		$this->intro = get_the_excerpt();

		// if ( has_post_thumbnail() ) {
		//   if (get_field('featured_image', $acf_id)) {
		//     $image_id = get_post_thumbnail_id();
		//   }
		// }

	}

	/**
	 * THIS IS WORK IN PROGRESS!!
	 */
	public function blocks() {

		global $mustache;
		$output = '';
		$blocks = get_field( 'blocks' );

		if ( empty( $blocks ) ) {
			return false;
		}

		global $block_count;
		$block_count = 0;
		$blocks      = get_field( 'blocks' );

		while ( have_rows( 'blocks' ) ) : the_row();

			$block = $blocks[ $block_count ];

			// Check block visibility status
			$status = isset( $block['status'] ) ? $block['status'] : false;
			if ( $status == 'hidden' ) {
				continue;
			} elseif ( $status == 'private' && ! current_user_can( 'edit_posts' ) ) {
				continue;
			}

			if ( $block['acf_fc_layout'] == 'wysiwyg' ) {

				// Render selected block
				if ( $block['image_background'] && $block['image'] ) {
					$block['bgset'] = hey_get_attachment_image_bgset( $block['image'], 'full' );
				}

				$row_classes     = array();
				$section_classes = array();
				$column_classes  = array( 'columns content-column' );

				if ( $block['wysiwyg_layout'] == 'center' ) {
					$column_classes[] = 'small-12 large-10 xlarge-8';
				}

				if ( $block['text_align'] == 'center' ) {
					$column_classes[] = 'medium-text-center';
				}

				if ( $block['container_aspect_ratio'] ) {
					$section_classes[]     = 'aspect small-aspect-' . $block['container_aspect_ratio'];
					$block['aspect_inner'] = 'container aspect-content';
					$row_classes[]         = 'align-middle full-height';
				}

				if ( $block['background_color'] ) {
					$section_classes[] = 'bg-' . $block['background_color'];
				} elseif ( $block_count == 0 || $block['hairline_above'] ) {
					$block['section_divider'] = true;
				}

				$block['slug'] = sanitize_title( $block['title'] );

				$block['row_classes']     = implode( ' ', $row_classes );
				$block['column_classes']  = implode( ' ', $column_classes );
				$block['section_classes'] = implode( ' ', $section_classes );

				// Add debug info
				if ( is_user_logged_in() ) {
					$block['debug'] = print_r( $block, true );
				}

				$output .= $mustache->render( 'partials/Block' . ucfirst( $block['acf_fc_layout'] ), $block );


			} else {

				ob_start();
				get_template_part( 'partials/block', get_row_layout() );
				$output .= ob_get_contents();
				ob_end_clean();

			}

			$block_count ++;

		endwhile;

		return $output;

	}

	public function header_meta() {

		$terms = wp_get_post_terms( get_the_ID(), 'category' );
		if ( $terms ) {
			$term_links  = array_map( function ( $item ) {
				return '<a href="' . get_term_link( $item ) . '">' . $item->name . '</a>';
			}, $terms );
			$term_links  = implode( ', ', $term_links );
			$meta_string = sprintf( __( 'Published %s in %s', 'nel' ), get_the_date(), $term_links );
		} else {
			$meta_string = sprintf( __( 'Published %s', 'nel' ), get_the_date() );
		}

		return $meta_string;

	}

	public function next_post() {

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
		return array(
			'label'          => __( 'Read next', 'nel' ),
			'title'          => get_the_title( $_post ),
			'permalink'      => get_permalink( $_post ),
			'excerpt'        => get_the_excerpt( $_post ),
			'featured_image' => array( 'atts' => $bgset ),
		);

	}

}