<?php

namespace ACP\Sorting;

use AC;

/**
 * Sorting Addon class
 * @since 1.0
 */
class Addon extends AC\Addon {

	const OPTIONS_KEY = 'ac_sorting';

	/**
	 * @since 1.0
	 */
	public function __construct() {
		AC\Autoloader::instance()->register_prefix( __NAMESPACE__, $this->get_dir() . 'classes' );
		AC\Autoloader\Underscore::instance()->add_alias( __NAMESPACE__ . '\Sortable', 'ACP_Column_SortingInterface' );

		// After filtering
		add_action( 'ac/table/list_screen', array( $this, 'init_table' ), 11 );

		// Column
		add_action( 'ac/column/settings', array( $this, 'register_column_settings' ) );

		// Settings screen
		add_action( 'ac/settings/general', array( $this, 'add_settings' ) );
		add_filter( 'ac/settings/groups', array( $this, 'settings_group' ), 15 );
		add_action( 'ac/settings/group/sorting', array( $this, 'settings_display' ) );

		add_action( 'admin_init', array( $this, 'handle_settings_request' ) );

		// Handle ajax
		add_action( 'wp_ajax_acp_reset_sorting', array( $this, 'ajax_reset_sorting' ) );
	}

	/**
	 * @param AC\ListScreen $list_screen
	 */
	public function init_table( AC\ListScreen $list_screen ) {
		$table = new Table\Screen( $list_screen );
		$table->register();
	}

	/**
	 * Ajax reset sorting
	 */
	public function ajax_reset_sorting() {
		check_ajax_referer( 'ac-ajax' );

		$list_screen = AC\ListScreenFactory::create( filter_input( INPUT_POST, 'list_screen' ), filter_input( INPUT_POST, 'layout' ) );

		if ( ! $list_screen ) {
			wp_die();
		}

		$table = new Table\Screen( $list_screen );

		wp_send_json_success( $table->reset_sorting() );
	}

	/**
	 * @return string
	 */
	protected function get_file() {
		return __FILE__;
	}

	/**
	 * Hide or show empty results
	 * @since 4.0
	 * @return boolean
	 */
	public function show_all_results() {
		return AC()->admin()->get_general_option( 'show_all_results' );
	}

	/**
	 * @param AC\Admin\Page\Settings $settings
	 */
	public function add_settings( $settings ) {
		$settings->single_checkbox( array(
			'name'  => 'show_all_results',
			'label' => __( "Show all results when sorting.", 'codepress-admin-columns' ) . ' ' . $settings->get_default_text( 'off' ),
		) );
	}

	/**
	 * Register field settings for sorting
	 *
	 * @param AC\Column $column
	 */
	public function register_column_settings( $column ) {

		// Custom columns
		if ( $column instanceof Sortable ) {
			$column->sorting()->register_settings();
		}

		// Native columns
		$native = new NativeSortables( $column->get_list_screen() );

		if ( $native->is_sortable( $column->get_type() ) ) {

			$setting = new Settings( $column );
			$setting->set_default( 'on' );

			$column->add_setting( $setting );
		}
	}

	/**
	 * Callback for the settings page to add settings for sorting
	 *
	 * @param array $groups
	 *
	 * @return array
	 */
	public function settings_group( $groups ) {
		if ( isset( $groups['sorting'] ) ) {
			return $groups;
		}

		$groups['sorting'] = array(
			'title'       => __( 'Sorting Preferences', 'codepress-admin-columns' ),
			'description' => __( 'This will reset the sorting preference for all users.', 'codepress-admin-columns' ),
		);

		return $groups;
	}

	/**
	 * Callback for the settings page to display settings for sorting
	 */
	public function settings_display() {
		?>
		<form action="" method="post">
			<?php wp_nonce_field( 'reset-sorting-preference', '_acnonce' ); ?>
			<input type="submit" class="button" value="<?php _e( 'Reset sorting preferences', 'codepress-admin-columns' ); ?>">
		</form>
		<?php
	}

	/**
	 * Reset all sorting preferences for all users
	 */
	public function handle_settings_request() {
		if ( ! current_user_can( AC\Capabilities::MANAGE ) ) {
			return;
		}
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, '_acnonce' ), 'reset-sorting-preference' ) ) {
			return;
		}

		$preference = new AC\Preferences\Site( 'sorted_by' );
		$preference->reset_for_all_users();

		$notice = new AC\Message\Notice();
		$notice->set_message( __( 'All sorting preferences have been reset.', 'codepress-admin-columns' ) )
		       ->register();
	}

}