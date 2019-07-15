<?php

namespace ACP\Column\Media;

use AC;
use ACP\Sorting;

class ID extends AC\Column\Media\ID
	implements Sorting\Sortable {

	public function sorting() {
		$model = new Sorting\Model( $this );
		$model->set_orderby( 'ID' );

		return $model;
	}

}