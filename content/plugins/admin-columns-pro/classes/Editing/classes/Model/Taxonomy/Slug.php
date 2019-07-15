<?php

namespace ACP\Editing\Model\Taxonomy;

use ACP\Editing\Model;

class Slug extends Model {

	public function get_edit_value( $id ) {
		return ac_helper()->taxonomy->get_term_field( 'slug', $id, $this->get_column()->get_taxonomy() );
	}

	public function save( $id, $value ) {
		$this->strategy->update( $id, array( 'slug' => $value ) );
	}

}