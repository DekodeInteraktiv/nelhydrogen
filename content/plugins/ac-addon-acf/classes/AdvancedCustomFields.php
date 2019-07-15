<?php

namespace ACA\ACF;

use AC;

final class AdvancedCustomFields extends AC\Plugin {

	/**
	 * @var string
	 */
	protected $file;

	/**
	 * @param string $file Location of the plugin main file
	 */
	public function __construct( $file ) {
		$this->file = $file;
	}

	protected function get_file() {
		return $this->file;
	}

	protected function get_version_key() {
		return 'aca_acf';
	}

	/**
	 * Register hooks
	 */
	public function register() {
		add_action( 'ac/column_groups', array( $this, 'register_column_groups' ) );
		add_action( 'ac/column_types', array( $this, 'add_columns' ) );
		add_action( 'ac/table_scripts/editing', array( $this, 'table_scripts_editing' ) );
		add_action( 'ac/settings/scripts', array( $this, 'settings_scripts' ) );
	}

	/**
	 * @param AC\Groups $groups
	 */
	public function register_column_groups( $groups ) {
		$groups->register_group( 'acf', __( 'Advanced Custom Fields' ), 11 );
	}

	/**
	 * Add custom columns
	 *
	 * @param AC\ListScreen $list_screen
	 *
	 * @since 1.0
	 */
	public function add_columns( $list_screen ) {
		$content_types = array( 'Post', 'Media', 'User', 'Comment', 'Taxonomy' );

		foreach ( $content_types as $content_type ) {
			$instance = 'ACP\Listscreen\\' . $content_type;

			if ( $list_screen instanceof $instance ) {
				$column = 'ACA\ACF\Column\\' . $content_type;

				$list_screen->register_column_type( new $column );

				break;
			}
		}
	}

	public function table_scripts_editing() {
		wp_enqueue_script( 'ac-acf-table', $this->get_url() . 'assets/js/table.js', array( 'jquery' ), $this->get_version() );
		wp_enqueue_style( 'ac-acf-table', $this->get_url() . 'assets/css/table.css' );
	}

	public function settings_scripts() {
		wp_enqueue_script( 'ac-acf-settings', $this->get_url() . 'assets/js/admin.js', array( 'jquery' ), $this->get_version() );
	}

}