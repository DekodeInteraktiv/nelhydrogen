<?php

namespace ACP\Column\Media;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

class Taxonomy extends AC\Column\Media\Taxonomy
	implements Sorting\Sortable, Editing\Editable, Filtering\Filterable {

	public function sorting() {
		return new Sorting\Model\Post\Taxonomy( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Taxonomy( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\Taxonomy( $this );
	}

}