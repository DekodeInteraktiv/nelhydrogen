<?php
/*
Plugin Name: Admin Columns Pro
Version: 4.3.8
Description: Customize columns on the administration screens for post(types), users and other content. Filter and sort content, and edit posts directly from the posts overview. All via an intuitive, easy-to-use drag-and-drop interface.
Author: AdminColumns.com
Author URI: https://www.admincolumns.com
Plugin URI: https://www.admincolumns.com
Requires PHP: 5.3.6
Text Domain: codepress-admin-columns
Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_admin() ) {
	return;
}

define( 'ACP_FILE', __FILE__ );

/**
 * Deactivate Admin Columns
 */
require_once ABSPATH . 'wp-admin/includes/plugin.php';

deactivate_plugins( 'codepress-admin-columns/codepress-admin-columns.php' );

/**
 * Load integrated Admin Columns
 */
function acp_ac_init() {
	require_once 'admin-columns/codepress-admin-columns.php';
}

add_action( 'plugins_loaded', 'acp_ac_init' );

/**
 * Load Admin Columns Pro
 */
function acp_init() {
	$dependencies = new AC_Dependencies( plugin_basename( ACP_FILE ) );
	$dependencies->check_php_version( '5.3' );

	if ( $dependencies->has_missing() ) {
		return;
	}

	require_once 'bootstrap.php';
}

add_action( 'after_setup_theme', 'acp_init', 5 );

/**
 * Force an addon to adhere to a certain version of Admin Columns Pro
 *
 * @param string $version
 * @param string $basename
 *
 * @return string
 */
function acp_dependencies_version_gte( $version, $basename ) {
	$versions = array(
		'ac-addon-acf/ac-addon-acf.php'                         => '4.3',
		'ac-addon-buddypress/ac-addon-buddypress.php'           => '4.3',
		'ac-addon-events-calendar/ac-addon-events-calendar.php' => '4.3',
		'ac-addon-ninjaforms/ac-addon-ninjaforms.php'           => '4.3',
		'ac-addon-pods/ac-addon-pods.php'                       => '4.3',
		'ac-addon-types/ac-addon-types.php'                     => '4.3',
		'ac-addon-woocommerce/ac-addon-woocommerce.php'         => '4.3',
	);

	// Deprecated basenames since 4.2
	$versions['cac-addon-acf/cac-addon-acf.php'] = $versions['ac-addon-acf/ac-addon-acf.php'];
	$versions['cac-addon-woocommerce/cac-addon-woocommerce.php'] = $versions['ac-addon-woocommerce/ac-addon-woocommerce.php'];

	if ( isset( $versions[ $basename ] ) && -1 === version_compare( $version, $versions[ $basename ] ) ) {
		$version = $versions[ $basename ];
	}

	return $version;
}

add_filter( 'ac/dependencies/acp_version_gte', 'acp_dependencies_version_gte', 10, 2 );