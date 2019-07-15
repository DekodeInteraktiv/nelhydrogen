<?php

namespace ACA\ACF\Sorting;

use ACA\ACF\Sorting;

class Gallery extends Sorting {

	public function __construct( $column ) {
		parent::__construct( $column );

		$this->set_data_type( 'numeric' );
	}

	public function get_sorting_vars() {
		$values = array();

		foreach ( $this->strategy->get_results() as $id ) {
			$values[ $id ] = count( $this->column->get_raw_value( $id ) );
		}

		return array(
			'ids' => $this->sort( $values ),
		);
	}

}