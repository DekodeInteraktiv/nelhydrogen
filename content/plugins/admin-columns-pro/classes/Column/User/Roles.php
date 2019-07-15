<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;
use WP_User;

class Roles extends AC\Column\Meta
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable, Export\Exportable {

	public function __construct() {
		$this->set_type( 'column-roles' );
		$this->set_label( __( 'Roles', 'codepress-admin-columns' ) );
	}

	public function get_meta_key() {
		global $wpdb;

		return $wpdb->get_blog_prefix() . 'capabilities'; // WPMU compatible
	}

	// Display

	public function get_value( $user_id ) {
		$user = new WP_User( $user_id );

		$roles = array();
		foreach ( ac_helper()->user->translate_roles( $user->roles ) as $role => $label ) {
			$roles[] = ac_helper()->html->tooltip( $label, $role );
		}

		if ( empty( $roles ) ) {
			return $this->get_empty_char();
		}

		return implode( $this->get_separator(), $roles );
	}

	public function editing() {
		return new Editing\Model\User\Role( $this );
	}

	public function sorting() {
		return new Sorting\Model\User\Roles( $this );
	}

	public function filtering() {
		return new Filtering\Model\User\Role( $this );
	}

	public function export() {
		return new Export\Model\User\Role( $this );
	}

}