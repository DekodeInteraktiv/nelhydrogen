<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Categories extends AC\Column\Post\Categories
	implements Sorting\Sortable, Editing\Editable, Filtering\Filterable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model\Post\Taxonomy( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Taxonomy( $this );
	}

	public function filtering() {
		return new Filtering\Model\Delegated( $this, 'cat' );
	}

	public function export() {
		return new Export\Model\Post\Taxonomy( $this );
	}

}