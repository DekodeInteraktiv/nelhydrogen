<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 2.0
 */
class Formats extends AC\Column\Post\Formats
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable {

	public function sorting() {
		return new Sorting\Model( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Formats( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\Formats( $this );
	}

}