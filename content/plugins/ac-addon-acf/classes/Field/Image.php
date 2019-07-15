<?php

namespace ACA\ACF\Field;

use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Filtering;
use AC;
use ACP;

class Image extends Field {

	public function editing() {
		return new Editing\Image( $this->column );
	}

	public function filtering() {
		return new Filtering\Image( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model\Meta( $this->column );
	}

	public function get_dependent_settings() {
		return array(
			new AC\Settings\Column\Image( $this->column ),
		);
	}

}