<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 2.0
 */
class FirstName extends AC\Column\User\FirstName
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable {

	public function sorting() {
		return new Sorting\Model\Meta( $this );
	}

	public function editing() {
		return new Editing\Model\Meta( $this );
	}

	public function filtering() {
		return new Filtering\Model\Meta( $this );

	}

}