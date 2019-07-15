<?php

namespace ACA\ACF\Setting\Field;

use ACA\ACF\Setting;

class Media extends Setting\Field {

	public function get_grouped_field_options( ) {
		add_filter( 'acf/location/rule_match/user_type', '__return_true', 16 );
		add_filter( 'acf/location/rule_match/page_type', '__return_true', 16 );

		add_filter( 'acf/location/rule_match/post', '__return_true', 16 );
		add_filter( 'acf/location/rule_match/post_category', '__return_true', 16 );
		add_filter( 'acf/location/rule_match/post_status', '__return_true', 16 );
		add_filter( 'acf/location/rule_match/post_taxonomy', '__return_true', 16 );

		add_filter( 'acf/location/rule_match/attachment', '__return_true', 16 );

		$groups = acf_get_field_groups( array( 'ac_dummy' => true ) ); // We need to pass an argument, otherwise the filters won't work

		remove_filter( 'acf/location/rule_match/user_type', '__return_true', 16 );
		remove_filter( 'acf/location/rule_match/page_type', '__return_true', 16 );

		remove_filter( 'acf/location/rule_match/post', '__return_true', 16 );
		remove_filter( 'acf/location/rule_match/post_category', '__return_true', 16 );
		remove_filter( 'acf/location/rule_match/post_status', '__return_true', 16 );
		remove_filter( 'acf/location/rule_match/post_taxonomy', '__return_true', 16 );

		remove_filter( 'acf/location/rule_match/attachment', '__return_true', 16 );

		return $this->get_option_groups( $groups );
	}

}