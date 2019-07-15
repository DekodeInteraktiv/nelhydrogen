<?php

namespace ACA\ACF\Editing;

class Select extends Options {

	public function get_view_settings() {
		$data = parent::get_view_settings();

		$data['type'] = 'select';
		if ( $this->column->get_field()->get( 'multiple' ) ) {
			$data['type'] = 'select2_dropdown';
			$data['multiple'] = true;
		}

		return $data;
	}

}