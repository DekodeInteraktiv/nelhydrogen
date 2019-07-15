<?php namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class PingStatus extends Model {

	public function get_view_settings() {
		return array(
			'type'    => 'togglable',
			'options' => array( 'closed', 'open' ),
		);
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'ping_status' => $value ) );
	}

}