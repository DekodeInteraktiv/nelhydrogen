<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class Excerpt extends Model {

	public function get_view_settings() {
		return array(
			'type'        => 'textarea',
			'placeholder' => __( 'Excerpt automatically generated from content.', 'codepress-admin-columns' ),
		);
	}

	public function get_edit_value( $id ) {
		$value = ac_helper()->post->get_raw_field( 'post_excerpt', $id );

		if ( ! $value ) {
			return '';
		}

		return $value;
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'post_excerpt' => $value ) );
	}

}