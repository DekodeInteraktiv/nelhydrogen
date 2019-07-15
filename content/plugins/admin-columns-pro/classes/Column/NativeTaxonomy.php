<?php

namespace ACP\Column;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

class NativeTaxonomy extends AC\Column
	implements Filtering\Filterable, Editing\Editable, Sorting\Sortable, Export\Exportable {

	public function __construct() {
		$this->set_original( true );
	}

	public function get_taxonomy() {
		return str_replace( 'taxonomy-', '', $this->get_type() );
	}

	public function filtering() {
		return new Filtering\Model\Post\Taxonomy( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Taxonomy( $this );
	}

	public function sorting() {
		return new Sorting\Model\Post\Taxonomy( $this );
	}

	public function export() {
		return new Export\Model\Post\Taxonomy( $this );
	}

}