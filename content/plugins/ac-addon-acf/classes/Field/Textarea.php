<?php

namespace ACA\ACF\Field;

use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Sorting;
use ACA\ACF\Filtering;
use AC;

class Textarea extends Field {

	public function get_dependent_settings() {
		return array(
			new AC\Settings\Column\WordLimit( $this->column ),
		);
	}

	public function editing() {
		return new Editing\Textarea( $this->column );
	}

	public function sorting() {
		return new Sorting( $this->column );
	}

	public function filtering() {
		return new Filtering( $this->column );
	}

}