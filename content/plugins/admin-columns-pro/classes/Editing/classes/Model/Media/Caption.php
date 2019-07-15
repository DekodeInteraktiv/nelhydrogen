<?php

namespace ACP\Editing\Model\Media;

use ACP\Editing\Model;

class Caption extends Model {

	public function get_view_settings() {
		return array(
			'type' => 'textarea',
		);
	}

	public function get_edit_value( $id ) {
		$value = parent::get_edit_value( $id );

		return $value ? $value : false;
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'post_excerpt' => $value ) );
	}

}