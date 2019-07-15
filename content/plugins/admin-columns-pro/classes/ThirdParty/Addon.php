<?php

namespace ACP\ThirdParty;

use AC;

/**
 * @since 4.0
 */
class Addon {

	public function __construct() {

		// bbPress
		new bbPress\Addon();

		// Yoast SEO
		new YoastSeo\Addon();

		// Related Posts
		new RelatedPosts\Addon();

		// WooCommerce
		add_filter( 'acp/editing/post_statuses', array( $this, 'remove_woocommerce_statuses_for_editing' ), 10, 2 );

		// ACF
		add_filter( 'acp/editing/post_statuses', array( $this, 'remove_acf_statuses_for_editing' ) );
	}

	/**
	 * @param array     $statuses
	 * @param AC\Column $column
	 *
	 * @return array
	 */
	public function remove_woocommerce_statuses_for_editing( $statuses, $column ) {
		if ( function_exists( 'wc_get_order_statuses' ) && 'shop_order' !== $column->get_post_type() ) {
			$statuses = array_diff_key( $statuses, wc_get_order_statuses() );
		}

		return $statuses;
	}

	/**
	 * @param array $statuses
	 *
	 * @return array
	 */
	public function remove_acf_statuses_for_editing( $statuses ) {
		if ( isset( $statuses['acf-disabled'] ) ) {
			unset( $statuses['acf-disabled'] );
		}

		return $statuses;
	}

}