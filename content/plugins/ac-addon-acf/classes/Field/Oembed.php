<?php

namespace ACA\ACF\Field;

use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Filtering;
use ACA\ACF\Setting;

class Oembed extends Field {

	public function editing() {
		return new Editing\Text( $this->column );
	}

	public function filtering() {
		return new Filtering( $this->column );
	}

	public function get_dependent_settings() {
		return array(
			new Setting\Oembed( $this->column ),
		);
	}

}