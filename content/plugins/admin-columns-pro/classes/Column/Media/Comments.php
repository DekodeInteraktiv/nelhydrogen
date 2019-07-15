<?php

namespace ACP\Column\Media;

use AC;
use ACP\Export;
use ACP\Filtering;

/**
 * @since 4.0
 */
class Comments extends AC\Column\Media\Comments
	implements Filtering\Filterable, Export\Exportable {

	public function filtering() {
		return new Filtering\Model\Media\Comments( $this );
	}

	public function export() {
		return new Export\Model\Post\Comments( $this );
	}

}