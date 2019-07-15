<?php

namespace ACP\Sorting\Model\User;

use ACP\Sorting\Model;
use WP_User_Query;

class PostCount extends Model {

	public function get_sorting_vars() {
		add_action( 'pre_user_query', array( $this, 'pre_user_query_callback' ) );

		return array();
	}

	/**
	 * @param WP_User_Query $query
	 */
	public function pre_user_query_callback( WP_User_Query $query ) {
		global $wpdb;

		$order = $this->get_order();
		$join_type = acp_sorting()->show_all_results() ? 'LEFT' : 'INNER';

		$where = ' AND p.post_status = "publish" AND ( p.post_type = %s';

		if ( acp_sorting()->show_all_results() ) {
			$where .= ' OR p.post_type IS NULL';
		}

		$where .= ' )';

		$post_type_setting = $this->column->get_setting( 'post_type' );
		$post_type = $post_type_setting ? $post_type_setting->get_value() : 'post';

		$query->query_fields .= ", COUNT( p.post_author ) AS n";
		$query->query_from .= " $join_type JOIN {$wpdb->posts} AS p ON p.post_author = {$wpdb->users}.ID";
		$query->query_where .= $wpdb->prepare( $where, $post_type );
		$query->query_orderby = "
			GROUP BY {$wpdb->users}.ID
			ORDER BY n $order, {$wpdb->users}.ID $order
		";

		remove_action( 'pre_user_query', array( $this, __FUNCTION__ ) );
	}

}