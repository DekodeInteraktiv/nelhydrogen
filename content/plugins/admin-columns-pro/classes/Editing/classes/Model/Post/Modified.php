<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class Modified extends Model {

	public function get_edit_value( $id ) {
		$post = get_post( $id );

		return $post->post_modified;
	}

	public function get_view_settings() {
		return array(
			'type' => 'date_time',
		);
	}

	public function save( $id, $value ) {
		global $wpdb;

		$sql = $wpdb->prepare( "UPDATE $wpdb->posts 
					   SET post_modified = %s
					   WHERE ID = %d", $value, $id );

		$result = $wpdb->query( $sql );
		clean_post_cache( $id );

		return $result;
	}

}