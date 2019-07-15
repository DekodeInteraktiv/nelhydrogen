<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

class Excerpt extends AC\Column\Post\Excerpt
	implements Sorting\Sortable, Editing\Editable, Filtering\Filterable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model\Value( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\Excerpt( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Excerpt( $this );
	}

	public function export() {
		return new Export\Model\StrippedRawValue( $this );
	}

}