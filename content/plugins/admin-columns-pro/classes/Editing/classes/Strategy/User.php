<?php

namespace ACP\Editing\Strategy;

use ACP\Editing\Strategy;

class User extends Strategy {

	public function get_rows() {
		global $wp_list_table;

		return $this->get_editable_rows( $wp_list_table->items );
	}

	/**
	 * @param \WP_User|int $user
	 *
	 * @return bool|int
	 */
	public function user_has_write_permission( $user ) {
		if ( ! is_a( $user, 'WP_User' ) ) {
			$user = get_userdata( $user );
		}

		if ( ! $user ) {
			return false;
		}

		if ( ! current_user_can( 'edit_user', $user->ID ) ) {
			return false;
		}

		return $user->ID;
	}

	/**
	 * @since 4.0
	 *
	 * @param int   $id
	 * @param array $args
	 *
	 * @return int|\WP_Error
	 */
	public function update( $id, $args ) {
		$args['ID'] = $id;

		/** @var object $args suppresses wrong doc block of wp_update_user */
		return wp_update_user( $args );
	}

}