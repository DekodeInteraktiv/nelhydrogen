<?php

namespace ACP\Editing;

use AC;
use ACP\Editing;

class Addon extends AC\Addon {

	/**
	 * @since 4.0
	 */
	function __construct() {
		AC\Autoloader::instance()->register_prefix( __NAMESPACE__, $this->get_dir() . 'classes/' );
		AC\Autoloader\Underscore::instance()->add_alias( __NAMESPACE__ . '\Editable', 'ACP_Column_EditingInterface' );

		// Settings screen
		add_action( 'ac/column/settings', array( $this, 'register_column_settings' ) );
		add_action( 'ac/settings/general', array( $this, 'register_general_settings' ) );

		// Table screen
		add_action( 'ac/table/list_screen', array( $this, 'init_table' ) );

		// Table ajax calls
		add_action( 'wp_ajax_acp_editing_state_save', array( $this, 'ajax_editability_state_save' ) );
		add_action( 'wp_ajax_acp_editing_column_save', array( $this, 'ajax_column_save' ) );
		add_action( 'wp_ajax_acp_editing_get_options', array( $this, 'ajax_get_options' ) );
	}

	/**
	 * @param AC\ListScreen $list_screen
	 */
	public function init_table( $list_screen ) {
		$table_screen = new Table\Screen( $list_screen, $this->is_editing_active( $list_screen ) );
		$table_screen->register();
	}

	/**
	 * @param AC\ListScreen $list_screen
	 *
	 * @return bool
	 */
	private function is_editing_active( AC\ListScreen $list_screen ) {
		return '1' === $this->prefence()->get( $list_screen->get_key() );
	}

	/**
	 * @return AC\Preferences\Site
	 */
	private function prefence() {
		return new AC\Preferences\Site( 'editability_state' );
	}

	/**
	 * Ajax callback for storing user preference of the default state of editability on an overview page
	 * @since 3.2.1
	 */
	public function ajax_editability_state_save() {
		check_ajax_referer( 'ac-ajax' );

		$key = filter_input( INPUT_POST, 'list_screen' );
		$value = filter_input( INPUT_POST, 'value' ) ? '1' : '0';

		$this->prefence()->set( $key, $value );
		exit;
	}

	/**
	 * Ajax callback for saving a column
	 * @since 1.0
	 */
	public function ajax_column_save() {
		check_ajax_referer( 'ac-ajax' );

		// Get ID of entry to edit
		$id = intval( filter_input( INPUT_POST, 'pk' ) );

		if ( ! $id ) {
			wp_die( __( 'Invalid item ID.', 'codepress-admin-columns' ), null, 400 );
		}

		$list_screen = AC\ListScreenFactory::create( filter_input( INPUT_POST, 'list_screen' ), filter_input( INPUT_POST, 'layout' ) );

		if ( ! $list_screen ) {
			wp_die( __( 'Invalid list screen.', 'codepress-admin-columns' ), null, 400 );
		}

		/* @var $column AC\Column */
		$column = $list_screen->get_column_by_name( filter_input( INPUT_POST, 'column' ) );

		if ( ! $column ) {
			wp_die( __( 'Invalid column.', 'codepress-admin-columns' ), null, 400 );
		}

		if ( ! $column instanceof Editing\Editable ) {
			wp_die( __( 'Column does not support editing.', 'codepress-admin-columns' ), null, 400 );
		}

		$model = ModelFactory::create( $column );

		if ( ! $model->get_strategy()->user_has_write_permission( $id ) ) {
			wp_die( __( 'User does not have write permissions', 'codepress-admin-columns' ), null, 400 );
		}

		// Can contain strings and array's
		$value = isset( $_POST['value'] ) ? $_POST['value'] : '';

		/**
		 * Filter for changing the value before storing it to the DB
		 * @since 4.0
		 *
		 * @param mixed     $value Value send from inline edit ajax callback
		 * @param AC\Column $column
		 * @param int       $id    ID
		 */
		$value = apply_filters( 'acp/editing/save_value', $value, $column, $id );

		// Save
		$save_result = $model->save( $id, $value );

		/**
		 * Hook to allow saving of values by Third Party columns
		 * @since 4.0
		 *
		 * @param bool      $save_result
		 * @param int       $id Object ID
		 * @param mixed     $value
		 * @param AC\Column $column
		 */
		$save_result = apply_filters( 'acp/editing/save', $save_result, $id, $value, $column );
		$save_result = apply_filters( 'acp/editing/save/' . $column->get_type(), $save_result, $id, $value, $column );

		if ( is_wp_error( $save_result ) ) {
			wp_die( $save_result->get_error_message(), null, 400 );
		}

		/**
		 * Fires after a inline-edit successfully saved a value
		 * @since 4.0
		 *
		 * @param AC\Column $column Column instance
		 * @param int       $id     Item ID
		 * @param string    $value  User submitted input
		 */
		do_action( 'acp/editing/saved', $column, $id, $value );

		$display_value = $list_screen->get_display_value_by_column_name( $column->get_name(), $id );

		// Fallback
		if ( ! $display_value && is_string( $save_result ) ) {
			$display_value = $save_result;
		}

		// Send back the result unquoted, otherwise editing a second time won't work correctly (ticket #817)
		if ( is_string( $value ) ) {
			$value = stripcslashes( $value );
		}

		$data = array(
			'rawvalue'  => $value,

			// Cell HTML
			'cell_html' => $display_value,

			// Row HTML. Mainly used to fetch the return value from default columns.
			'row_html'  => $list_screen instanceof AC\ListScreenWP ? $list_screen->get_single_row( $id ) : '',
		);

		/**
		 * @since 4.0.11
		 *
		 * @param array     $data
		 * @param int       $id
		 * @param AC\Column $column
		 */
		$data = apply_filters( 'acp/editing/result', $data, $id, $column );

		wp_send_json_success( $data );
	}

