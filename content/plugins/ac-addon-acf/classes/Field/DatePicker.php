<?php

namespace ACA\ACF\Field;

use ACA\ACF\Export\Date;
use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Filtering;
use ACA\ACF\Setting;
use ACP;

class DatePicker extends Field {

	public function editing() {
		return new Editing\DatePicker( $this->column );
	}

	public function sorting() {
		$model = new ACP\Sorting\Model\Meta( $this->column );
		$model->set_data_type( 'numeric' );

		return $model;
	}

	public function filtering() {
		return new Filtering\DatePicker( $this->column );
	}

	public function export() {
		return new Date( $this->column );
	}

	public function get_dependent_settings() {
		return array(
			new Setting\Date( $this->column ),
		);
	}

}