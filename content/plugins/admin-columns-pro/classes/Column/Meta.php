<?php

namespace ACP\Column;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
abstract class Meta extends AC\Column\Meta
	implements Sorting\Sortable, Editing\Editable, Filtering\Filterable {

	/**
	 * @return Sorting\Model\Meta
	 */
	public function sorting() {
		return new Sorting\Model\Meta( $this );
	}

	/**
	 * @return Editing\Model\Meta
	 */
	public function editing() {
		return new Editing\Model\Meta( $this );
	}

	/**
	 * @return Filtering\Model\Meta
	 */
	public function filtering() {
		return new Filtering\Model\Meta( $this );
	}

}