<?php

namespace ACP\Column\Post;

use AC;
use ACP\Sorting;

class Path extends AC\Column\Post\Path
	implements Sorting\Sortable {

	public function sorting() {
		return new Sorting\Model( $this );
	}

}