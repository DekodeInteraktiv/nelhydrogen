<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Sorting;

/**
 * @since 2.0
 */
class Description extends AC\Column\User\Description
	implements Sorting\Sortable {

	public function sorting() {
		return new Sorting\Model( $this );
	}

	public function editing() {
		return new Editing\Model\User\Description( $this );
	}

}