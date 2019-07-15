<?php

namespace ACP\Editing\Model;

use AC;
use ACP\Editing\Model;

class CustomField extends Model {

	/**
	 * @var AC\Column\CustomField
	 */
	protected $column;

	public function __construct( AC\Column\CustomField $column ) {
		parent::__construct( $column );
	}

	/**
	 * @param                   $id
	 *
	 * @return bool|mixed|null
	 */
	public function get_edit_value( $id ) {
		return $this->column->get_raw_value( $id );
	}

	/**
	 * @return array
	 */
	public function get_view_settings() {
		return array(
			'type' => 'text',
		);
	}

	/**
	 * @param                   $id
	 * @param                   $value
	 */
	public function save( $id, $value ) {
		update_metadata( $this->column->get_list_screen()->get_meta_type(), $id, $this->column->get_meta_key(), $value );
	}

	private function is_editing_enabled() {
		return '1' === AC()->admin()->get_general_option( 'custom_field_editable' );
	}

	public function register_settings() {
		if ( $this->is_editing_enabled() ) {

			// Settings
			parent::register_settings();
		} else {

			// Message
			$message = new AC\Settings\Column\Message( $this->column );
			$message
				->set_label( __( 'Inline Editing', 'codepress-admin-columns' ) )
				->set_message( sprintf( __( 'Inline Editing for Custom Fields is not enabled. Enable inline editing for Custom Fields on the %s.', 'codepress-admin-columns' ), ac_helper()->html->link( AC()->admin()->get_link( 'settings' ), __( 'settings screen', 'codepress-admin-columns' ) ) ) );

			$this->column->add_setting( $message );
		}
	}

}