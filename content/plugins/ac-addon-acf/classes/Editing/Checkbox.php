<?php

namespace ACA\ACF\Editing;

class Checkbox extends Options {

	public function get_view_settings() {
		$data = parent::get_view_settings();

		$data['type'] = 'checklist';

		return $data;
	}

}