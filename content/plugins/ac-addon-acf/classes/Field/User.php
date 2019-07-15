<?php

namespace ACA\ACF\Field;

use AC\Collection;
use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Filtering;
use ACP;
use AC;

class User extends Field {

	public function get_value( $id ) {
		return $this->column->get_formatted_value( new Collection( $this->get_raw_value( $id ) ) );
	}

	public function get_raw_value( $id ) {
		return array_filter( (array) parent::get_raw_value( $id ) );
	}

	public function get_dependent_settings() {
		return array(
			new AC\Settings\Column\User( $this->column ),
		);
	}

	public function editing() {
		return new Editing\User( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model\Value( $this->column );
	}

	public function filtering() {
		return new Filtering\User( $this->column );
	}

	public function export() {
		return new ACP\Export\Model\StrippedValue( $this->column );
	}

}