<?php
/**
 * Remove unnecessary WordPress clutter
 *
 * @package    WordPress
 * @subpackage Heydays
 * @since      Heydays 4.0
 */

if ( ! function_exists( 'hey_start_cleanup' ) ) :
	function hey_start_cleanup() {

		// Launching operation cleanup.
		add_action( 'init', 'hey_cleanup_head' );

		// Clean up gallery output in wp.
		add_filter( 'hey_gallery_style', 'hey_gallery_style' );

		// Additional post related cleaning.
		add_filter( 'get_image_tag', 'hey_image_editor', 0, 4 );
		add_filter( 'the_content', 'img_unautop', 30 );
		add_action( 'wp_print_styles', 'hey_dequeue_styles', 100 );

	}

	add_action( 'after_setup_theme', 'hey_start_cleanup' );
endif;

function hey_dequeue_styles() {
	wp_dequeue_style( 'ihotspot' );
	wp_deregister_script( 'wp-mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );
}


if ( ! function_exists( 'hey_cleanup_head' ) ) :
	function hey_cleanup_head() {

		// EditURI link.
		remove_action( 'wp_head', 'rsd_link' );

		// Category feed links.
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		// Post and comment feed links.
		remove_action( 'wp_head', 'feed_links', 2 );

		// Windows Live Writer.
		remove_action( 'wp_head', 'wlwmanifest_link' );

		// Index link.
		remove_action( 'wp_head', 'index_rel_link' );

		// Previous link.
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

		// Start link.
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

		// Canonical.
		remove_action( 'wp_head', 'rel_canonical', 10, 0 );

		// Shortlink.
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

		// Links for adjacent posts.
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

		// WP version.
		remove_action( 'wp_head', 'wp_generator' );

		// Oembed discovery links
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

		// Emoji detection script.
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		// Emoji styles.
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		// Remove api-url from header
		remove_action( 'wp_head', 'rest_output_link_wp_head' );

	}
endif;

function nel_remove_hotspot_scripts() {
	// Don't load image hotspot scripts unless they are needed
	global $post;
	if ( ! isset( $post ) || ! $post || $post->post_type != 'product' ) {
		remove_action( 'wp_enqueue_scripts', 'devvn_ihotspot_frontend_scripts' );
	}
}

add_action( 'wp', 'nel_remove_hotspot_scripts' );

// Remove width and height in editor, for a better responsive world.
if ( ! function_exists( 'hey_image_editor' ) ) :
	function hey_image_editor( $html, $id, $alt, $title ) {
		return preg_replace( array(
			'/\s+width="\d+"/i',
			'/\s+height="\d+"/i',
			'/alt=""/i',
		),
			array(
				'',
				'',
				'',
				'alt="' . $title . '"',
			),
			$html );
	}
endif;


// Remove injected CSS from gallery.
if ( ! function_exists( 'hey_gallery_style' ) ) :
	function hey_gallery_style( $css ) {
		return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
	}
endif;


// Wrap images with figure tag - Credit: Robert O'Rourke - http://bit.ly/1q0WHFs .
if ( ! function_exists( 'img_unauto' ) ) :
	function img_unautop( $pee ) {
		$pee = preg_replace( '/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee );

		return $pee;
	}
endif;


// Remove empty paragraphs inside shortcodes
function shortcode_empty_paragraph_fix( $content ) {
	$array = array(
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']'
	);

	return strtr( $content, $array );
}

add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );


// remove HTML4 attributes from iframe embeds
function oembed_remove_atts_filter( $return, $data, $url ) {
	$return = str_replace( 'frameborder="0" allowfullscreen', 'style="border: none"', $return );

	return $return;
}

add_filter( 'oembed_dataparse', 'oembed_remove_atts_filter', 90, 3 );


// Change api-url from wp-json
function hey_api_prefix( $prefix ) {
	return 'api'; // http://mysite.com/api/
}

add_filter( 'rest_url_prefix', 'hey_api_prefix', 90, 1 );


function hey_hide_taxonomy_order_banner() {
	?>
    <style>#cpt_info_box {
            display: none !important;
        }</style><?php
}

add_action( 'admin_head', 'hey_hide_taxonomy_order_banner' );


function cision_feed_content_cleanup( $content ) {

	if ( get_post_type() == 'cision_post' ) {
		$content_array = explode( 'ENDS', $content );
		if ( isset( $content_array[1] ) ) {
			$content = $content_array[0];
		}
	}

	return $content;
}

add_filter( 'the_content', 'cision_feed_content_cleanup' );