<?php

namespace ACP\Editing\Model\Comment;

use ACP\Editing\Model;

class Excerpt extends Model {

	public function get_view_settings() {
		return array(
			'type' => 'textarea',
		);
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'comment_content' => $value ) );
	}

}