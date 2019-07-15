<?php

/**
 * Mustache templating
 * Docs: https://github.com/bobthecow/mustache.php/wiki
 *
 * Using the MVC pattern
 * https://www.sitepoint.com/the-mvc-pattern-and-php-1/
 *
 */

require_once( TEMPLATEPATH . '/vendor/autoload.php' );

global $mustache;

$mustache = new Mustache_Engine( array(
	'template_class_prefix' => '__NEL__',
	'cache'                 => WP_CONTENT_DIR . '/cache/mustache',
	'loader'                => new Mustache_Loader_FilesystemLoader( TEMPLATEPATH . '/views' ),
	'partials_loader'       => new Mustache_Loader_FilesystemLoader( TEMPLATEPATH . '/views/partials' ),
	'helpers'               => array(
		'the_content' => function ( $text, $mustache ) {
			// Use: {{#the_content}}{{content}}{{/the_content}}
			return apply_filters( 'the_content', $mustache->render( $text ) );
		},
		// 'render' => function($content, $mustache){
		//   return $mustache->render($content);
		// }
		// 'permalink' => function($text, $mustache) {
		//   write_log($text);
		//   // $pm = get_permalink($mustache->render($text));
		//   return '#';
		// }
	)
) );


function getComponent( $name, $data = null ) {

	if ( $data == null ) {
		$data = $name;
	}

	// Maybe get class
	if ( is_string( $data ) ) {
		$class = TEMPLATEPATH . '/models/' . $data . '.class.php';
		if ( file_exists( $class ) ) {
			include $class;
			$class_name = 'MUSTACHE_' . $data;
			if ( class_exists( $class_name ) ) {
				$data = new $class_name;
			}
		}
	}

	// Output template
	global $mustache;
	$tpl = $mustache->loadTemplate( $name );
	echo $tpl->render( $data );

}