<?php

namespace ACP\Sorting\Model\Media;

use AC;

/**
 * @property AC\Column\Media\AvailableSizes $column
 */
class AvailableSizes extends Meta {

	public function get_sorting_vars() {
		$ids = array();

		foreach ( $this->get_meta_values() as $id => $meta_value ) {
			$count = 0;
			if ( ! empty( $meta_value['sizes'] ) && is_array( $meta_value['sizes'] ) ) {
				$count = count( $this->column->get_available_sizes( $meta_value['sizes'] ) );
			}

			$ids[ $id ] = $count;
		}

		return array(
			'ids' => $this->sort( $ids ),
		);
	}
}