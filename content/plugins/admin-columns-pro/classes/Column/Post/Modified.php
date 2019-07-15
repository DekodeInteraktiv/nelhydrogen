<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

class Modified extends AC\Column\Post\Modified
	implements Sorting\Sortable, Editing\Editable, Filtering\Filterable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'modified' );

		return $model;
	}

	public function editing() {
		return new Editing\Model\Post\Modified( $this );
	}

	public function filtering() {
		return new Filtering\Model\Post\Modified( $this );
	}

}