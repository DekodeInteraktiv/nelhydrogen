<?php

namespace ACA\ACF;

use ACP;

/**
 * @property Column $column
 */
class Editing extends ACP\Editing\Model {

	public function __construct( Column $column ) {
		parent::__construct( $column );
	}

	public function get_view_settings() {
		$data = array(
			'type'         => 'text',
			'store_values' => true,
		);

		$field = $this->column->get_field();

		if ( $placeholder = $field->get( 'placeholder' ) ) {
			$data['placeholder'] = $placeholder;
		}

		$min = $field->get( 'min' );
		if ( is_numeric( $min ) ) {
			$data['range_min'] = $min;
		}

		$max = $field->get( 'max' );
		if ( is_numeric( $max ) ) {
			$data['range_max'] = $max;
		}

		if ( $step = $field->get( 'step' ) ) {
			$data['range_step'] = $step;
		}
		if ( $required = $field->get( 'required' ) ) {
			$data['required'] = $required;
		}
		if ( $maxlength = $field->get( 'maxlength' ) ) {
			$data['maxlength'] = $maxlength;
		}
		if ( 'uploadedTo' == $field->get( 'library' ) ) {
			$editable['attachment']['library']['uploaded_to_post'] = true;
		}
		if ( $field->get( 'multiple' ) ) {
			$data['multiple'] = true;
		}

		return $data;
	}

	/**
	 * @param mixed $value
	 *
	 * @return true|\WP_Error
	 */
	protected function validate( $value ) {
		$field = $this->column->get_acf_field();
		$input = sprintf( 'acf[%s]', $field['key'] );

		if ( ! acf_validate_value( $value, $field, $input ) ) {
			$error = acf()->validation->get_error( $input );

			if ( $error ) {
				return new \WP_Error( 'not-validated', $error['message'] );
			}
		}

		return true;
	}

	public function save( $id, $value ) {
		if ( ! API::is_free() ) {
			$valid = $this->validate( $value );

			if ( is_wp_error( $valid ) ) {
				return $valid;
			}
		}

		return update_field( $this->column->get_field_hash(), $value, $this->column->get_formatted_id( $id ) );
	}

	public function get_edit_value( $id ) {
		$value = parent::get_edit_value( $id );

		// null will disable editing
		if ( null === $value ) {
			return false;
		}

		return $value;
	}

	/**
	 * @param array $ajax_query ACF ajax query [ 'results' => array() ]
	 *
	 * @return array
	 */
	protected function format_choices( $ajax_query ) {
		$options = array();

		if ( empty( $ajax_query['results'] ) ) {
			return array();
		}

		foreach ( $ajax_query['results'] as $choice ) {
			if ( ! isset( $choice['id'] ) ) {
				$options[ $choice['text'] ] = array(
					'label'   => $choice['text'],
					'options' => array(),
				);

				foreach ( $choice['children'] as $subchoice ) {
					$options[ $choice['text'] ]['options'][ $subchoice['id'] ] = htmlspecialchars_decode( $subchoice['text'] );
				}
			} else {
				$options[ $choice['id'] ] = htmlspecialchars_decode( $choice['text'] );
			}
		}

		return $options;
	}

}