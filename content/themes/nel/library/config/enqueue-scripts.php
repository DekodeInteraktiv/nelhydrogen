<?php
/**
 * Enqueue all styles and scripts
 *
 * @package    WordPress
 * @subpackage Heydays
 * @since      Heydays 4.0
 */


/**
 *
 * Cache bust helper script
 *
 * @return array()
 */
function hey_cache_bust_script( $url ) {
	$filepath = TEMPLATEPATH . $url;
	if ( ! is_file( $filepath ) ) {
		$version = '0';
	} else {
		$version = filemtime( $filepath );
	}

	return array(
		'url'     => get_template_directory_uri() . $url,
		'version' => $version
	);
}

if ( ! function_exists( 'hey_enqueue_scripts' ) ) :

	function hey_enqueue_scripts() {

		// Remove default wp-embed script
		wp_deregister_script( 'wp-embed' );

		if ( ! is_admin() ) {
			wp_deregister_style( 'bodhi-svgs-attachment' );
		}

		// Enqueue the main Stylesheet.
		$style_main = hey_cache_bust_script( '/css/app.css' );
		wp_enqueue_style( 'main', $style_main['url'], false, $style_main['version'] );

		if ( ! is_admin() ) {
			// Deregister the jquery version bundled with WordPress.
			wp_deregister_script( 'jquery' );
			// CDN hosted jQuery placed in the header, as some plugins require that jQuery is loaded in the header.
			wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js', array(), '2.1.0' );
		}

		// "Load on demand"-scripts
		$scrollmagic = hey_cache_bust_script( '/js/min/scrollmagic-build-min.js' );
		$threejs     = hey_cache_bust_script( '/js/plugins/min/three-min.js' );
		$d3js        = hey_cache_bust_script( '/js/min/d3-build-min.js' );

		// Setup data passed to app
		$data = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'scripts'  => array(
				'threejs'     => $threejs['url'] . '?v=' . $threejs['version'],
				'scrollmagic' => $scrollmagic['url'] . '?v=' . $scrollmagic['version'],
				'd3'          => $d3js['url'] . '?v=' . $d3js['version'],
				'co2data'     => get_template_directory_uri() . '/assets/data/co2data.json',
			)
		);

		// Load app
		$app_script = hey_cache_bust_script( '/js/min/app-min.js' );
		wp_enqueue_script( 'app', $app_script['url'], array( 'jquery' ), $app_script['version'], true );
		wp_localize_script( 'app', 'data', $data );


	}

	add_action( 'wp_enqueue_scripts', 'hey_enqueue_scripts' );

endif;


function load_custom_wp_admin_style() {
	$admin_style = hey_cache_bust_script( '/css/admin-style.css' );
	wp_enqueue_style( 'custom-admin-style', $admin_style['url'], false, $admin_style['version'] );

	// custom ACF
	$admin_cript = hey_cache_bust_script( '/js/min/acf-min.js' );
	wp_enqueue_script( 'my-admin-js', $admin_cript['url'], array(), $admin_cript['version'], true );

}

add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );