<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Export;
use ACP\Filtering;

/**
 * @since 4.0
 */
class Date extends AC\Column\Comment\Date
	implements Filtering\Filterable, Export\Exportable {

	public function filtering() {
		return new Filtering\Model\Comment\Date( $this );
	}

	public function export() {
		return new Export\Model\Comment\Date( $this );
	}

}