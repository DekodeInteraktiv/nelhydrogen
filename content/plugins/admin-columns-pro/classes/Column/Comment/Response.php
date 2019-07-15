<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Response extends AC\Column\Comment\Response
	implements Filtering\Filterable, Sorting\Sortable, Export\Exportable {

	public function filtering() {
		return new Filtering\Model\Comment\Response( $this );
	}

	public function sorting() {
		return new Sorting\Model\Comment\Response( $this );
	}

	public function export() {
		return new Export\Model\Comment\Response( $this );
	}

}