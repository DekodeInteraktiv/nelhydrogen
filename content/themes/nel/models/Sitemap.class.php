<?php

class MUSTACHE_Sitemap {

	public $title;
	public $post_types_exclude = array( 'attachment', 'cision_post' );
	public $tax_exclude = array( 'post_tag', 'post_format', 'media_category', 'cision_category' );
	public $debug;

	public function __construct() {

		$this->title          = get_the_title();
		$this->special_pages  = $this->set_special_pages();
		$this->post_hierarchy = $this->get_posts();
		$this->taxonomies     = $this->get_taxonomies();

		if ( is_user_logged_in() ) {
			$this->wpml = array(
				'docs' => array(
					'taxonomy_translation' => array(
						'url'   => 'https://wpml.org/documentation/getting-started-guide/translating-post-categories-and-custom-taxonomies/',
						'title' => 'Translation instructions'
					),
					'post_translation'     => array(
						'url'   => 'https://wpml.org/documentation/getting-started-guide/#how-to-translate-pages-posts-and-custom-posts',
						'title' => 'Translation instructions'
					)
				)
			);
		}

	}

	public function set_special_pages() {

		$special_pages                                               = array();
		$special_pages[ get_option( 'wp_page_for_privacy_policy' ) ] = __( 'Privacy Policy Page', 'nel' );
		$special_pages[ get_option( 'page_for_posts' ) ]             = __( 'Posts Page', 'nel' );
		$special_pages[ get_option( 'page_on_front' ) ]              = __( 'Front Page', 'nel' );

		return $special_pages;

	}

	public function get_post_types() {

		/**
		 * Get all post types
		 */
		$post_types = get_post_types( array(
			'public' => true,
		), 'objects' );

		/**
		 * Remove the ones we don't want
		 */
		foreach ( $post_types as $key => $post_type ) {
			if ( in_array( $key, $this->post_types_exclude ) ) {
				unset( $post_types[ $key ] );
			}
		}

		return $post_types;

	}

	public function get_taxonomies() {

		$taxonomies = get_taxonomies( array(
			'public' => true
		), 'objects' );

		foreach ( $this->tax_exclude as $tax ) {
			if ( isset( $taxonomies[ $tax ] ) ) {
				unset( $taxonomies[ $tax ] );
			}
		}

		$terms = get_terms( array_keys( $taxonomies ), array(
			'hide_empty' => false
		) );

		$tax_hierarchy = array();
		foreach ( $terms as $key => $term ) {

			// Create collectior for the current taxonomy
			if ( ! isset( $tax_hierarchy[ $term->taxonomy ] ) ) {
				$tax_hierarchy[ $term->taxonomy ] = array(
					'type'  => $taxonomies[ $term->taxonomy ]->label . ' (' . implode( ', ', $taxonomies[ $term->taxonomy ]->object_type ) . ')',
					'terms' => array()
				);
			}

			// Prepare the term
			$term->permalink = get_term_link( $term );

			// Add post to array
			$tax_hierarchy[ $term->taxonomy ]['terms'][] = $term;

		}

		// Order terms individually
		foreach ( $tax_hierarchy as $key => $type ) {

			// Sort by internal menu order
			usort( $tax_hierarchy[ $key ]['terms'], function ( $a, $b ) {
				return $a->term_order - $b->term_order;
			} );

			// Build tree structure
			$tax_hierarchy[ $key ]['terms'] = $this->build_term_tree( $tax_hierarchy[ $key ]['terms'] );

		}

		return array_values( $tax_hierarchy );

	}

	public function build_tree( &$posts, $pid = 0 ) {
		$branch = array();
		foreach ( $posts as $key => &$post ) {
			if ( $post->post_parent == $pid ) {
				$children = $this->build_tree( $posts, $post->ID );
				if ( $children ) {
					$post->has_children = true;
					$post->children     = $children;
				} else {
					$post->has_children = false;
				}
				$branch[] = $post;
				unset( $post );
			}
		}

		return $branch;
	}

	public function build_term_tree( &$terms, $pid = 0 ) {
		$branch = array();
		foreach ( $terms as $key => &$term ) {
			if ( $term->parent == $pid ) {
				$children = $this->build_term_tree( $terms, $term->term_id );
				if ( $children ) {
					$term->has_children = true;
					$term->children     = $children;
				} else {
					$term->has_children = false;
				}
				$branch[] = $term;
				unset( $term );
			}
		}

		return $branch;
	}

	public function get_posts() {

		$post_types = $this->get_post_types();

		/**
		 * Get all posts
		 */
		$args  = array(
			'post_type'      => array_keys( $post_types ),
			'posts_per_page' => - 1,
			'order_by'       => 'menu_order',
			'order'          => 'ASC',
		);
		$posts = get_posts( $args );

		/**
		 * Order posts by type
		 */
		$post_hierarchy   = array();
		$current_language = apply_filters( 'wpml_current_language', null );
		$logged_in        = current_user_can( 'edit_posts' );

		foreach ( $posts as $key => $post ) {

			if ( ! isset( $post_hierarchy[ $post->post_type ] ) ) {
				$post_hierarchy[ $post->post_type ] = array(
					'type'  => $post_types[ $post->post_type ]->label,
					'posts' => array()
				);
			}

			// Prepare the post
			$post->permalink = get_permalink( $post );
			if ( isset( $this->special_pages[ $post->ID ] ) ) {
				$post->special_label = $this->special_pages[ $post->ID ];
			}

			$post->translations     = array();
			$post->has_translations = false;

			// Add translations
			if ( $logged_in ) {

				$element_type = 'post_' . $post->post_type;
				$trid         = apply_filters( 'wpml_element_trid', null, $post->ID, $element_type );
				$translations = apply_filters( 'wpml_get_element_translations', null, $trid );

				if ( $translations ) {

					// Remove current language from translations array
					if ( isset( $translations[ $current_language ] ) ) {
						unset( $translations[ $current_language ] );
					}

					// Add permalink to each translation
					foreach ( $translations as $code => $translation ) {

						$post->translations[] = array(
							'title'     => $translation->post_title,
							'lang'      => $code,
							'permalink' => apply_filters( 'wpml_permalink', get_permalink( $translation->element_id ), $code )
						);

						$post->has_translations = true;

					}

				}

			}

			// Add post to array
			$post_hierarchy[ $post->post_type ]['posts'][] = $post;

		}

		// Order posts individually
		foreach ( $post_hierarchy as $key => $type ) {

			// Sort by internal menu order
			usort( $post_hierarchy[ $key ]['posts'], function ( $a, $b ) {
				return $a->menu_order - $b->menu_order;
			} );

			// Build tree structure
			$post_hierarchy[ $key ]['posts'] = $this->build_tree( $post_hierarchy[ $key ]['posts'] );

		}

		// Order post type output
		$post_type_order = array( 'page', 'post', 'product', 'person' );
		$type_has_posts  = array_keys( $post_hierarchy );
		foreach ( $post_type_order as $key => $type ) {
			if ( ! in_array( $type, $type_has_posts ) ) {
				unset( $post_type_order[ $key ] );
			}
		}
		// write_log($post_type_order);

		$post_hierarchy = array_merge( array_flip( $post_type_order ), $post_hierarchy );

		// $this->debug = print_r($post_hierarchy, TRUE);


		/**
		 * Unset the keys to make it itearate in Mustache
		 */

		return array_values( $post_hierarchy );

	}

	public function excerpt() {

		return get_the_excerpt();

	}

	public function body() {

		/**
		 * Return a partial
		 */
		return '{{> Sitemap }}';

	}

}