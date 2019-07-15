<?php
/*
This is a sample stage-config.php file
In it, you *must* include the four main database defines

You may include other settings here that you only want enabled on your stage development checkouts
*/

/*
 * Database defines
 *
 */
function dekode_get_conf_var( $v ) { return ( array_key_exists( $v, $_SERVER ) ? $_SERVER[ $v ] : '' ); }
define( 'DB_NAME', dekode_get_conf_var( 'DB_NAME' ) );
define( 'DB_USER', dekode_get_conf_var( 'DB_USER' ) );
define( 'DB_PASSWORD', dekode_get_conf_var( 'DB_PASS' ) );
define( 'DB_HOST', dekode_get_conf_var( 'DB_HOST' ) );

/*
 * Dev define
 *
 */
define( 'WP_STAGE_DEV', true );
define( 'DEKODE_STAGE_DEV', true );
define( 'DEKODE_ENVIRONMENT', 'stage' );

/*
 * Debug defines
 *
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SAVEQUERIES', false );
define( 'DEKODE_PREPEND_IMAGE_URL', 'https://koro.no/' );
define( 'DEKODE_PREPEND_LOCAL_LOOKUP', true );
/*
 * Path & URL defines
 * @TODO Fix this. Images needs to be pulled from production
 *//*
define( 'DEKODE_SWITCH_URL', false );
define( 'DEKODE_LOCAL_HOME', '.stage.dekodes.no' );
define( 'DEKODE_PUBLIC_HOME', '.dekodes.no' );
*/

/*
 * FTP/ssh define
 *
 */
define( 'FTP_BASE', dirname( __FILE__ ) . '/wp' );
define( 'FTP_PLUGIN_DIR', dirname( __FILE__ ) . '/content/plugins' );
define( 'FTP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'FTP_PUBKEY', '/home/content/.ssh/id_rsa.pub' );
define( 'FTP_PRIKEY', '/home/content/.ssh/id_rsa' );
define( 'FTP_USER', 'content' );
define( 'FTP_PASS', '' );
define( 'FTP_HOST', 'stage.dekodes.no' );
