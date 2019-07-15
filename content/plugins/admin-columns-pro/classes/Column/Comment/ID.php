<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Sorting;

/**
 * @since 2.0
 */
class ID extends AC\Column\Comment\ID
	implements Sorting\Sortable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'comment_ID' );

		return $model;
	}

}