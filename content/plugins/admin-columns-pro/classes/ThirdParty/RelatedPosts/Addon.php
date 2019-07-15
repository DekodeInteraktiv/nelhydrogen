<?php

namespace ACP\ThirdParty\RelatedPosts;

use AC;

final class Addon {

	public function __construct() {
		add_action( 'ac/column_types', array( $this, 'set_columns' ) );
		add_action( 'ac/column_groups', array( $this, 'set_groups' ) );
	}

	/**
	 * @param AC\ListScreen $list_screen
	 */
	public function set_columns( $list_screen ) {
		if ( ! function_exists( 'RP4WP' ) ) {
			return;
		}

		$list_screen->register_column_type( new Column );
	}

	/**
	 * @param AC\Groups $groups
	 */
	public function set_groups( $groups ) {
		$groups->register_group( 'related-posts', __( 'Related Posts', 'codepress-admin-columns' ), 25 );
	}

}