<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class Sticky extends Model {

	public function get_view_settings() {
		return array(
			'type'    => 'togglable',
			'options' => array( 'no', 'yes' ),
		);
	}

	public function get_edit_value( $id ) {
		$value = parent::get_edit_value( $id );

		return $value ? 'yes' : 'no';
	}

	public function save( $id, $value ) {
		if ( 'yes' == $value ) {
			stick_post( $id );
		} else {
			unstick_post( $id );
		}

		acp_editing_helper()->update_post_last_modified( $id );
	}

}