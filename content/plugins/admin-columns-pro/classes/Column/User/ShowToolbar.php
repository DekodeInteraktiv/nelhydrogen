<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
class ShowToolbar extends AC\Column\User\ShowToolbar
	implements Filtering\Filterable, Sorting\Sortable, Editing\Editable {

	public function sorting() {
		return new Sorting\Model( $this );
	}

	public function editing() {
		return new Editing\Model\User\ShowToolbar( $this );
	}

	public function filtering() {
		return new Filtering\Model\User\ShowToolbar( $this );
	}

}