<?php

namespace ACP\ThirdParty\bbPress\Editing;

use ACP\Editing;

class TopicForum extends Editing\Model {

	public function get_view_settings() {
		return array(
			'type'          => 'select2_dropdown',
			'ajax_populate' => true,
			'multiple'      => false,
			'clear_button'  => true,
		);
	}

	public function get_ajax_options( $request ) {
		return acp_editing_helper()->get_posts_list( array(
			's'         => $request['search'],
			'post_type' => 'forum',
			'paged'     => $request['paged'],
		) );
	}

	public function get_edit_value( $id ) {
		$forum_id = get_post_meta( $id, '_bbp_forum_id', true );
		$post = get_post( $forum_id );

		if ( ! $post ) {
			return false;
		}

		return array(
			$post->ID => $post->post_title,
		);
	}

	public function save( $id, $value ) {
		return update_post_meta( $id, '_bbp_forum_id', $value );
	}

}