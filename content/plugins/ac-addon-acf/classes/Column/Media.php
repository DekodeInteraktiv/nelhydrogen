<?php

namespace ACA\ACF\Column;

use ACA\ACF;

class Media extends ACF\Column {

	public function register_settings() {
		$this->register_settings_by_type( 'Media' );
	}

	public function get_formatted_id( $id ) {
		return $id;
	}

}