<?php

namespace ACP\Column\Media;

use AC;
use ACP\Filtering;
use ACP\Settings;

class UsedAsFeaturedImage extends AC\Column
	implements Filtering\Filterable {

	public function __construct() {
		$this->set_type( 'column-used_as_featured_image' );
		$this->set_label( __( 'Used as Featured Image', 'codepress-admin-columns' ) );
	}

	public function get_raw_value( $id ) {
		$posts = get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => 'any',
			'post_status'    => 'any',
			'fields'         => 'ids',
			'meta_query'     => array(
				array(
					'key'   => '_thumbnail_id',
					'value' => $id,
				),
			),
		) );

		return $posts;
	}

	protected function register_settings() {
		$this->add_setting( new Settings\Column\FeaturedImageDisplay( $this ) );
	}

	public function filtering() {
		return new Filtering\Model\Media\UsedAsFeaturedImage( $this );
	}

}