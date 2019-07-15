<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class Formats extends Model {

	public function get_view_settings() {
		return array(
			'type'    => 'select',
			'options' => get_post_format_strings(),
		);
	}

	public function save( $id, $value ) {
		set_post_format( $id, $value );
	}

}