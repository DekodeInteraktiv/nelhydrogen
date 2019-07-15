<?php

namespace ACP\Editing\Model\Media;

use ACP\Editing\Model;

class Title extends Model {

	public function get_edit_value( $id ) {
		$post = get_post( $id );

		return $post ? $post->post_title : false;
	}

	public function get_view_settings() {
		return array(
			'type'         => 'text',
			'js'           => array(
				'selector' => 'strong > a',
			),
			'display_ajax' => false,
		);
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'post_title' => $value ) );
	}

}