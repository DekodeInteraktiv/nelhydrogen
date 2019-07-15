<?php

namespace ACP\Editing\Model\Comment;

use ACP\Editing\Model;

class AuthorURL extends Model {

	public function get_view_settings() {
		return array(
			'type' => 'url',
		);
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'comment_author_url' => $value ) );
	}

}