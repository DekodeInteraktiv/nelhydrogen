<?php

namespace ACA\ACF\Editing;

use ACA\ACF\Editing;

class DatePicker extends Editing {

	public function get_view_settings() {
		$data = parent::get_view_settings();
		$field = $this->column->get_field();

		$data['type'] = 'date';
		$data['weekstart'] = $field->get( 'first_day' );

		if ( ! $field->get( 'required' ) ) {
			$data['clear_button'] = true;
		}

		return $data;
	}

}