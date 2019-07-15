<?php

namespace ACP\Column\Media;

use AC;
use ACP\Export;
use ACP\Filtering;

/**
 * @since 4.0
 */
class MediaParent extends AC\Column\Media\MediaParent
	implements Filtering\Filterable, Export\Exportable {

	public function filtering() {
		return new Filtering\Model\Post\PostParent( $this );
	}

	public function export() {
		return new Export\Model\Post\PostParent( $this );
	}

}