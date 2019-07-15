<?php

namespace ACP\Column;

use AC;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Settings;
use ACP\Sorting;

/**
 * @since 4.0
 */
class CustomField extends AC\Column\CustomField
	implements Sorting\Sortable, Editing\Editable, Filtering\Filterable, Export\Exportable {

	/**
	 * @return Sorting\Model\Meta
	 */
	public function sorting() {
		return $this->get_model( 'ACP\Sorting\Model\CustomField' );
	}

	/**
	 * @return Editing\Model\Meta
	 */
	public function editing() {
		return $this->get_model( 'ACP\Editing\Model\CustomField', false );
	}

	/**
	 * @return Filtering\Model\Meta
	 */
	public function filtering() {
		return $this->get_model( 'ACP\Filtering\Model\CustomField' );
	}

	/**
	 * @return Export\Model\CustomField
	 */
	public function export() {
		return $this->get_model( 'ACP\Export\Model\CustomField' );
	}

	/**
	 * Settings
	 */
	public function register_settings() {
		$this->add_setting( new Settings\Column\CustomField( $this ) );
		$this->add_setting( new AC\Settings\Column\BeforeAfter( $this ) );
	}

	/**
	 * Get the correct class for this meta field
	 *
	 * @param      $class_prefix
	 * @param bool $use_fallback
	 *
	 * @return Sorting\Model\Meta|Editing\Model\Meta|Filtering\Model\Meta|Export\Model\CustomField|false
	 */
	private function get_model( $class_prefix, $use_fallback = true ) {

		switch ( $this->get_field_type() ) {
			case '' :
				$class_name = $class_prefix;

				break;

			case 'array' :
				// 'Array' is a PHP 7.2 reserved class name
				$class_name = $class_prefix . '\\MultipleValues';

				break;

			case 'numeric' :

				// 'Numeric' is a PHP 7.2 reserved class name
				$class_name = $class_prefix . '\\Number';

				break;

			default :

				// convert field type to a model class name
				$class_name = $class_prefix . "\\" . implode( array_map( 'ucfirst', explode( '_', str_replace( '-', '_', $this->get_field_type() ) ) ) );
		}

		if ( ! class_exists( $class_name ) ) {
			if ( $use_fallback ) {
				$class_name = $class_prefix;
			} else {
				$class_name = str_replace( '\\CustomField', '', $class_prefix ) . '\\Disabled';
			}
		}

		return new $class_name( $this );
	}

}