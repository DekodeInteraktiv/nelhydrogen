<?php
/*
This is a sample local-config.php file
In it, you *must* include the four main database defines

You may include other settings here that you only want enabled on your local development checkouts
*/

/*
 * Database defines
 *
 */
define( 'DB_NAME', '' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'localhost' ); // Probably 'localhost'

/*
 * Dev define
 *
 */
define( 'WP_LOCAL_DEV', true );
define( 'DEKODE_LOCAL_DEV', true );
define( 'DEKODE_ENVIRONMENT', 'local' );
define( 'DEKODE_PREPEND_IMAGE_URL', '' );

/*
 * Debug defines
 *
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'SAVEQUERIES', true );

/*
 * Path & URL defines
 *
 */
define( 'DEKODE_SWITCH_URL', true );
define( 'DEKODE_LOCAL_HOME', 'domain.site' );
define( 'DEKODE_PUBLIC_HOME', 'domain.stage.dekodes.no' );

/*
 * Multisite
 *
 *//*
define( 'SUNRISE', 'on' );
define( 'DOMAIN_CURRENT_SITE', '.site' );
*/

/*
 * Options
 *
 */
define( 'DEKODE_DISABLE_FEEDS', true );
