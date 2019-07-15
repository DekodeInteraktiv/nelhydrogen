<?php

namespace ACA\ACF\Editing;

use ACA\ACF\Editing;

class TrueFalse extends Editing {

	public function get_view_settings() {
		$data = parent::get_view_settings();

		$data['type'] = 'togglable';
		$data['options'] = array( '0', '1' );

		return $data;
	}

}