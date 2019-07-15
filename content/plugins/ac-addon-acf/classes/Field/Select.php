<?php

namespace ACA\ACF\Field;

use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Export;
use ACA\ACF\Filtering;
use ACP;

class Select extends Field {

	public function get_value( $id ) {
		$value = parent::get_value( $id );
		$choices = $this->column->get_field()->get( 'choices' );

		$options = array();
		foreach ( (array) $value as $value ) {
			if ( isset( $choices[ $value ] ) ) {
				$options[] = $choices[ $value ];
			}
		}

		return ac_helper()->html->implode( $options );
	}

	public function editing() {
		return new Editing\Select( $this->column );
	}

	public function filtering() {
		return new Filtering\Options( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model\Meta( $this->column );
	}

	public function export() {
		return new Export\Select( $this->column );
	}

}