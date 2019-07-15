<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Sorting;

class Slug extends AC\Column\Post\Slug
	implements Sorting\Sortable, Editing\Editable {

	public function sorting() {
		$model = new Sorting\Model\Post\Field( $this );
		$model->set_field( 'post_name' );

		return $model;
	}

	public function editing() {
		return new Editing\Model\Post\Slug( $this );
	}

}