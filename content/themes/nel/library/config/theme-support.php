<?php
/**
 * Add theme support
 *
 * @package    WordPress
 * @subpackage Heydays
 * @since      Heydays 4.0
 */

/**
 * Disable the Gutenberg editor
 */
add_filter( 'use_block_editor_for_post', '__return_false' );

add_action( 'after_setup_theme', 'hey_add_theme_support' );

function hey_add_theme_support() {

	// Theme translation
	load_theme_textdomain( 'nel', get_template_directory() . '/languages' );

	// Enable post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Enable HTML5 features
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	) );

	// Enable title tag
	add_theme_support( 'title-tag' );

	// Enable post formats (aside, gallery, link, image, ...)
	add_theme_support( 'post-formats', array() );

	// make sure yoast breadcrumbs are rendered
	add_theme_support( 'yoast-seo-breadcrumbs' );

	// add excerpts to pages
	add_post_type_support( 'page', 'excerpt' );

}


function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'cc_mime_types' );