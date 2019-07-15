<?php

namespace ACP\Sorting;

use ACP;

abstract class Strategy extends ACP\Strategy {

	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * @param Model $model
	 */
	public function __construct( Model $model ) {
		$this->model = $model;
	}

	/**
	 * @return Model
	 */
	public function get_model() {
		return $this->model;
	}

	/**
	 * Return the current sorting order
	 * @return string ASC|DESC
	 */
	abstract public function get_order();

	/**
	 * Uniform way to query results
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	abstract public function get_results( array $data = array() );

	abstract public function manage_sorting();

	/**
	 * Add the meta query for sorting to an existing meta query
	 *
	 * @param array $sorting_meta_query
	 * @param array $meta_query
	 *
	 * @return array
	 */
	protected function add_meta_query( $sorting_meta_query, $meta_query ) {
		if ( empty( $meta_query ) ) {
			return $sorting_meta_query;
		}

		$meta_query['relation'] = 'AND';
		$meta_query[] = $sorting_meta_query;

		return $meta_query;
	}

	/**
	 * Check if a key is an universal id
	 *
	 * @param string $key
	 *
	 * @return string
	 */
	protected function is_universal_id( $key ) {
		return 'ids' === $key;
	}

}