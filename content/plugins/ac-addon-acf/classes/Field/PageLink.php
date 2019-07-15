<?php

namespace ACA\ACF\Field;

use ACA\ACF\Editing;
use ACP;

class PageLink extends PostObject {

	public function editing() {
		return new Editing\PageLink( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model\Value( $this->column );
	}

}