<?php

namespace ACA\ACF\Filtering;

use ACA\ACF\Filtering;

class Password extends Filtering {

	public function get_filtering_data() {
		return array(
			'empty_option' => true,
			'options'      => array(),
		);
	}

}