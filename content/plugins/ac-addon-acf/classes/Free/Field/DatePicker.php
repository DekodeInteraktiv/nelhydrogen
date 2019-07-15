<?php

namespace ACA\ACF\Free\Field;

use ACA\ACF\Free;
use ACA\ACF\Field;
use ACP;

class DatePicker extends Field\DatePicker {

	public function sorting() {
		return new ACP\Sorting\Model\Value( $this->column );
	}

	public function editing() {
		return new Free\Editing\DatePicker( $this->column );
	}

	public function get_dependent_settings() {
		return array(
			new Free\Setting\Date( $this->column ),
		);
	}

}