<?php

namespace ACP\Column\Media;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;

/**
 * @since 4.0
 */
class Date extends AC\Column\Media\Date
	implements Filtering\Filterable, Editing\Editable, Export\Exportable {

	public function editing() {
		return new Editing\Model\Media\Date( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\Date( $this );
	}

	public function export() {
		return new Export\Model\Post\Date( $this );
	}

}