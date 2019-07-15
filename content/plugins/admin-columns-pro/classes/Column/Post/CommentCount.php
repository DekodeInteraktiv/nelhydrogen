<?php

namespace ACP\Column\Post;

use AC;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
class CommentCount extends AC\Column\Post\CommentCount
	implements Filtering\Filterable, Sorting\Sortable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model\Post\CommentCount( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\CommentCount( $this );
	}

	public function export() {
		return new Export\Model\Post\CommentCount( $this );
	}

}