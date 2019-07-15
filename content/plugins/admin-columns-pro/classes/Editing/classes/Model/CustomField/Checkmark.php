<?php

namespace ACP\Editing\Model\CustomField;

use ACP\Editing\Model;

class Checkmark extends Model\CustomField {

	public function get_view_settings() {
		return array(
			'type'    => 'togglable',
			'options' => array( '0', '1' ),
		);
	}

}