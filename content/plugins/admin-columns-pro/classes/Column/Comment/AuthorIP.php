<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
class AuthorIP extends AC\Column\Comment\AuthorIP
	implements Filtering\Filterable, Sorting\Sortable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'comment_author_IP' );

		return $model;
	}

	public function filtering() {
		return new Filtering\Model\Comment\AuthorIP( $this );
	}

}
