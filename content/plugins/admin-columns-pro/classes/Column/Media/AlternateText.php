<?php

namespace ACP\Column\Media;

use AC;
use ACP\Editing;
use ACP\Sorting;

class AlternateText extends AC\Column\Media\AlternateText
	implements Editing\Editable, Sorting\Sortable {

	public function sorting() {
		return new Sorting\Model( $this );
	}

	public function editing() {
		return new Editing\Model\Media\AlternateText( $this );
	}

}