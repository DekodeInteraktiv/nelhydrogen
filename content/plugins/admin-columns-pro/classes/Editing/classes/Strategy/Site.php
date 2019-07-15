<?php

namespace ACP\Editing\Strategy;

use ACP\Editing\Strategy;

class Site extends Strategy {

	public function get_rows() {
		global $wp_list_table;

		return $this->get_editable_rows( $wp_list_table->items );
	}

	/**
	 * @param int|\WP_Site $site
	 *
	 * @return bool|int
	 */
	public function user_has_write_permission( $site ) {
		if ( ! current_user_can( 'manage_sites' ) ) {
			return false;
		}

		if ( ! is_a( $site, 'WP_Site' ) ) {
			$site = get_site( $site );
		}

		if ( ! $site ) {
			return false;
		}

		return $site->id;
	}

	/**
	 * @since 4.0
	 *
	 * @param $id
	 * @param $args
	 */
	public function update( $id, $args ) {
		update_blog_details( $id, $args );
	}

}