<?php

namespace ACA\ACF\Filtering;

use ACA\ACF\Filtering;

class Taxonomy extends Filtering {

	public function get_filtering_data() {

		if ( $this->column->is_serialized() ) {
			$values = $this->get_meta_values_unserialized();
		} else {
			$values = $this->get_meta_values();
		}

		return array(
			'empty_option' => true,
			'options'      => acp_filtering()->helper()->get_term_names( $values, $this->get_taxonomy() ),
		);
	}

	private function get_taxonomy() {
		return $this->column->get_field()->get( 'taxonomy' );
	}

}