	/**
	 * AJAX callback for retrieving options for a column
	 * Results can be formatted in two ways: an array of options ([value] => [label]) or
	 * an array of option groups ([group key] => [group]) with [group] being an array with
	 * two keys: label (the label displayed for the group) and options (an array ([value] => [label])
	 * of options)
	 * @since 1.0
	 */
	public function ajax_get_options() {
		check_ajax_referer( 'ac-ajax' );

		$list_screen = AC\ListScreenFactory::create( filter_input( INPUT_GET, 'list_screen' ), filter_input( INPUT_GET, 'layout' ) );

		if ( ! $list_screen ) {
			wp_die( __( 'Invalid list screen.', 'codepress-admin-columns' ), null, 400 );
		}

		$column = $list_screen->get_column_by_name( filter_input( INPUT_GET, 'column' ) );

		if ( ! $column ) {
			wp_send_json_error( __( 'Invalid column.', 'codepress-admin-columns' ) );
		}

		if ( ! $column instanceof Editing\Editable ) {
			wp_send_json_error( __( 'Invalid column.', 'codepress-admin-columns' ) );
		}

		$request = array(
			'search'    => filter_input( INPUT_GET, 'searchterm' ),
			'paged'     => absint( filter_input( INPUT_GET, 'page' ) ),
			'object_id' => absint( filter_input( INPUT_GET, 'item_id' ) ),
		);

		$result = $column->editing()->get_ajax_options( $request );

		wp_send_json_success( array(
			'options' => $this->format_js( $result ),
			'more'    => true,
		) );
	}

	/**
	 * Format options to be in JS
	 * @since 1.0
	 *
	 * @param $list
	 *
	 * @return array Formatted option list
	 */
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

	protected function get_file() {
		return __FILE__;
	}

	/**
	 * @since 4.0
	 */
	public function get_version() {
		return ACP()->get_version();
	}

	public function helper() {
		return new Helper();
	}

	/**
	 * @since 3.1.2
	 *
	 * @param AC\Admin\Page\Settings $settings
	 */
	public function register_general_settings( $settings ) {
		$settings->single_checkbox( array(
			'name'         => 'custom_field_editable',
			'label'        => __( 'Enable inline editing for Custom Fields. Default is <code>off</code>', 'codepress-admin-columns' ),
			'instructions' => sprintf(
				'<p>%s</p><p>%s</p>',
				__( 'Inline edit will display all the raw values in an editable text field.', 'codepress-admin-columns' ),
				sprintf(
					__( "Please read <a href='%s'>our documentation</a> if you plan to use these fields.", 'codepress-admin-columns' ),
					ac_get_site_utm_url( 'documentation/faq/enable-inline-editing-custom-fields/', 'general-settings' )
				)
			),
		) );
	}

	/**
	 * Register setting for editing
	 *
	 * @param AC\Column $column
	 */
	public function register_column_settings( $column ) {
		if ( $model = ModelFactory::create( $column ) ) {
			$model->register_settings();
		}
	}

}