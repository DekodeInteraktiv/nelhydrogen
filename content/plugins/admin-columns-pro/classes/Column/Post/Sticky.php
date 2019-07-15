<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Sticky extends AC\Column\Post\Sticky
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable {

	public function sorting() {
		return new Sorting\Model\Post\Sticky( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Sticky( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\Sticky( $this );
	}

}