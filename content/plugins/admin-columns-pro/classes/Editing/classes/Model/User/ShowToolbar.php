<?php

namespace ACP\Editing\Model\User;

use ACP\Editing\Model;

class ShowToolbar extends Model {

	public function get_view_settings() {
		return array(
			'type'    => 'togglable',
			'options' => array( 'true', 'false' ),
		);
	}

	public function save( $id, $value ) {
		update_user_meta( $id, 'show_admin_bar_front', $value );
	}

}