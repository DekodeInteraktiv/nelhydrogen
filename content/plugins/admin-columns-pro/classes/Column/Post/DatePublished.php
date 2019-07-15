<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 2.4
 */
class DatePublished extends AC\Column\Post\DatePublished
	implements Sorting\Sortable, Filtering\Filterable, Editing\Editable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'date' );

		return $model;
	}

	public function filtering() {
		return new Filtering\Model\Post\Date( $this );
	}

	public function editing() {
		return new Editing\Model\Post\Date( $this );
	}

}