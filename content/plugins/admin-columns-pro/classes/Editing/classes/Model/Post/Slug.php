<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class Slug extends Model {

	public function get_view_settings() {
		return array(
			'type'        => 'text',
			'placeholder' => $this->column->get_label(),
		);
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'post_name' => $value ) );
	}

}