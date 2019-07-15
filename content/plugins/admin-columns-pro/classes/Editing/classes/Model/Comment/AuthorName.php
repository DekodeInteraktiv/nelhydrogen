<?php

namespace ACP\Editing\Model\Comment;

use ACP\Editing\Model;

class AuthorName extends Model {

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'comment_author' => $value ) );
	}

}