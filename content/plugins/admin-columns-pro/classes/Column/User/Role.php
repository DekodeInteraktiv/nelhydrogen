<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Role extends AC\Column\User\Role
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model\User\Roles( $this );
	}

	public function editing() {
		return new Editing\Model\User\Role( $this );
	}

	public function filtering() {
		return new Filtering\Model\User\Role( $this );
	}

	public function export() {
		return new Export\Model\User\Role( $this );
	}

}