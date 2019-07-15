<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Author extends AC\Column\Post\Author
	implements Editing\Editable, Sorting\Sortable, Export\Exportable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'author' );

		return $model;
	}

	public function editing() {
		return new Editing\Model\Post\Author( $this );
	}

	public function export() {
		return new Export\Model\Post\Author( $this );
	}

}