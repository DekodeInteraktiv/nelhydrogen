<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Export;
use ACP\Filtering;

/**
 * @since 4.0
 */
class Author extends AC\Column\Comment\Author
	implements Filtering\Filterable, Export\Exportable {

	public function filtering() {
		return new Filtering\Model\Comment\Author( $this );
	}

	public function export() {
		return new Export\Model\Comment\Author( $this );
	}

}