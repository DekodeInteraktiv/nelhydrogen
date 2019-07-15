<?php

namespace ACP\Editing\Model\Comment;

use ACP\Editing\Model;

class AuthorEmail extends Model {

	public function get_view_settings() {
		return array( 'type' => 'email' );
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'comment_author_email' => $value ) );
	}

}