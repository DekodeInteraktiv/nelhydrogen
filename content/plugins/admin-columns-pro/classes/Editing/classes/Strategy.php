<?php

namespace ACP\Editing;

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
	 * Get the available items on the current page for passing them to JS
	 * @since 1.0
	 * @return array Items on the current page ([entry_id] => (array) [entry_data])
	 */
	abstract public function get_rows();

	/**
	 * @since 4.0
	 *
	 * @param $object_id
	 *
	 * @return bool True when user can edit object.
	 */
	abstract public function user_has_write_permission( $object_id );

	/**
	 * @param int   $object_id
	 * @param array $args
	 *
	 * @return mixed
	 */
	abstract public function update( $object_id, $args );

	/**
	 * Get table items that the user can edit
	 *
	 * @param array $items
	 *
	 * @return int[]
	 */
	protected function get_editable_rows( $items ) {
		$ids = array();

		if ( $items ) {
			foreach ( $items as $object ) {
				if ( $id = $this->user_has_write_permission( $object ) ) {
					$ids[] = $id;
				}
			}
		}

		return $ids;
	}

}