<?php

namespace ACA\ACF\Filtering;

class Relationship extends PostObject {

	public function get_filtering_data() {
		return array(
			'empty_option' => true,
			'options'      => $this->get_meta_values_unserialized(),
		);
	}

}