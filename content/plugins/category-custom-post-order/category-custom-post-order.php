<?php
/**
 * Plugin Name: Posts Order
 * Version: 1.4.4
 * Plugin URI: http://potrebka.pl/
 * Description: Order posts separately for each taxonomy
 * Author: Piotr Potrebka
 * Author URI:  http://potrebka.pl/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
*/

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Instantiate the main Posts Order class
 *
 * @since 0.1.0
 */
function _posts_order() {

	// Setup the main file
	$file = __FILE__;

	// Locad localization file
	load_plugin_textdomain( 'cps', false, basename( dirname( $file ) ) . '/languages' );
	
	// Include the main class
	include dirname( $file ) . '/includes/admin_settings.php';
	include dirname( $file ) . '/includes/posts_order.php';
	
	// Instantiate settings
	if( is_admin() ) new Post_Order_Settings();
	// Instantiate the main class
	new Posts_Order( $file );
}
add_action( 'init', '_posts_order', 99 );
