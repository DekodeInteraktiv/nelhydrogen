<?php

namespace ACA\ACF\Sorting;

use ACA\ACF\Sorting;

class Repeater extends Sorting {

	public function __construct( $column ) {
		parent::__construct( $column );

		$this->set_data_type( 'numeric' );
	}

	public function get_sorting_vars() {
		$field = $this->column->get_acf_field();

		$ids = $this->strategy->get_results( array(
			'meta_key' => $field['name'],
			'orderby'  => 'meta_value_num',
		) );

		return array(
			'ids' => $ids,
		);
	}

}