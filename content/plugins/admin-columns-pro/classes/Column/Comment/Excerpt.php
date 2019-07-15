<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Editing;
use ACP\Sorting;

/**
 * @since 4.0
 */
class Excerpt extends AC\Column\Comment\Excerpt
	implements Editing\Editable, Sorting\Sortable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'comment_content' );

		return $model;
	}

	public function editing() {
		return new Editing\Model\Comment\Excerpt( $this );
	}

}