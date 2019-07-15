<?php

namespace ACA\ACF\Filtering;

use ACA\ACF\Filtering;

class Image extends Filtering {

	public function get_filtering_data() {
		return array(
			'options'      => acp_filtering()->helper()->get_post_titles( $this->get_meta_values() ),
			'empty_option' => true,
		);
	}

}