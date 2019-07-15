<?php

namespace ACP\Editing\Model\Taxonomy;

use ACP\Editing\Model;

class Menu extends Model\Menu {

	/**
	 * @param int $id
	 *
	 * @return string|false
	 */
	protected function get_title( $id ) {
		$term = get_term_by( 'id', $id, $this->column->get_taxonomy() );

		return $term->name;
	}

}