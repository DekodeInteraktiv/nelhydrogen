<?php

function get_tax_type_object_title( $term = false ) {
	if ( ! $term ) {
		$term = get_queried_object();
	}
	$tax = get_taxonomy( $term->taxonomy );
	if ( isset( $tax->object_type[0] ) ) {
		$post_type_object = get_post_type_object( $tax->object_type[0] );
		if ( $post_type_object ) {
			return $post_type_object->labels->name;
		}
	}

	// Default to the term name
	return $term->name;
}

function get_pagebuilder( $acf_id = false ) {
	include TEMPLATEPATH . '/partials/blocks.php';
	// get_template_part('partials/blocks');
}

function nel_inline_json( $array ) {
	return htmlspecialchars( wp_json_encode( $array ) );
}

function is_localhost() {
	$whitelist = array( '127.0.0.1' );

	return in_array( $_SERVER['REMOTE_ADDR'], $whitelist );
}

function get_doc_page_terms() {
	$doc_page = get_page_by_template( 'page-templates/documents.php' );
	if ( $doc_page ) {
		$terms = get_field( 'document_categories', $doc_page->ID );

		return $terms;
	}
}

function terms_to_links( $terms ) {
	$term_links = array_map( function ( $term ) {
		return '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';
	}, $terms );

	return implode( ', ', $term_links );
}

function get_doc_page_term_ids() {
	$terms = get_doc_page_terms();
	if ( $terms ) {
		return wp_list_pluck( $terms, 'term_id' );
	}
}

function human_filesize( $file ) {
	$bytes = filesize( $file );
	$s     = array( 'b', 'Kb', 'Mb', 'Gb' );
	$e     = floor( log( $bytes ) / log( 1024 ) );

	return sprintf( '%.2f ' . $s[ $e ], ( $bytes / pow( 1024, floor( $e ) ) ) );
}

/**
 * Get nav menu items by location
 *
 * @param $location The menu location id
 */
function get_nav_menu_items_by_location( $location, $args = [] ) {
	// Get all locations
	$locations = get_nav_menu_locations();
	// Get object id by location
	if ( isset( $locations[ $location ] ) ) {
		$object = wp_get_nav_menu_object( $locations[ $location ] );
		// Get menu items by menu name
		$menu_items = wp_get_nav_menu_items( $object->name, $args );

		// Return menu post objects
		return $menu_items;
	} else {
		return array();
	}
}

function get_drawer_menus() {
	$child_menus    = array();
	$nav_menu_items = get_nav_menu_items_by_location( 'primary-menu' );
	foreach ( $nav_menu_items as $key => $nav_menu_item ) {
		if ( $nav_menu_item->menu_item_parent == 0 && in_array( 'DrawerNavToggle', $nav_menu_item->classes ) ) {
			// Find the children
			foreach ( $nav_menu_items as $c_key => $child_item ) {
				if ( $child_item->menu_item_parent == $nav_menu_item->ID ) {
					if ( ! isset( $child_menus[ $nav_menu_item->ID ] ) ) {
						$child_menus[ $nav_menu_item->ID ] = array();
					}
					$child_menus[ $nav_menu_item->ID ][] = $child_item;
				}
			}
		}
	}

	return $child_menus;
}

function add_drawer_menu_trigger( $atts, $item, $args ) {
	if ( in_array( 'DrawerNavToggle', $item->classes ) ) {
		$atts['data-drawer-id'] = $item->ID;
	}
	if ( ! isset( $atts['title'] ) || ! $atts['title'] ) {
		$atts['title'] = esc_attr( $item->post_title );
	}

	return $atts;
}

add_filter( 'nav_menu_link_attributes', 'add_drawer_menu_trigger', 10, 3 );


/**
 *
 * @return object
 */
function get_page_by_template( $template ) {

	$args = array(
		'post_type'        => 'page',
		'meta_key'         => '_wp_page_template',
		'meta_value'       => $template,
		'suppress_filters' => false // WPML support
	);

	$query = new WP_Query( $args );
	$pages = $query->get_posts();

	if ( isset( $pages[0] ) ) {
		return $pages[0];
	}

}

function get_page_template_url( $template ) {
	$template = get_page_by_template( $template );
	if ( $template ) {
		return get_permalink( $template->ID );
	}
}

function hey_get_inline_svg( $filepath ) {
	return file_get_contents( TEMPLATEPATH . $filepath );
}

