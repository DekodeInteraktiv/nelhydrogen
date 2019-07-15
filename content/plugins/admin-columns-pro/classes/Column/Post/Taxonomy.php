<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

class Taxonomy extends AC\Column\Post\Taxonomy
	implements Sorting\Sortable, Editing\Editable, Filtering\Filterable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model\Post\Taxonomy( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Taxonomy( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\Taxonomy( $this );
	}

	public function export() {
		return new Export\Model\Post\Taxonomy( $this );
	}

}