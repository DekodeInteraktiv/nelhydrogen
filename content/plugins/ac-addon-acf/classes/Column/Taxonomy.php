<?php

namespace ACA\ACF\Column;

use ACA\ACF;

class Taxonomy extends ACF\Column {

	public function get_formatted_id( $id ) {
		return $this->get_taxonomy() . '_' . $id;
	}

	public function register_settings() {
		$this->register_settings_by_type( 'Taxonomy' );
	}

}