<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

class RichEditing extends AC\Column\User\RichEditing
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable {

	public function editing() {
		return new Editing\Model\User\RichEditing( $this );
	}

	public function filtering() {
		return new Filtering\Model\User\RichEditing( $this );
	}

	public function sorting() {
		return new Sorting\Model( $this );
	}

}