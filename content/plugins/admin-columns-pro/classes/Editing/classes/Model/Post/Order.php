<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class Order extends Model {

	public function get_edit_value( $id ) {
		return get_post_field( 'menu_order', $id );
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'menu_order' => $value ) );

		return $value;
	}

}