<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class FeaturedImage extends Model {

	public function get_view_settings() {
		return array(
			'type'         => 'media',
			'attachment'   => array(
				'library' => array(
					'type' => 'image',
				),
			),
			'clear_button' => true,
		);
	}

	public function save( $id, $value ) {
		if ( $value ) {
			set_post_thumbnail( $id, $value );
		} else {
			delete_post_thumbnail( $id );
		}

		acp_editing_helper()->update_post_last_modified( $id );
	}

}