if ( ! function_exists( 'write_log' ) ) {
	function write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}


function nel_get_search_result_text() {

	global $wp_query;
	$post_count = $wp_query->found_posts;
	$query      = '<span class="query">' . get_search_query() . '</span>';

	if ( $post_count <= 0 ) {
		$text = sprintf( __( 'Could not find any results for "%s".', 'nel' ), $query );
		$text .= '<br>' . __( 'Try again with different keywords.', 'nel' );
	} else {
		$text = sprintf( _n( 'Found %s result for "%s"', 'Found %s results for "%s"', $post_count, 'nel' ), $post_count, $query );
	}

	//
	return $text;
}

function nel_get_post_type_label( $post_type ) {
	$types = array(
		'page'        => __( 'Page', 'nel' ),
		'product'     => __( 'Product', 'nel' ),
		'person'      => __( 'Person', 'nel' ),
		'cision_post' => __( 'Cision post', 'nel' )
	);

	return ( isset( $types[ $post_type ] ) ) ? '<span class="post-type-label">' . $types[ $post_type ] . '</span>' : '';
}


function nel_get_division( $key ) {
	$divisions = get_field( 'divisions', 'options' );
	foreach ( $divisions as $division ) {
		if ( $division['key'] == $key ) {
			return $division;
		}
	}
}


function render_wysiwyg_open() {
	echo '<div class="row align-center"><div class="columns medium-10 large-8 wysiwyg">';
}

add_action( 'wysiwyg_open', 'render_wysiwyg_open' );

function render_wysiwyg_close() {
	echo '</div></div>';
}

add_action( 'wysiwyg_close', 'render_wysiwyg_close' );


function nel_get_term_link( $term ) {
	$args  = array(
		'post_type'      => 'product',
		'posts_per_page' => 2,
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_category',
				'field'    => 'term_id',
				'terms'    => $term->term_id
			)
		)
	);
	$posts = get_posts( $args );
	if ( count( $posts ) == 1 ) {
		?>
        <a href="<?php echo get_permalink( $posts[0]->ID ); ?>">Explore</a>
		<?php
	} else {
		?>
        <a href="<?php echo get_term_link( $term ); ?>">Explore</a>
		<?php
	}
}


function nel_get_term_url( $term ) {
	$args  = array(
		'post_type'      => 'product',
		'posts_per_page' => 2,
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_category',
				'field'    => 'term_id',
				'terms'    => $term->term_id
			)
		)
	);
	$posts = get_posts( $args );
	if ( count( $posts ) == 1 ) {
		return get_permalink( $posts[0]->ID );
	} else {
		return get_term_link( $term );
	}
}


function nel_get_main_term( $post_id, $taxonomy ) {
	$terms = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'all' ) );
	if ( $terms ) {
		return $terms[0];
	}
}


function nel_get_hydrogen_slides() {

	$imgpath = get_template_directory_uri() . '/images/hydrogen/'; // gjør om til inline svg med animasjon

	$panels = array(

		array(
			'subtitle' => '',
			'classes'  => 'fit-to-screen flex-center',
			'content'  => '
			<div class="row sm-panel-content align-center">
				<div class="columns medium-8 large-6 text-center">
					' . apply_filters( 'the_content', get_the_content() ) . '
				</div>
			</div>'
		),

		array(
			'subtitle' => get_field( 'slide_1' ),
			'classes'  => 'scene-fuel fit-to-screen flex-center', // fit-to-screen flex-center
			'content'  => ''
		),

		array(
			'subtitle' => get_field( 'slide_2' ),
			'classes'  => 'scene-pollution fit-to-screen flex-center',
			'content'  => ''
		),

		array(
			'subtitle' => get_field( 'slide_3' ),
			'classes'  => 'fit-to-screen flex-center',
			'content'  => ''
		),

		array(
			'subtitle' => '',
			'classes'  => 'scene-challenge fit-to-screen flex-center bg-primary',
			'content'  => '<div class="row sm-panel-content align-center">
				<div class="columns medium-10 large-8 medium-text-center">
					' . get_field( 'slide_4' ) . '
				</div>
			</div>'
		),

		array(
			'subtitle' => get_field( 'slide_5' ),
			'classes'  => 'fit-to-screen flex-center',
			'content'  => '',
		),

		array(
			'subtitle' => get_field( 'slide_6' ),
			'before'   => '',
			'after'    => '',
			'classes'  => 'fit-to-screen flex-center',
			'content'  => '',
		),

		array(
			'subtitle' => get_field( 'slide_7' ),
			'classes'  => 'scene-future fit-to-screen flex-center',
			'content'  => '',
			'after'    => ''
		),

		array(
			'subtitle' => '',
			'classes'  => 'scene-outro fit-to-screen flex-center',
			'content'  => '<div class="row align-center">
				<div class="columns medium-8 large-6 text-center">
					' . get_field( 'slide_8' ) . '
				</div>
			</div>'
		)

	);

	return $panels;

}


