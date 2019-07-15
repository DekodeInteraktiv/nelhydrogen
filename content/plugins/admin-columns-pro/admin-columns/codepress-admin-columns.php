<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_admin() ) {
	return;
}

define( 'AC_FILE', __FILE__ );

require_once 'classes/Dependencies.php';

function ac_init() {
	$dependencies = new AC_Dependencies( plugin_basename( AC_FILE ) );
	$dependencies->check_php_version( '5.3' );

	if ( $dependencies->has_missing() ) {
		return;
	}

	require_once __DIR__ . '/bootstrap.php';
}

add_action( 'after_setup_theme', 'ac_init', 1 );
