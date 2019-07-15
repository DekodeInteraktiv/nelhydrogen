<?php

namespace ACA\ACF\Column;

use ACA\ACF;

class Post extends ACF\Column {

	public function register_settings() {
		$this->register_settings_by_type( 'Post' );
	}

	public function get_formatted_id( $id ) {
		return $id;
	}

}