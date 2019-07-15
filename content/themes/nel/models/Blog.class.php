<?php

class MUSTACHE_Blog {

	public $title;
	public $excerpt;
	public $posts = [];

	private $sticky_num = 3;
	private $sticky_post_ids = array();

	public function __construct() {

		$page            = get_post( get_option( 'page_for_posts' ) );
		$this->title     = apply_filters( 'the_title', $page->post_title );
		$this->excerpt   = apply_filters( 'the_excerpt', $page->post_excerpt );
		$this->permalink = get_permalink( $page->ID );

	}

	public function pagination() {

		global $wp_query;
		$big = 9999;

		return paginate_links( array(
			'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			'format'  => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total'   => $wp_query->max_num_pages
		) );

	}

	public function prepare_posts() {

		$posts = array();

		if ( have_posts() ) : while ( have_posts() ) : the_post();

			global $post;
			$featured_image = false;
			$bgset          = '';

			if ( has_post_thumbnail() ) {
				$thumb_id = get_post_thumbnail_id();
				$bgset    = hey_get_attachment_image_bgset( $thumb_id, 'full' );
			} else {
				$bgset = 'data-bgset="' . get_template_directory_uri() . '/images/space.png' . '"';
			}

			// Term string
			$terms = wp_get_post_terms( get_the_ID(), 'category' );
			if ( $terms ) {
				$term_links = array_map( function ( $item ) {
					return '<a href="' . get_term_link( $item ) . '">' . $item->name . '</a>';
				}, $terms );
				$term_links = implode( ', ', $term_links );
			} else {
				$term_links = '';
			}

			$posts[] = array(
				'term_links'     => $term_links,
				'featured_image' => array( 'atts' => $bgset ),
				'post_date_gmt'  => $post->post_date_gmt,
				'date'           => get_the_date(),
				'permalink'      => get_permalink(),
				'content'        => get_the_content(),
				'excerpt'        => get_the_excerpt(),
				'title'          => get_the_title(),
				'readmore'       => __( 'Read more', 'nel' )
			);

		endwhile; endif;

		return $posts;

	}

	public function get_term_nav() {

		// Get all category terms
		$terms = get_terms( array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
		) );

		// Gets the current term if we're on a taxonomy page
		$current_term = get_queried_object();

		// Home item - showing main archive page
		$item_all = array(
			'permalink' => $this->permalink,
			'name'      => __( 'All', 'nel' ),
			'current'   => false
		);

		// Check
		if ( isset( $current_term->term_id ) ) {
			$current_term_name = $current_term->name;
		} else {
			$current_term_name   = $item_all['name'];
			$item_all['current'] = true;
		}

		// Add term items
		$term_items = array( $item_all );

		foreach ( $terms as $term ) {
			$term_items[] = array(
				'name'      => $term->name,
				'permalink' => get_term_link( $term ),
				'current'   => ( isset( $current_term->term_id ) && $current_term->term_id == $term->term_id )
			);
		}

		return array(
			'select'       => __( 'Select', 'nel' ),
			'current_term' => $current_term_name,
			'items'        => $term_items,
			'has_terms'    => count( $terms )
		);

	}

	public function body() {

		$this->termNav = $this->get_term_nav();
		$this->posts   = $this->prepare_posts();

		return '{{> Blog }}';

	}

}