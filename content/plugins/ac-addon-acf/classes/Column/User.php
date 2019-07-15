<?php

namespace ACA\ACF\Column;

use ACA\ACF;

class User extends ACF\Column {

	public function get_formatted_id( $id ) {
		return 'user_' . $id;
	}

	public function register_settings() {
		$this->register_settings_by_type( 'User' );
	}

}