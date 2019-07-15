<?php

namespace ACP\Editing\Model\User;

use ACP\Editing\Model;

class Registered extends Model {

	public function get_view_settings() {
		return array(
			'type' => 'date_time',
		);
	}

	public function save( $id, $value ) {
		wp_update_user( (object) array(
			'ID'              => $id,
			'user_registered' => $value,
		) );
	}

}