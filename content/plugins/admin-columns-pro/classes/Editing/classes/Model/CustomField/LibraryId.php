<?php

namespace ACP\Editing\Model\CustomField;

use ACP\Editing\Model;

class LibraryId extends Model\CustomField {

	public function get_view_settings() {
		return array(
			'type'         => 'attachment',
			'clear_button' => true,
		);
	}

}