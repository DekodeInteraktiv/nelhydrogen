<?php

namespace ACP\Column\Post;

use AC;
use ACP\Filtering;
use ACP\Sorting;

class ID extends AC\Column\Post\ID
	implements Sorting\Sortable, Filtering\Filterable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'ID' );

		return $model;
	}

	public function filtering() {
		return new Filtering\Model\Post\ID( $this );
	}

}