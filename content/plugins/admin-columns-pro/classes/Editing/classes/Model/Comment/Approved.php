<?php

namespace ACP\Editing\Model\Comment;

use ACP\Editing\Model;

class Approved extends Model {

	public function get_view_settings() {
		return array(
			'type'    => 'togglable',
			'options' => array( 0, 1 ),
		);
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'comment_approved' => $value ) );
	}

}