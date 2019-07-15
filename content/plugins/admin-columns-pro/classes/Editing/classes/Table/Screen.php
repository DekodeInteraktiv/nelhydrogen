<?php

namespace ACP\Editing\Table;

use AC;
use ACP\Editing;

class Screen {

	/**
	 * @var array
	 */
	private $column_data = array();

	/**
	 * @var array
	 */
	private $item_data = array();

	/**
	 * @var AC\ListScreen
	 */
	private $list_screen;

	/**
	 * @var bool
	 */
	private $active;

	public function __construct( AC\ListScreen $list_screen, $active = false ) {
		$this->list_screen = $list_screen;
		$this->active = (bool) $active;
	}

	public function register() {
		add_action( 'ac/table_scripts', array( $this, 'scripts' ) );
		add_action( 'ac/table/actions', array( $this, 'edit_button' ) );
	}

	public function get_column_data() {
		return $this->column_data;
	}

	public function get_item_data() {
		return $this->item_data;
	}

	public function scripts() {

		$this->populate_column_data();
		$this->populate_item_data();

		if ( ! $this->column_data || ! $this->item_data ) {
			return;
		}

		$plugin_url = ACP()->editing()->get_url();
		$version = ACP()->editing()->get_version();

		// Libraries
		wp_register_script( 'acp-editing-bootstrap', $plugin_url . 'library/bootstrap/bootstrap.min.js', array( 'jquery' ), $version );
		wp_register_script( 'acp-editing-bootstrap-editable', $plugin_url . "library/bootstrap-editable/js/bootstrap-editable.min.js", array( 'jquery', 'acp-editing-bootstrap' ), $version );
		wp_register_style( 'acp-editing-bootstrap-editable', $plugin_url . 'library/bootstrap-editable/css/bootstrap-editable.css', array(), $version );

		// Main
		wp_register_script( 'acp-editing-table', $plugin_url . 'assets/js/table.js', array( 'jquery', 'acp-editing-bootstrap-editable' ), $version );
		wp_register_style( 'acp-editing-table', $plugin_url . 'assets/css/table.css', array(), $version );

		// Allow JS to access the column and item data for this list screen on the edit page
		wp_localize_script( 'acp-editing-table', 'ACP_Editing_Columns', $this->column_data );
		wp_localize_script( 'acp-editing-table', 'ACP_Editing_Items', $this->item_data );

		wp_localize_script( 'acp-editing-table', 'ACP_Editing', array(
			'inline_edit' => array(
				'persistent' => $this->persistent_editing(),
				'active'     => $this->active,
			),
			// Translations
			'i18n'        => array(
				'select_author' => __( 'Select author', 'codepress-admin-columns' ),
				'edit'          => __( 'Edit' ),
				'redo'          => __( 'Redo', 'codepress-admin-columns' ),
				'undo'          => __( 'Undo', 'codepress-admin-columns' ),
				'date'          => __( 'Date' ),
				'delete'        => __( 'Delete', 'codepress-admin-columns' ),
				'download'      => __( 'Download', 'codepress-admin-columns' ),
				'errors'        => array(
					'field_required' => __( 'This field is required.', 'codepress-admin-columns' ),
					'invalid_float'  => __( 'Please enter a valid float value.', 'codepress-admin-columns' ),
					'invalid_floats' => __( 'Please enter valid float values.', 'codepress-admin-columns' ),
				),
				'inline_edit'   => __( 'Inline Edit', 'codepress-admin-columns' ),
				'media'         => __( 'Media', 'codepress-admin-columns' ),
				'image'         => __( 'Image', 'codepress-admin-columns' ),
				'audio'         => __( 'Audio', 'codepress-admin-columns' ),
				'time'          => __( 'Time', 'codepress-admin-columns' ),
			),
		) );

		// jQuery
		wp_enqueue_script( 'jquery' );

		// Select2
		// Todo move to an asset manager since search also required select2
		wp_register_script( 'acp-select2-v3', $plugin_url . 'library/select2/select2.min.js', array( 'jquery' ), ACP()->get_version() );
		wp_register_style( 'acp-select2-v3-css', $plugin_url . 'library/select2/select2.css', array(), ACP()->get_version() );
		wp_register_style( 'acp-select2-v3-bootstrap', $plugin_url . 'library/select2/select2-bootstrap.css', array(), ACP()->get_version() );
		wp_enqueue_style( 'acp-select2-v3-css' );
		wp_enqueue_style( 'acp-select2-v3-bootstrap' );
		wp_enqueue_script( 'acp-select2-v3' );

		// Core
		wp_enqueue_script( 'acp-editing-table' );
		wp_enqueue_style( 'acp-editing-bootstrap-editable' );
		wp_enqueue_style( 'acp-editing-table' );

		// WP Media picker
		wp_enqueue_media();

		// WP Color picker
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );

