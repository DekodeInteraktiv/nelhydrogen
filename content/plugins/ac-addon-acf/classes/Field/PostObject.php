<?php

namespace ACA\ACF\Field;

use AC\Collection;
use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Filtering;
use AC;
use ACP;

class PostObject extends Field {

	public function __construct( $column ) {
		parent::__construct( $column );

		$this->column->set_serialized( $this->column->get_acf_field_option( 'multiple' ) );
	}

	public function get_value( $id ) {
		return $this->column->get_formatted_value( new Collection( $this->get_raw_value( $id ) ) );
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	public function get_raw_value( $id ) {
		return array_filter( (array) parent::get_raw_value( $id ) );
	}

	public function editing() {
		return new Editing\PostObject( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model\Value( $this->column );
	}

	public function filtering() {
		return new Filtering\PostObject( $this->column );
	}

	public function export() {
		return new ACP\Export\Model\StrippedValue( $this->column );
	}

	public function get_dependent_settings() {
		return array(
			new AC\Settings\Column\Post( $this->column ),
		);
	}

}