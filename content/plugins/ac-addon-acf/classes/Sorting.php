<?php

namespace ACA\ACF;

use ACP;

/**
 * @property Column $column
 */
class Sorting extends ACP\Sorting\Model\Meta {

	public function __construct( Column $column ) {
		parent::__construct( $column );
	}

}