<?php
/**
 * Register post types
 *
 * @package    WordPress
 * @subpackage Heydays
 * @since      Heydays 4.0
 */


function hey_register_taxonomy( $post_type, $tax_singular, $tax_plural, $tax_name, $tax_slug, $public = true, $metabox = true, $hierarchical = true ) {

	$tax_labels = array(
		'name'              => $tax_plural,
		'singular_name'     => $tax_singular,
		'search_items'      => __( 'Search categories', 'nel' ),
		'all_items'         => $tax_plural,
		'parent_item'       => $tax_singular,
		'parent_item_colon' => __( 'Parent category:', 'nel' ),
		'edit_item'         => __( 'Edit category', 'nel' ),
		'update_item'       => __( 'Update category', 'nel' ),
		'add_new_item'      => __( 'Add new category', 'nel' ),
		'new_item_name'     => __( 'New category name', 'nel' ),
		'menu_name'         => $tax_plural
	);

	register_taxonomy( $tax_name, $post_type,
		array(
			'public'            => $public,
			'hierarchical'      => $hierarchical,
			'label'             => $tax_singular,
			'show_ui'           => true,
			'query_var'         => true,
			'show_admin_column' => true,
			'labels'            => $tax_labels,
			'rewrite'           => array( 'slug' => $tax_slug ),
		)
	);

}


if ( ! function_exists( 'hey_register_custom_post_types' ) ) :
	function hey_register_custom_post_types() {

		register_post_type( 'product', array(
			'menu_position'       => 5,
			'label'               => __( 'Products', 'nel' ),
			'description'         => '',
			'menu_icon'           => 'dashicons-star-filled',
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'rewrite'             => array( 'slug' => 'product', 'with_front' => true ),
			'query_var'           => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
			'labels'              => array(
				'name'          => __( 'Products', 'nel' ),
				'singular_name' => __( 'Product', 'nel' ),
				'menu_name'     => __( 'Products', 'nel' )
			)
		) );

		// Product features
		hey_register_taxonomy( array( 'product' ), __( 'Feature', 'nel' ), __( 'Features', 'nel' ), 'product_feature', _x( 'feature', 'URL slug', 'nel' ), false, false, false );

		// register taxonomy
		$tax_singular = __( 'Category', 'nel' );
		$tax_plural   = __( 'Categories', 'nel' );
		$tax_name     = 'product_category';
		$tax_slug     = _x( 'product-category', 'URL slug', 'nel' );
		hey_register_taxonomy( array( 'product' ), $tax_singular, $tax_plural, $tax_name, $tax_slug );

		// Markets
		$tax_singular = __( 'Market', 'nel' );
		$tax_plural   = __( 'Markets', 'nel' );
		$tax_name     = 'market';
		$tax_slug     = _x( 'market', 'URL slug', 'nel' );
		hey_register_taxonomy( array( 'product' ), $tax_singular, $tax_plural, $tax_name, $tax_slug );


		register_post_type( 'person', array(
			'menu_position'       => 5,
			'label'               => __( 'People', 'nel' ),
			'description'         => '',
			'menu_icon'           => 'dashicons-id',
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'hierarchical'        => false,
			//'rewrite' => array('slug' => 'people', 'with_front' => true),
			'query_var'           => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'labels'              => array(
				'name'          => __( 'People', 'nel' ),
				'singular_name' => __( 'Person', 'nel' ),
				'menu_name'     => __( 'People', 'nel' )
			)
		) );


		// register taxonomy
		$tax_singular = __( 'Category', 'nel' );
		$tax_plural   = __( 'Categories', 'nel' );
		$tax_name     = 'person_category';
		$tax_slug     = _x( 'department', 'URL slug', 'nel' );
		hey_register_taxonomy( array( 'person' ), $tax_singular, $tax_plural, $tax_name, $tax_slug, true );


		register_post_type( 'cision_post', array(
			//'menu_position' => 5,
			'label'               => __( 'Cision', 'nel' ),
			'description'         => '',
			'menu_icon'           => 'dashicons-download',
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'capabilities'        => array(
				'edit_post'          => 'edit_cision_post',
				'read_post'          => 'read_cision_post',
				'delete_post'        => 'delete_cision_post',
				'edit_posts'         => 'edit_cision_posts',
				'edit_others_posts'  => 'edit_others_cision_posts',
				'publish_posts'      => 'publish_cision_posts',
				'read_private_posts' => 'read_private_cision_posts',
				'create_posts'       => 'edit_cision_posts',
			),
			'map_meta_cap'        => true,
			'hierarchical'        => false,
			'rewrite'             => array( 'slug' => 'press-release', 'with_front' => true ),
			'query_var'           => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'supports'            => array( 'title', 'editor', 'excerpt' ),
			'labels'              => array(
				'name'          => __( 'Posts', 'nel' ),
				'singular_name' => __( 'Post', 'nel' ),
				'menu_name'     => __( 'Cision posts', 'nel' )
			)
		) );

		$tax_singular = __( 'Category', 'nel' );
		$tax_plural   = __( 'Categories', 'nel' );
		$tax_name     = 'cision_category';
		$tax_slug     = _x( 'cision-category', 'URL slug', 'nel' );
		hey_register_taxonomy( array( 'cision_post' ), $tax_singular, $tax_plural, $tax_name, $tax_slug, true );


		// register_post_type('document', array(
		// 	//'menu_position' => 5,
		// 	'label' => __('Documents', 'nel'),
		// 	'description' => '',
		// 	'menu_icon' => 'dashicons-chart-pie',
		// 	'public' => true,
		// 	'show_ui' => true,
		// 	'show_in_menu' => true,
		// 	'capabilities' => array(
		// 		'edit_post'          => 'edit_cision_post',
		// 		'read_post'          => 'read_cision_post',
		// 		'delete_post'        => 'delete_cision_post',
		// 		'edit_posts'         => 'edit_cision_posts',
		// 		'edit_others_posts'  => 'edit_others_cision_posts',
		// 		'publish_posts'      => 'publish_cision_posts',
		// 		'read_private_posts' => 'read_private_cision_posts',
		// 		'create_posts'       => 'edit_cision_posts',
		// 	),
		// 	'map_meta_cap' => true,
		// 	'hierarchical' => false,
		// 	'query_var' => true,
		// 	'has_archive' => false,
		// 	'exclude_from_search' => false,
		// 	'supports' => array('title'),
		// 	'labels' => array (
		// 		'name' => __('Documents', 'nel'),
		// 		'singular_name' => __('Document', 'nel'),
		// 		'menu_name' => __('Documents & reports', 'nel')
		// 	)
		// ) );


	}

	add_action( 'init', 'hey_register_custom_post_types' );
endif;