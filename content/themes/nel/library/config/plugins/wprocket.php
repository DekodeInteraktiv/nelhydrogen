<?php

add_filter( 'rocket_cache_search', '__return_true' );

function hey_change_wprocket_capability( $capability ) {
	$capability = 'edit_pages';

	return $capability;
}

add_filter( 'rocket_capacity', 'hey_change_wprocket_capability' );