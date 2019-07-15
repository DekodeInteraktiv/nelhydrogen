<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

/**
 * Column displaying whether an item is open for comments, i.e. whether users can
 * comment on this item.
 * @since 2.0
 */
class CommentStatus extends AC\Column\Post\CommentStatus
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable {

	public function sorting() {
		return new Sorting\Model( $this );
	}

	public function editing() {
		return new Editing\Model\Post\CommentStatus( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\CommentStatus( $this );
	}

}