function nel_get_ir_feeds( $key = '' ) {

	$feeds = array(

		// Company Info
		'company_info'      => array(
			'title' => 'Company info',
			'tmpl'  => 'tmpl_manamind_company_info',
			'url'   => '//ir.asp.manamind.com/products/xml/companyInfo.do?key=nel&lang=en'
		),

		// Snapshot
		// insp => http://ir.asp.manamind.com/irn/portal/component?component=snapshot&key=nel&lang=en&
		'snapshot'          => array(
			'title' => 'Snapshot',
			'tmpl'  => 'tmpl_manamind_snapshot',
			'url'   => '//ir.asp.manamind.com/products/xml/snapshot.do?key=nel&lang=en'
		),

		// Broker Statistics
		'broker_statistics' => array(
			'title' => 'Broker statistics',
			'tmpl'  => 'tmpl_manamind_broker_statistics',
			'url'   => '//ir.asp.manamind.com/products/xml/brokerStats.do?key=nel&lang=en&longnames=true'
			// interval: intraday/month
			// longnames: true/false
			// numberOfBrokers: 1-10
		),

		/*

		// Historical Profit Short
		'history_short' => array(
			'title' => 'Historical profit short',
			'tmpl' => 'tmpl_manamind_history_short',
			'url' => 'http://ir.asp.manamind.com/products/xml/historicalProfitShort.do?key=nel&lang=en'
		),
		
		// Historical Profit Long
		'history_long' => array(
			'title' => 'Historical profit long',
			'tmpl' => 'tmpl_manamind_history_long',
			'url' => 'http://ir.asp.manamind.com/products/xml/historicalProfitLong.do?key=nel&lang=en'
		),

		*/

		'history'            => array(
			'title' => 'Historical profit',
			'tmpl'  => 'tmpl_manamind_history',
			'url'   => array(
				'//ir.asp.manamind.com/products/xml/historicalProfitShort.do?key=nel&lang=en',
				'//ir.asp.manamind.com/products/xml/historicalProfitLong.do?key=nel&lang=en',
			)
		),

		// Financial Calendar
		'financial_calendar' => array(
			'title' => 'Financial calendar',
			'tmpl'  => 'tmpl_manamind_financial_calendar',
			'url'   => '//ir.asp.manamind.com/products/xml/financialCalendar.do?key=nel&lang=en'
		),

		// Peer Group Benchmark
		'benchmarks'         => array(
			'title' => 'Benchmarks',
			'tmpl'  => 'tmpl_manamind_benchmarks',
			'url'   => '//ir.asp.manamind.com/products/xml/peerGroupBenchmark.do?key=nel&lang=en'
			// longnames
			// fieldList
		),

		// Last trades
		// //ir.asp.manamind.com/irn/portal/component?component=trades&key=nel&lang=en&
		'trades'             => array(
			'title' => 'Last trades',
			'tmpl'  => 'tmpl_manamind_trades',
			'url'   => '//ir.asp.manamind.com/products/xml/trades.do?key=nel&lang=en&numberOfTrades=10',
		),

		// Share Performance
		// http://ir.asp.manamind.com/products/html/sharePerformance.do?key=nel&lang=en
		'performance'        => array(
			'title' => 'Share performance',
			'tmpl'  => 'tmpl_manamind_performance',
			'url'   => '//ir.asp.manamind.com/products/xml/sharePerformance.do?key=nel&lang=en',
		),

		// 'http://publish.ne.cision.com/Release/ListReleasesSortedByPublishDate/?feedUniqueIdentifier=' + feedUniqueIdentifier + '&pageSize=' + pageSize + '&pageIndex=' + pageIndex + '&startDate=' + startDate + '&endDate=' + endDate

		'cision_minifeed' => array(
			'title' => 'Press releases',
			'tmpl'  => 'tmpl_cision_minifeed',
			'url'   => '//publish.ne.cision.com/Release/ListReleasesSortedByPublishDate/?feedUniqueIdentifier=9b3a2801de&pageSize=3',
		),

	);

	if ( isset( $feeds[ $key ] ) ) {
		return $feeds[ $key ];
	}

	return $feeds;

}


