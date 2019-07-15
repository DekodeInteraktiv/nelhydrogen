<?php

namespace ACP\Column\Post;

use AC;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 2.0
 */
class LastModifiedAuthor extends AC\Column\Post\LastModifiedAuthor
	implements Filtering\Filterable, Sorting\Sortable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model\Post\LastModifiedAuthor( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\LastModifiedAuthor( $this );
	}

	public function export() {
		return new Export\Model\Post\LastModifiedAuthor( $this );
	}

}