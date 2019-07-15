<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class Content extends Model {

	public function get_view_settings() {
		return array(
			'type' => 'textarea',
		);
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'post_content' => $value ) );
	}

}