function get_manamind_feed( $key ) {

	$feed       = nel_get_ir_feeds( $key );
	$feed_url   = ( is_array( $feed['url'] ) ) ? json_encode( $feed['url'] ) : $feed['url'];
	$feed_class = str_replace( '_', '-', $feed['tmpl'] );
	echo '<div class="manamind-feed ' . $feed_class . '" data-tmpl="' . $feed['tmpl'] . '" data-feed=\'' . $feed_url . '\'>' . $feed['title'] . '</div>';
	include TEMPLATEPATH . '/partials/' . $feed_class . '.php';

}


function get_share_links() {
	$urlCurrentPage = get_permalink();
	$facebook_link  = '<a class="share-link share-link-facebook" href="http://www.facebook.com/sharer.php?u=' . $urlCurrentPage . '" rel="noopener noreferrer" target="_blank"><span class="icon-facebook"></span>Facebook</a>';
	$twitter_text   = '';
	$twitter_link   = '<a class="share-link share-link-twitter" href="http://twitter.com/share?url=' . $urlCurrentPage . '&amp;text=' . $twitter_text . '" rel="noopener noreferrer" target="_blank"><span class="icon-twitter"></span>Twitter</a>';
	$pinterest      = "<a class='share-link share-link-pinterest' href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());'><span class='icon-pinterest'></span>Pinterest</a>";
	$email_link     = '<a class="share-link share-link-email" href="mailto:?subject=&amp;body=' . rawurlencode( $urlCurrentPage ) . '"><span class="icon-paper-airplane"></span>' . __( 'E-mail', 'nel' ) . '</a>';
	echo $twitter_link . ' ' . $facebook_link . ' ' . $email_link; // $facebook_link.' '.
}

function is_ajax() {
	return ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );
}


/*
Returns a 404 on private terms
*/
function nel_taxonomy_status() {
	if ( ! is_admin() ) {
		$queried_term = get_queried_object();
		if ( is_a( $queried_term, 'WP_Term' ) ) {
			$term_visibility = get_field( 'visibility', $queried_term );
			if ( $term_visibility == 'private' && ! current_user_can( 'read_private_posts' ) ) {
				global $wp_query;
				$wp_query->set_404();
				status_header( 404 );
			}
		}
	}
}

add_action( 'wp', 'nel_taxonomy_status' );

/*
Removes terms set to private from get_terms function
*/
function nel_hide_private_terms( $terms, $taxonomy, $query_vars, $term_query ) {
	foreach ( $terms as $key => $term ) {
		$term_visibility = get_field( 'visibility', $term );
		if ( $term_visibility == 'private' && ! current_user_can( 'read_private_posts' ) ) {
			unset( $terms[ $key ] );
		}
	}

	return $terms;
}

add_filter( 'get_terms', 'nel_hide_private_terms', 10, 4 );


function nel_get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {

	global $wpdb;

	if ( empty( $key ) ) {
		return;
	}

	$r = $wpdb->get_results( $wpdb->prepare( "
			SELECT p.ID, pm.meta_value FROM {$wpdb->postmeta} pm
			LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE pm.meta_key = '%s' 
			AND p.post_status = '%s' 
			AND p.post_type = '%s'
	", $key, $status, $type ) );

	foreach ( $r as $my_r ) {
		$metas[ $my_r->ID ] = $my_r->meta_value;
	}

	return $metas;
}


function csvToJson( $fname ) {
	// open csv file
	if ( ! ( $fp = fopen( $fname, 'r' ) ) ) {
		die( "Can't open file..." );
	}

	//read csv headers
	$key = fgetcsv( $fp, "1024", "," );

	// parse csv rows into array
	$json = array();
	while ( $row = fgetcsv( $fp, "1024", "," ) ) {
		$json[] = array_combine( $key, $row );
	}

	// release file handle
	fclose( $fp );

	// encode array to json
	return json_encode( $json );
}