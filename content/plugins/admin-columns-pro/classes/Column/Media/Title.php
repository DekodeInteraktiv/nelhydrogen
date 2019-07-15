<?php

namespace ACP\Column\Media;

use AC;
use ACP\Editing;
use ACP\Export;

/**
 * @since 4.0
 */
class Title extends AC\Column\Media\Title
	implements Editing\Editable, Export\Exportable {

	public function editing() {
		return new Editing\Model\Media\Title( $this );
	}

	public function export() {
		return new Export\Model\Media\Title( $this );
	}

}