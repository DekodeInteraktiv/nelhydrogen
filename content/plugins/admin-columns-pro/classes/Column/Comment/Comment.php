<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Comment extends AC\Column\Comment\Comment
	implements Editing\Editable, Sorting\Sortable, Export\Exportable {

	public function editing() {
		return new Editing\Model\Comment\Comment( $this );
	}

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'comment_content' );

		return $model;
	}

	public function export() {
		return new Export\Model\Comment\Comment( $this );
	}

}