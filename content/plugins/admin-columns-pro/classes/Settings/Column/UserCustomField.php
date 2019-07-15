<?php

namespace ACP\Settings\Column;

class UserCustomField extends CustomField {

	protected function get_post_type() {
		return false;
	}

	protected function get_meta_type() {
		return 'user';
	}

}