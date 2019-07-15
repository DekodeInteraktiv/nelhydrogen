<?php

namespace ACP\Editing\Model\User;

use ACP\Editing\Model;

class Email extends Model {

	public function get_edit_value( $id ) {
		return ac_helper()->user->get_user_field( 'user_email', $id );
	}

	public function get_view_settings() {
		return array(
			'type'        => 'text',
			'placeholder' => $this->column->get_label(),
		);
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'user_email' => $value ) );
	}

}