<?php

namespace ACP\Column\Post;

use AC;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
class BeforeMoreTag extends AC\Column\Post\BeforeMoreTag
	implements Filtering\Filterable, Sorting\Sortable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\BeforeMoreTag( $this );
	}

	public function export() {
		return new Export\Model\StrippedValue( $this );
	}

}