<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 2.0
 */
class PageTemplate extends AC\Column\Post\PageTemplate
	implements Filtering\Filterable, Sorting\Sortable, Editing\Editable {

	public function sorting() {
		return new Sorting\Model( $this );
	}

	public function editing() {
		return new Editing\Model\Post\PageTemplate( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\PageTemplate( $this );
	}

}