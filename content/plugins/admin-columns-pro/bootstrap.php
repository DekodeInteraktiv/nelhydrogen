<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'api.php';

AC\Autoloader::instance()->register_prefix( 'ACP', __DIR__ . '/classes' );
AC\Autoloader\Underscore::instance()->add_alias( 'ACP\AdminColumnsPro', 'ACP' );

ACP();