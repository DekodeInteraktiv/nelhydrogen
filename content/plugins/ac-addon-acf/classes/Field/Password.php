<?php

namespace ACA\ACF\Field;

use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Filtering;
use ACP;
use AC;

class Password extends Field {

	public function get_dependent_settings() {
		return array(
			new AC\Settings\Column\Password( $this->column ),
		);
	}

	public function editing() {
		return new Editing\Password( $this->column );
	}

	public function filtering() {
		return new Filtering\Password( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model\Meta( $this->column );
	}

}