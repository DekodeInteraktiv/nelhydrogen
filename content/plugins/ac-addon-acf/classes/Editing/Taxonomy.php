<?php

namespace ACA\ACF\Editing;

use ACA\ACF\API;
use ACA\ACF\Editing;

class Taxonomy extends Editing {

	public function get_view_settings() {
		$data = parent::get_view_settings();

		$data['type'] = 'select2_dropdown';
		$data['ajax_populate'] = true;
		$data['store_values'] = false;

		switch ( $this->column->get_acf_field_option( 'field_type' ) ) {
			case 'checkbox' :
			case 'multi_select' :
				$data['multiple'] = true;
				break;
		}

		return $data;
	}

	private function get_taxonomy() {
		return $this->column->get_acf_field_option( 'taxonomy' );
	}

	public function get_ajax_options( $request ) {

		// ACF Free
		if ( API::is_free() ) {
			return acp_editing_helper()->get_terms_list( array(
				'taxonomy' => $this->get_taxonomy(),
				'search'   => $request['search'],
				'paged'    => $request['paged'],
			) );
		}

		// ACF Pro
		$acf_field = new \acf_field_taxonomy();

		return $this->format_choices( $acf_field->get_ajax_query( array(
			'taxonomy'  => $this->get_taxonomy(),
			's'         => $request['search'],
			'paged'     => $request['paged'],
			'field_key' => $this->column->get_field_hash(),
		) ) );
	}

	protected function format_choices( $choices ) {
		$options = array();

		foreach ( $choices['results'] as $choice ) {
			$options[ $choice['id'] ] = htmlspecialchars_decode( $choice['text'] );
		}

		return $options;
	}

	public function get_edit_value( $term_id ) {
		$term_ids = parent::get_edit_value( $term_id );

		$taxonomy = $this->get_taxonomy();

		$values = array();
		foreach ( ac_helper()->taxonomy->get_terms_by_ids( $term_ids, $taxonomy ) as $term ) {
			$values[ $term->term_id ] = $term->name;
		}

		return $values;
	}

}