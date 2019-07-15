<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Export;

/**
 * @since 4.1
 */
class Post extends AC\Column\Comment\Post
	implements Export\Exportable {

	public function export() {
		return new Export\Model\StrippedValue( $this );
	}

}