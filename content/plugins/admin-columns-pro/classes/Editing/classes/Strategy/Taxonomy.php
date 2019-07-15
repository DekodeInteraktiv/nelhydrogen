<?php

namespace ACP\Editing\Strategy;

use ACP\Editing\Strategy;
use DOMDocument;
use DOMXPath;

class Taxonomy extends Strategy {

	public function get_rows() {
		return $this->get_editable_rows( $this->get_term_ids_from_dom() );
	}

	/**
	 * @return int[]|false
	 */
	private function get_term_ids_from_dom() {
		if ( ! class_exists( '\DOMDocument' ) ) {
			return array();
		}

		global $wp_list_table;

		/* @var \WP_Terms_List_Table $wp_list_table */

		ob_start();
		$wp_list_table->display_rows_or_placeholder();

		$html = ob_get_clean();

		// In version 4.7.3 it it's impossible to get the terms from the current table.
		// All the logic is in display_rows_or_placeholder().
		// By fetching the rows HTML we can parse out the needed term ID's with DOMDocument

		if ( ! $html ) {
			return false;
		}

		$doc = new DOMDocument();

		$doc->loadHTML( $html );
		$xpath = new DOMXPath( $doc );

		$query = "//input[@type='checkbox']";

		$term_ids = array();

		$node_list = $xpath->query( $query );

		if ( $node_list->length > 0 ) {
			foreach ( $node_list as $dom_element ) {

				/* @var \DOMElement $dom_element */
				$term_ids[] = $dom_element->getAttribute( "value" );
			}
		}

		return $term_ids;
	}

	/**
	 * @param \WP_Term|int $term
	 *
	 * @return bool|int
	 */
	public function user_has_write_permission( $term ) {
		if ( ! current_user_can( 'manage_categories' ) ) {
			return false;
		}

		if ( ! is_a( $term, 'WP_Term' ) ) {
			$term = get_term_by( 'id', $term, $this->get_column()->get_taxonomy() );
		}

		if ( ! $term || is_wp_error( $term ) ) {
			return false;
		}

		return $term->term_id;
	}

	/**
	 * @since 4.0
	 *
	 * @param $id
	 * @param $args
	 *
	 * @return array|\WP_Error
	 */
	public function update( $id, $args ) {
		return wp_update_term( $id, $this->get_column()->get_taxonomy(), $args );
	}

}