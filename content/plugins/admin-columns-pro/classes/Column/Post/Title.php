<?php

namespace ACP\Column\Post;

use AC;
use ACP\Editing;
use ACP\Export;

/**
 * @since 4.0
 */
class Title extends AC\Column\Post\Title
	implements Editing\Editable, Export\Exportable {

	public function editing() {
		return new Editing\Model\Post\Title( $this );
	}

	public function export() {
		return new Export\Model\Post\Title( $this );
	}

}