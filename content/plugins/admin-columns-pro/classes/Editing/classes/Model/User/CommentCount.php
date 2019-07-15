<?php

namespace ACP\Editing\Model\User;

use ACP\Editing\Model;

class CommentCount extends Model {

	public function get_view_settings() {
		return array(
			'type' => 'textarea',
		);
	}

	public function save( $id, $value ) {
		update_user_meta( $id, 'description', $value );
	}

}