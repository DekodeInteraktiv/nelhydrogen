<?php

define( 'ICL_DONT_LOAD_NAVIGATION_CSS', true );
define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );
define( 'ICL_DONT_LOAD_LANGUAGES_JS', true );

// Hide translations metabox
function disable_icl_metabox() {
	$screen = get_current_screen();
	remove_meta_box( 'icl_div_config', $screen->post_type, 'normal' );
}

// Remove generator meta tag
global $sitepress;
if ( $sitepress ) {
	remove_action( 'wp_head', array( $sitepress, 'meta_generator_tag' ) );
	add_filter( 'wpml_custom_field_original_data', '__return_null' );
	add_action( 'admin_head', 'disable_icl_metabox', 99 );
}

