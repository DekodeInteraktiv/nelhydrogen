<?php

namespace ACA\ACF\Field;

use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Sorting;
use AC;

class Gallery extends Field {

	public function editing() {
		return new Editing\Gallery( $this->column );
	}

	public function sorting() {
		return new Sorting\Gallery( $this->column );
	}

	public function get_dependent_settings() {
		return array(
			new AC\Settings\Column\Images( $this->column ),
		);
	}

}