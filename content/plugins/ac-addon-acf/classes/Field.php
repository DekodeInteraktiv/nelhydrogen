<?php

namespace ACA\ACF;

use AC;
use ACP;

class Field
	implements ACP\Filtering\Filterable, ACP\Editing\Editable, ACP\Sorting\Sortable {

	/**
	 * @var Column
	 */
	protected $column;

	/**
	 * @param Column $column
	 */
	public function __construct( Column $column ) {
		$this->column = $column;

		// ACF multiple data is stored serialized
		$this->column->set_serialized( $this->get( 'multiple' ) );
	}

	public function get_ajax_value( $id ) {
		return null;
	}

	public function get_value( $id ) {
		return $this->column->get_formatted_value( $this->get_raw_value( $id ), $id );
	}

	public function get_raw_value( $id ) {
		return get_field( $this->column->get_meta_key(), $this->column->get_formatted_id( $id ), false );
	}

	public function get_separator() {
		return $this->column->get_separator();
	}

	public function filtering() {
		return new ACP\Filtering\Model\Disabled( $this->column );
	}

	public function editing() {
		return new Editing\Disabled( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model\Disabled( $this->column );
	}

	public function export() {
		return new ACP\Export\Model\RawValue( $this->column );
	}

	/**
	 * @return AC\Settings\Column[]
	 */
	public function get_dependent_settings() {
		return array();
	}

	/**
	 * Get ACF field property
	 *
	 * @param string $property
	 *
	 * @return string|array|false
	 */
	public function get( $property ) {
		return $this->column->get_acf_field_option( $property );
	}

	/**
	 * Get link to field's group settings
	 *
	 * @return false|string
	 */
	public function get_edit_link() {
		return get_edit_post_link( acf_get_field_group_id( $this->get( 'parent' ) ) );
	}

}