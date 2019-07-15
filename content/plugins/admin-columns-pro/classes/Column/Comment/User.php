<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

/**
 * @since 4.0
 */
class User extends AC\Column\Comment\User
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable, Export\Exportable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'user_id' );

		return $model;
	}

	public function editing() {
		return new Editing\Model\Comment\User( $this );
	}

	public function filtering() {
		return new Filtering\Model\Comment\User( $this );
	}

	public function export() {
		return new Export\Model\StrippedValue( $this );
	}

}