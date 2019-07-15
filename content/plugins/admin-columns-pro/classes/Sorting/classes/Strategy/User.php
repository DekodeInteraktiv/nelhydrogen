<?php

namespace ACP\Sorting\Strategy;

use ACP\Sorting\Strategy;
use WP_User_Query;

final class User extends Strategy {

	/**
	 * @var WP_User_Query
	 */
	private $user_query;

	public function manage_sorting() {
		add_action( 'pre_get_users', array( $this, 'handle_sorting_request' ) );
	}

	/**
	 * @param array $args
	 *
	 * @return array
	 */
	public function get_results( array $args = array() ) {
		return $this->get_users( $args );
	}

	/**
	 * @param array $args
	 *
	 * @return int[]
	 */
	protected function get_users( array $args = array() ) {
		$defaults = array(
			'fields' => 'ID',
		);

		$args = array_merge( $defaults, $args );

		$query = new WP_User_Query( $args );

		return (array) $query->get_results();
	}

	/**
	 * @return string
	 */
	public function get_order() {
		return $this->user_query->get( 'order' );
	}

	/**
	 * @param WP_User_Query $user_query
	 */
	private function set_user_query( WP_User_Query $user_query ) {
		$this->user_query = $user_query;
	}

	/**
	 * Handle the sorting request on the user listing screen
	 * @since 1.0
	 *
	 * @param WP_User_Query $query
	 *
	 * @return void
	 */
	public function handle_sorting_request( WP_User_Query $query ) {
		// check query conditions
		if ( ! $query->get( 'orderby' ) ) {
			return;
		}

		// run only once
		remove_action( 'pre_get_users', array( $this, __FUNCTION__ ) );

		$this->set_user_query( $query );

		foreach ( $this->model->get_sorting_vars() as $key => $value ) {
			if ( $this->is_universal_id( $key ) ) {
				$key = 'include';
			}

			if ( 'meta_query' === $key ) {
				$value = $this->add_meta_query( $value, $query->get( 'meta_query' ) );
			}

			$query->set( $key, $value );
		}

		// pre-sorting done with an array
		$include = $query->get( 'include' );

		if ( ! empty( $include ) ) {
			$query->set( 'orderby', 'include' );
			$query->set( 'order', 'ASC' ); // order as offered
		}
	}

}