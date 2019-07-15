<?php

namespace ACA\ACF\Field;

use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Setting;
use ACA\ACF\Sorting;

class TimePicker extends Field {

	public function editing() {
		return new Editing\Text( $this->column );
	}

	public function sorting() {
		return new Sorting( $this->column );
	}

	public function get_dependent_settings() {
		return array(
			new Setting\Time( $this->column ),
		);
	}
}
