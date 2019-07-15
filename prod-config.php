<?php
/*
This is a sample prod-config.php file
In it, you *must* include the four main database defines

You may include other settings here that you only want enabled on your prod development checkouts
*/

/*
 * Dev define
 *
 */
define( 'DEKODE_PROD_DEV', true );
define( 'DEKODE_ENVIRONMENT', 'prod' );


define ( 'VHP_VARNISH_IP', '134.213.152.207' );

define( 'WP_FAIL2BAN_PROXIES', VHP_VARNISH_IP . ',134.213.152.207,10.181.227.226,10.190.255.251' );

/*
 * Debug defines
 *
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SAVEQUERIES', false );
define( 'DISALLOW_FILE_EDIT', true );
define( 'GOOGLE_MAPS_API_KEY', 'AIzaSyBXliUZ6wwaqeq5sPRAs8dkNUD5D8xdibs' );

/*
 * Config details
 *
 * FTP/ssh define and Database info
 *
 */
if ( file_exists( dirname(dirname( __FILE__ )) . '/config.php' ) ) {
	/*
	 * Examples:
	 *
	 * See config.php for details
	 *
	 */
	include( dirname(dirname( __FILE__ )) . '/config.php' );
}
else {
	die('Missing config file');
}
