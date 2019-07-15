<?php

namespace ACP\Sorting\Model\Media;

use ACP\Sorting\Model;

class Dimensions extends Model\Media\Meta {

	protected function get_width( $values ) {
		return $this->get_meta_value( $values, 'width' );
	}

	protected function get_height( $values ) {
		return $this->get_meta_value( $values, 'height' );
	}

	protected function get_dimensions( $values ) {
		return $this->get_height( $values ) * $this->get_width( $values );
	}

	protected function get_aspect( $values ) {
		return $this->get_dimensions( $values );
	}

	public function get_sorting_vars() {
		$meta_values = $this->get_meta_values();

		foreach ( $meta_values as $id => $values ) {
			$aspect = $this->get_aspect( $values );

			$meta_values[ $id ] = $aspect ? $aspect : '';
		}

		return array(
			'ids' => $this->sort( $meta_values ),
		);
	}

}