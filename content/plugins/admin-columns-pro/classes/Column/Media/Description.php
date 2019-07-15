<?php

namespace ACP\Column\Media;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

class Description extends AC\Column\Media\Description
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable {

	public function sorting() {
		return new Sorting\Model( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Content( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\Content( $this );
	}

}