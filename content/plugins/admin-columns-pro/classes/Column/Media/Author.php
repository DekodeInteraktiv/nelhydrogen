<?php

namespace ACP\Column\Media;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;

/**
 * @since 4.0
 */
class Author extends AC\Column\Media\Author
	implements Editing\Editable, Filtering\Filterable, Export\Exportable {

	public function filtering() {
		return new Filtering\Model\Media\Author( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Author( $this );
	}

	public function export() {
		return new Export\Model\Post\Author( $this );
	}

}