<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class Author extends Model {

	public function get_edit_value( $id ) {
		$user = get_userdata( ac_helper()->post->get_raw_field( 'post_author', $id ) );

		if ( ! $user ) {
			return false;
		}

		return array(
			$user->ID => $user->display_name,
		);
	}

	public function get_view_settings() {
		return array(
			'type'               => 'select2_dropdown',
			'ajax_populate'      => true,
			'store_single_value' => true,
		);
	}

	public function get_ajax_options( $request ) {
		return acp_editing_helper()->get_users_list( array(
			'search' => $request['search'],
			'paged'  => $request['paged'],
		) );
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'post_author' => $value ) );
	}

}