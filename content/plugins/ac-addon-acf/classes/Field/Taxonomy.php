<?php

namespace ACA\ACF\Field;

use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Sorting;
use ACA\ACF\Filtering;
use ACP;

class Taxonomy extends Field {

	public function __construct( $column ) {
		parent::__construct( $column );

		// Checkbox and Multi select are stored serialized
		$this->column->set_serialized( in_array( $this->get( 'field_type' ), array( 'checkbox', 'multi_select' ) ) );
	}

	public function get_value( $id ) {
		$term_ids = parent::get_value( $id );

		$values = array();

		foreach ( ac_helper()->taxonomy->get_terms_by_ids( $term_ids, $this->get( 'taxonomy' ) ) as $term ) {
			$values[] = ac_helper()->html->link( get_edit_term_link( $term->term_id, $term->taxonomy ), $term->name );
		}

		return implode( ', ', $values );
	}

	public function editing() {
		return new Editing\Taxonomy( $this->column );
	}

	public function filtering() {
		return new Filtering\Taxonomy( $this->column );
	}

	public function sorting() {
		if ( $this->column->get_field()->get( 'multiple' ) ) {
			return new ACP\Sorting\Model\Value( $this->column );
		}

		return new Sorting( $this->column );
	}

	public function export() {
		return new ACP\Export\Model\StrippedValue( $this->column );
	}

}