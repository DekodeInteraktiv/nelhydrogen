<?php

namespace ACP\Sorting\Model\Post;

use ACP\Sorting\Model;

class PostParent extends Model {

	public function get_sorting_vars() {
		add_filter( 'posts_clauses', array( $this, 'sorting_clauses_callback' ) );

		return array(
			'suppress_filters' => false,
		);
	}

	/**
	 * Setup clauses to sort by parent
	 * @since 4.0
	 *
	 * @param array $clauses array
	 *
	 * @return array
	 */
	public function sorting_clauses_callback( $clauses ) {
		global $wpdb;

		$order = esc_sql( $this->get_order() );
		$join_type = acp_sorting()->show_all_results() ? 'LEFT' : 'INNER';

		$clauses['join'] .= "$join_type JOIN $wpdb->posts AS pp ON $wpdb->posts.post_parent = pp.ID";
		$clauses['orderby'] = "pp.post_title $order, $wpdb->posts.ID $order";

		// run once
		remove_filter( 'posts_clauses', array( $this, __FUNCTION__ ) );

		return $clauses;
	}

}