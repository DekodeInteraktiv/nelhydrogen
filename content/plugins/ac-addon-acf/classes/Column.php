<?php

namespace ACA\ACF;

use AC;
use ACP;

/**
 * ACF Field for Advanced Custom Fields
 *
 * @since 1.1
 * @abstract
 */
abstract class Column extends AC\Column\Meta
	implements ACP\Editing\Editable, ACP\Filtering\Filterable, ACP\Sorting\Sortable, ACP\Export\Exportable, AC\Column\AjaxValue {

	public function __construct() {
		$this
			->set_type( 'column-acf_field' )
			->set_label( __( 'Advanced Custom Fields', 'codepress-admin-columns' ) )
			->set_group( 'acf' );
	}

	public function get_meta_key() {
		return $this->get_field()->get( 'name' );
	}

	public function get_ajax_value( $id ) {
		return $this->get_field()->get_ajax_value( $id );
	}

	public function get_value( $id ) {
		$value = $this->get_field()->get_value( $id );

		if ( $value instanceof AC\Collection ) {
			$value = $value->filter()->implode( $this->get_separator() );
		}

		// Wrap in ACF Append Prepend
		if ( $value ) {
			$prepend = $this->get_field()->get( 'prepend' );
			$append = $this->get_field()->get( 'append' );

			// remove &nbsp; characters
			$prepend = str_replace( chr( 194 ) . chr( 160 ), ' ', $prepend );
			$append = str_replace( chr( 194 ) . chr( 160 ), ' ', $append );

			$value = $prepend . $value . $append;
		}

		return $value;
	}

	public function get_raw_value( $id ) {
		return $this->get_field()->get_raw_value( $id );
	}

	/**
	 * @param string $type Comment, Post, Taxonomy, User or Media
	 */
	protected function register_settings_by_type( $type ) {
		$class = 'ACA\ACF\Setting\Field\\' . $type;

		// Free version specific
		if ( API::is_free() ) {
			$free_class = 'ACA\ACF\Free\Setting\Field\\' . $type;

			if ( class_exists( $free_class ) ) {
				$class = $free_class;
			}
		}

		if ( class_exists( $class ) ) {

			/* @var Setting\Field $setting */
			$setting = new $class( $this );

			$this->add_setting( $setting );
		}
	}

	public function editing() {
		return $this->get_field()->editing();
	}

	public function filtering() {
		return $this->get_field()->filtering();
	}

	public function sorting() {
		return $this->get_field()->sorting();
	}

	public function export() {
		return $this->get_field()->export();
	}

	/**
	 * @return array|false ACF Field settings
	 */
	public function get_acf_field() {
		return API::get_field( $this->get_field_hash() );
	}

	/**
	 * @param string $property
	 *
	 * @return string|array|false
	 */
	public function get_acf_field_option( $property ) {
		$field = $this->get_acf_field();

		return $field && isset( $field[ $property ] ) ? $field[ $property ] : false;
	}

	/**
	 * @return Field
	 */
	public function get_field() {
		return $this->get_field_by_type( $this->get_acf_field_option( 'type' ) );
	}

	/**
	 * Returns Field. By default it will return a Pro version Field, but when available this returns a Free version Field.
	 *
	 * @param string $type ACF field type
	 *
	 * @return Field|false
	 */
	public function get_field_by_type( $field_type ) {
		if ( empty( $field_type ) ) {
			return new Field( $this );
		}

		// Convert field type to field class name
		$field_class_name = implode( array_map( 'ucfirst', explode( '_', str_replace( '-', '_', $field_type ) ) ) );

		if ( API::is_free() ) {

			// Free version specific
			$type = 'ACA\ACF\Free\Field\\' . $field_class_name;

			if ( class_exists( $type ) ) {
				return new $type( $this );
			}
		}

		// Specific field types
		$type = 'ACA\ACF\Field\\' . $field_class_name;

		if ( class_exists( $type ) ) {
			return new $type( $this );
		}

		return new Field\Unsupported( $this );
	}

	/**
	 * Get Field hash
	 *
	 * @since 1.1
	 *
	 * @return string ACF field Hash (key)
	 */
	public function get_field_hash() {
		if ( ! $this->get_setting( 'field' ) ) {
			return false;
		}

		return $this->get_setting( 'field' )->get_value();
	}

	/**
	 * Get formatted ID for ACF
	 *
	 * @since 1.2.2
	 */
	public abstract function get_formatted_id( $id );

}