		// Translations
		$locale = substr( get_locale(), 0, 2 );

		// Select 2 translations
		if ( file_exists( ACP()->editing()->get_dir() . 'library/select2/select2_locale_' . $locale . '.js' ) ) {
			wp_register_script( 'select2-locale', $plugin_url . 'library/select2/select2_locale_' . $locale . '.js', array( 'jquery' ), $version );
			wp_enqueue_script( 'select2-locale' );
		}

		do_action( 'ac/table_scripts/editing', $this->list_screen );
	}

	public function edit_button() {
		$this->populate_column_data();
		$this->populate_item_data();

		if ( ! $this->column_data || ! $this->item_data ) {
			return;
		}

		?>
		<label class="ac-table-button -toggle">
			<span class="ac-toggle">
				<input type="checkbox" value="1" id="acp-enable-editing">
				<span class="ac-toggle__switch">
					<svg class="ac-toggle__switch__on" width="2" height="6" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 6"><path fill="#fff" d="M0 0h2v6H0z"></path></svg>
					<svg class="ac-toggle__switch__off" width="6" height="6" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6"><path fill="#fff" d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path></svg>
					<span class="ac-toggle__switch__track"></span>
				</span>
				Inline Edit
			</span>
		</label>
		<?php
	}

	private function persistent_editing() {
		return (bool) apply_filters( 'acp/editing/persistent', false, $this->list_screen );
	}

	public function populate_column_data() {
		foreach ( $this->list_screen->get_columns() as $column ) {

			$model = Editing\ModelFactory::create( $column );

			if ( ! $model || ! $model->is_active() ) {
				continue;
			}

			$data = $model->get_view_settings();

			/**
			 * @since 4.0
			 *
			 * @param array     $data
			 * @param AC\Column $column
			 */
			$data = apply_filters( 'acp/editing/view_settings', $data, $column );
			$data = apply_filters( 'acp/editing/view_settings/' . $column->get_type(), $data, $column );

			if ( false === $data ) {
				continue;
			}

			if ( isset( $data['options'] ) ) {
				$data['options'] = $this->format_js( $data['options'] );
			}

			$this->column_data[ $column->get_name() ] = array(
				'type'     => $column->get_type(),
				'editable' => $data,
			);
		}
	}

	private function format_js( $list ) {
		$options = array();

		if ( $list ) {
			foreach ( $list as $index => $option ) {
				if ( is_array( $option ) && isset( $option['options'] ) ) {
					$option['options'] = $this->format_js( $option['options'] );
					$options[] = $option;
				} else if ( is_scalar( $option ) ) {
					$options[] = array(
						'value' => $index,
						'label' => html_entity_decode( $option ),
					);
				}
			}
		}

		return $options;
	}

	public function populate_item_data() {
		foreach ( $this->list_screen->get_columns() as $column ) {
			$editing = Editing\ModelFactory::create( $column );

			if ( ! $editing || ! $editing->is_active() ) {
				continue;
			}

			$rows = $editing->get_strategy()->get_rows();

			$view_data = $editing->get_view_settings();

			// Uses keys as revisions
			$store_values = isset( $view_data['store_values'] ) && true === $view_data['store_values'];

			// Uses a single key as revision
			$store_single_value = isset( $view_data['store_single_value'] ) && true === $view_data['store_single_value'];

			// Editable column value for each row (object)
			foreach ( $rows as $id ) {
				$value = $editing->get_edit_value( $id );

				/**
				 * Filter the raw value, used for editability, for a column
				 * @since 4.0
				 *
				 * @param mixed     $value  Column value used for editability
				 * @param int       $id     Post ID to get the column editability for
				 * @param AC\Column $column Column object
				 */
				$value = apply_filters( 'acp/editing/value', $value, $id, $column );
				$value = apply_filters( 'acp/editing/value/' . $column->get_type(), $value, $id, $column );

				// Not editable
				if ( null === $value ) {
					continue;
				}

				if ( is_array( $value ) && empty( $value ) ) {
					$value = '';
				}

				if ( false === $value ) {
					$value = '';
				}

				// Revisions
				$revisions = $value;

				// Use keys as revision
				if ( is_array( $value ) && ! $store_values ) {
					$revisions = array_keys( $value );
				}

				// USe single key as revision
				if ( $store_single_value && $value ) {
					$revisions = key( $value );
				}

				$this->item_data[ $id ]['ID'] = $id;
				$this->item_data[ $id ]['columndata'][ $column->get_name() ] = array(

					// Revision needs to be an array in array. For example: ACA_Types_Editing_Repeatable_File.
					'revisions'        => array( $revisions ),
					'formattedvalue'   => $value,
					'current_revision' => 0,
				);
			}
		}
	}

}