<?php

namespace ACP\Column\User;

use AC;
use ACP\Export;

/**
 * @since 4.1
 */
class Username extends AC\Column\User\Username
	implements Export\Exportable {

	public function export() {
		return new Export\Model\User\Username( $this );
	}

}