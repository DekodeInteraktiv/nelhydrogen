<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class TitleRaw extends Model {

	public function get_edit_value( $id ) {
		return get_post_field( 'post_title', $id );
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'post_title' => $value ) );
	}

}