<?php
define('WP_CACHE', true); // Added by WP Rocket

/*
 * Set the correct defines based on environment
 *
 */
if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
	include( dirname( __FILE__ ) . '/local-config.php' );
}
elseif ( ( strpos( $_SERVER['HTTP_HOST'], 'stage' ) !== false ) || ( strpos( $_SERVER['HTTP_HOST'], '.dev03.' ) !== false ) ) {
	if ( file_exists( dirname( __FILE__ ) . '/stage-config.php' ) )
		include( dirname( __FILE__ ) . '/stage-config.php' );
	else
		die('Missing stage config file.');
}
else {
	if ( file_exists( dirname( __FILE__ ) . '/prod-config.php' ) )
		include( dirname( __FILE__ ) . '/prod-config.php' );
	else
		die('Missing prod config file.');
}

/*
 * Set the custom content directory
 *
 */
$scheme = defined( 'DEKODE_SCHEME' ) ? DEKODE_SCHEME : 'http';
if ( 'on' == strtolower( $_SERVER['HTTPS'] ) || $_SERVER['SERVER_PORT'] == '443' || ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) ) {
	$scheme = 'https';
	$_SERVER['HTTPS'] = 'on';
}

define( 'WP_CONTENT_DIR', __DIR__ . '/content' );
define( 'WP_CONTENT_URL', $scheme . '://' . $_SERVER['HTTP_HOST'] .'/content' );

if ( ! defined( 'WP_SITEURL' ) ) {
	define( 'WP_SITEURL', $scheme . '://' . $_SERVER['HTTP_HOST'] .'/wp' );
}

if ( ! defined( 'WP_HOME' ) ) {
	define( 'WP_HOME', $scheme . '://' . $_SERVER['HTTP_HOST'] );
}


/*
 * You almost certainly do not want to change these
 *
 */
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

/*
 * Salts, for security
 * Grab these from: https://api.wordpress.org/secret-key/1.1/salt
 * Must be unqiue on every project
 *
 */
define('AUTH_KEY',         'NMt5,|wr3_fya)l~$2@Dq}PtJfSd}Dx!N289*$=uJ+-;hIl2[szjolYtDxb.V>;8');
define('SECURE_AUTH_KEY',  'J&z_`v8i(%2->|b_xwwvKAQU$k3!C|M{,=NPkjv8 (XI$zy1oAa+6[;1}^-Dfzn,');
define('LOGGED_IN_KEY',    't<4aWVAUMUJFLS+mI%tyPOT#+/h/F-TiWFan~rqj+|U[#}*Y@OGqNVzjWLl%1Z+,');
define('NONCE_KEY',        ',ry>)_0|XJap0oYm~p2CcJFp-XVJuCvcwNI}z&n:zZ/8sChS$H5L5)ZF:D+=:@,>');
define('AUTH_SALT',        ' ^Dui#K+if|O{4]Pz4f$a@! V%!M#HEV*Y@k--jf~+;f]IS-<y4ilnd|OPT#Am)W');
define('SECURE_AUTH_SALT', '&TUB!h+e^zQ5P+quSGY8Ty:BZi-}-!Egh3A7]eZ3Y^P+=j E GBX&+#|.P}f~EL<');
define('LOGGED_IN_SALT',   '^Xas0($aJO3%] {Hoe$&y?6JiIk;l8HgJ.Z]BT&b2-%2(~V(~5Y8TQ45gxKE.:A0');
define('NONCE_SALT',       '!b+G0waaWTF}8<-rp1I8$({bQKjoBW|G~cx+bxb?Eg27N|:6t%E^1#o|W-BNL?a}');

/*
 * Table prefix
 * Change this if you have multiple installs in the same database
 *
 */
$table_prefix  = 'nel_';

/*
 * Language
 * Leave blank for American English
 *
 */
define( 'WPLANG', 'nb_NO' );

/*
 * Hide errors
 *
 */
ini_set( 'display_errors', 0 );
if ( !defined('WP_DEBUG_DISPLAY') )
	define( 'WP_DEBUG_DISPLAY', false );

/*
 * Multisite setup - sudomain setup
 * DOMAIN_CURRENT_SITE must be set - Can be overriden in local-config and stage-config
 *
 *//*
define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
if ( !defined('DOMAIN_CURRENT_SITE') )
	define('DOMAIN_CURRENT_SITE', '');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
*/

if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );

if ( ! defined( 'WP_CLI' ) ) {
	require_once ABSPATH . 'wp-settings.php';
}
