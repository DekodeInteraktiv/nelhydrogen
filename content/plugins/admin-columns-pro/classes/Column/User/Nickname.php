<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Sorting;

/**
 * @since 2.0
 */
class Nickname extends AC\Column\User\Nickname
	implements Editing\Editable, Sorting\Sortable {

	public function sorting() {
		return new Sorting\Model\Meta( $this );
	}

	public function editing() {
		return new Editing\Model\Meta( $this );
	}

}