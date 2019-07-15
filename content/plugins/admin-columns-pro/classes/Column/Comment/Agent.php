<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 2.0
 */
class Agent extends AC\Column\Comment\Agent
	implements Filtering\Filterable, Sorting\Sortable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'comment_agent' );

		return $model;
	}

	public function filtering() {
		return new Filtering\Model\Comment\Agent( $this );
	}

}