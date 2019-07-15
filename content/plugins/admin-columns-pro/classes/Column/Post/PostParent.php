<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 2.0
 */
class PostParent extends AC\Column\Post\PostParent
	implements Sorting\Sortable, Editing\Editable, Filtering\Filterable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model\Post\PostParent( $this );
	}

	public function editing() {
		return new Editing\Model\Post\PostParent( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\PostParent( $this );
	}

	public function export() {
		return new Export\Model\PostTitleFromPostId( $this );
	}

}