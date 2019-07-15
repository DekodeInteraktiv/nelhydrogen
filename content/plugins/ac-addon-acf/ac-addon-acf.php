<?php
/*
Plugin Name: 		Admin Columns Pro - Advanced Custom Fields (ACF)
Version: 			2.3.2
Description: 		Supercharges Admin Columns Pro with very cool ACF columns.
Author: 			Admin Columns
Author URI: 		https://www.admincolumns.com
Plugin URI: 		https://www.admincolumns.com
Text Domain: 		codepress-admin-columns
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_admin() ) {
	return;
}

define( 'ACA_ACF_FILE', __FILE__ );

require_once 'classes/Dependencies.php';

function aca_acf_init() {
	$dependencies = new ACA_ACF_Dependencies( plugin_basename( __FILE__ ) );
	$dependencies->check_acp( '4.3' );

	if ( ! class_exists( 'acf', false ) ) {
		$dependencies->add_missing_plugin( __( 'Advanced Custom Fields' ), $dependencies->get_search_url( 'Advanced Custom Fields' ) );
	}

	if ( $dependencies->has_missing() ) {
		return;
	}

	require_once 'bootstrap.php';
}

add_action( 'after_setup_theme', 'aca_acf_init' );