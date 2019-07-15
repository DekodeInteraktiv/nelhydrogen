<?php

namespace ACP\Sorting\Model\Post;

use ACP\Sorting\Model;

class Field extends Model {

	/**
	 * @param string $field Database field name
	 */
	private $field;

	/**
	 * @param string $field
	 */
	public function set_field( $field ) {
		$this->field = sanitize_key( $field );
	}

	/**
	 * @return array
	 */
	public function get_sorting_vars() {
		add_filter( 'posts_fields', array( $this, 'posts_fields_callback' ) );

		$args = array(
			'suppress_filters' => false,
			'fields'           => array(),
		);

		$ids = array();

		foreach ( $this->strategy->get_results( $args ) as $object ) {
			$ids[ $object->id ] = $this->format( $object->value );

			wp_cache_delete( $object->id, 'posts' );
		}

		return array(
			'ids' => $this->sort( $ids ),
		);
	}

	/**
	 * @param string $value
	 *
	 * @return string
	 */
	protected function format( $value ) {
		return $value;
	}

	/**
	 * Only return fields required for sorting
	 * @global \wpdb $wpdb
	 * @return string
	 */
	public function posts_fields_callback() {
		global $wpdb;

		remove_filter( 'posts_fields', array( $this, __FUNCTION__ ) );

		return "$wpdb->posts.ID AS id, $wpdb->posts.`" . esc_sql( $this->field ) . '` AS value';
	}

}