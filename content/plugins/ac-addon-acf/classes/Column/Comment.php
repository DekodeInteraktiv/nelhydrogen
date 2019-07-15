<?php

namespace ACA\ACF\Column;

use ACA\ACF;

class Comment extends ACF\Column {

	public function get_formatted_id( $id ) {
		return 'comment_' . $id;
	}

	public function register_settings() {
		$this->register_settings_by_type( 'Comment' );
	}

}