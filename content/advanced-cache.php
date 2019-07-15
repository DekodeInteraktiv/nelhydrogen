<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

define( 'WP_ROCKET_ADVANCED_CACHE', true );
$rocket_cache_path = '/home/rasmus/www/wordpress/nelhydrogen/content/cache/wp-rocket/';
$rocket_config_path = '/home/rasmus/www/wordpress/nelhydrogen/content/wp-rocket-config/';

if ( file_exists( '/home/rasmus/www/wordpress/nelhydrogen/content/plugins/wp-rocket/inc/front/process.php' ) ) {
	include( '/home/rasmus/www/wordpress/nelhydrogen/content/plugins/wp-rocket/inc/front/process.php' );
} else {
	define( 'WP_ROCKET_ADVANCED_CACHE_PROBLEM', true );
}