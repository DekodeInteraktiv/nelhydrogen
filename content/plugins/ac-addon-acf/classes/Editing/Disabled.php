<?php

namespace ACA\ACF\Editing;

use ACP;

class Disabled extends ACP\Editing\Model {

	public function is_active() {
		return false;
	}

	public function register_settings() {
	}

}