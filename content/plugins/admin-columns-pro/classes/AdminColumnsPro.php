<?php

namespace ACP;

use AC;
use ACP\Admin\Page;
use ACP\LayoutScreen;
use ACP\License\API;
use ACP\ListScreen;
use ACP\ThirdParty;

/**
 * The Admin Columns Pro plugin class
 * @since 1.0
 */
final class AdminColumnsPro extends AC\Plugin {

	/**
	 * Editing instance
	 * @since 4.0
	 * @var Editing\Addon
	 */
	private $editing;

	/**
	 * Filtering instance
	 * @since 4.0
	 * @var Filtering\Addon
	 */
	private $filtering;

	/**
	 * Sorting instance
	 * @since 4.0
	 * @var Sorting\Addon
	 */
	private $sorting;

	/**
	 * @var NetworkAdmin
	 */
	private $network_admin;

	/**
	 * @var Table\HorizontalScrolling
	 */
	private $screen_options;

	/**
	 * @var API
	 */
	private $api;

	/**
	 * @since 3.8
	 */
	private static $instance = null;

	/**
	 * @since 3.8
	 * @return AdminColumnsPro
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * ACP constructor.
	 */
	private function __construct() {
		$this->editing = new Editing\Addon();
		$this->sorting = new Sorting\Addon();
		$this->filtering = new Filtering\Addon();
		$this->network_admin = new NetworkAdmin();

		$scrolling = new Table\HorizontalScrolling();
		$scrolling->register();

		// Configure API
		$this->api = new API();
		$this->api->set_url( ac_get_site_url() )
		          ->set_proxy( 'https://api.admincolumns.com' );

		AC()->admin()->get_pages()->register_page( new Page\ExportImport() );

		Export\Addon::instance();

		new ThirdParty\Addon();
		new LayoutScreen\Columns();

		$table = new LayoutScreen\Table();
		$table->register();

		$manager = new License\Manager( $this->api );
		$manager->register();

		$settings = new License\Settings( $this->api );
		$settings->register();

		add_action( 'init', array( $this, 'notice_checks' ) );

		add_filter( 'plugin_action_links', array( $this, 'add_settings_link' ), 1, 2 );
		add_filter( 'network_admin_plugin_action_links', array( $this, 'add_settings_link' ), 1, 2 );

		add_filter( 'ac/show_banner', '__return_false' );

		add_action( 'ac/list_screen_groups', array( $this, 'register_list_screen_groups' ) );

		add_action( 'ac/list_screens', array( $this, 'register_list_screens' ) );
		add_action( 'ac/column_types', array( $this, 'register_columns' ) );

		add_action( 'ac/table_scripts', array( $this, 'table_scripts' ), 10, 1 );

		// Updater
		add_action( 'init', array( $this, 'install' ) );
	}

	/**
	 * @return API
	 */
	public function get_api() {
		return $this->api;
	}

	/**
	 * Register notice checks
	 */
	public function notice_checks() {
		$checks = array(
			new Check\Activation( new License() ),
			new Check\Beta( $this ),
			new Check\Expired( new License() ),
			new Check\Renewal( new License() ),
		);

		foreach ( $checks as $check ) {
			$check->register();
		}
	}

	/**
	 * @return string
	 */
	protected function get_file() {
		return ACP_FILE;
	}

	/**
	 * @return string
	 */
	protected function get_version_key() {
		return 'acp_version';
	}

	/**
	 * @since 4.0
	 */
	public function editing() {
		return $this->editing;
	}

	/**
	 * @since 4.0
	 */
	public function filtering() {
		return $this->filtering;
	}

	/**
	 * @since 4.0
	 */
	public function sorting() {
		return $this->sorting;
	}

	/**
	 * @since 4.0
	 *
	 * @param AC\ListScreen $list_screen
	 *
	 * @return Layouts
	 */
	public function layouts( AC\ListScreen $list_screen ) {
		return new Layouts( $list_screen );
	}

	/**
	 * @since 4.0
	 */
	public function network_admin() {
		return $this->network_admin;
	}

	/**
	 * @since 4.0.12
	 */
	public function screen_options() {
		return $this->screen_options;
	}

	/**
	 * @since 1.0
	 * @see   filter:plugin_action_links
	 *
	 * @param array  $links
	 * @param string $file
	 *
	 * @return array
	 */
	public function add_settings_link( $links, $file ) {
		if ( $file === $this->get_basename() ) {
			$url = AC()->admin()->get_link( 'columns' );

			if ( is_network_admin() ) {
				$url = $this->network_admin->get_link();
			}

			array_unshift( $links, ac_helper()->html->link( $url, __( 'Settings' ) ) );
		}

		return $links;
	}

	/**
	 * @return string
	 */
	public function get_network_settings_url() {
		return $this->network_admin()->get_link();
	}

	/**
	 * Get a list of taxonomies supported by Admin Columns
	 * @since 1.0
	 * @return array List of taxonomies
	 */
	private function get_taxonomies() {
		$taxonomies = get_taxonomies( array( 'show_ui' => true ) );

		if ( isset( $taxonomies['post_format'] ) ) {
			unset( $taxonomies['post_format'] );
		}

		if ( isset( $taxonomies['link_category'] ) && ! get_option( 'link_manager_enabled' ) ) {
			unset( $taxonomies['link_category'] );
		}

		/**
		 * Filter the post types for which Admin Columns is active
		 * @since 2.0
		 *
		 * @param array $post_types List of active post type names
		 */
		return (array) apply_filters( 'acp/taxonomies', $taxonomies );
	}

	/**
	 * @param AC\Groups $groups
	 */
	public function register_list_screen_groups( $groups ) {
		$groups->register_group( 'taxonomy', __( 'Taxonomy' ), 15 );
		$groups->register_group( 'network', __( 'Network' ), 5 );
	}

	/**
	 * @since 4.0
	 *
	 * @param AC\AdminColumns $admin_columns
	 */
	public function register_list_screens( $admin_columns ) {
		$list_screens = array();

		// Post types
		foreach ( AC()->get_post_types() as $post_type ) {
			$list_screens[] = new ListScreen\Post( $post_type );
		}

		$list_screens[] = new ListScreen\Media();
		$list_screens[] = new ListScreen\Comment();

		foreach ( $this->get_taxonomies() as $taxonomy ) {
			$list_screens[] = new ListScreen\Taxonomy( $taxonomy );
		}

		$list_screens[] = new ListScreen\User();

		if ( is_multisite() ) {

			// Settings UI
			if ( AC()->admin_columns_screen()->is_current_screen() ) {

				// Main site
				if ( is_main_site() ) {
					$list_screens[] = new ListScreen\MSUser();
					$list_screens[] = new ListScreen\MSSite();
				}
			} // Table screen
			else {
				$list_screens[] = new ListScreen\MSUser();
				$list_screens[] = new ListScreen\MSSite();
			}
		}

		foreach ( $list_screens as $list_screen ) {
			$admin_columns->register_list_screen( $list_screen );
		}
	}

	/**
	 * @param AC\ListScreen $list_screen
	 */
	public function register_columns( AC\ListScreen $list_screen ) {
		$this->register_column_native_taxonomies( $list_screen );

		/**
		 * @deprecated 4.1 Use 'ac/column_types'
		 */
		do_action( 'acp/column_types', $list_screen );
	}

	/**
	 * Register Taxonomy columns that are set by WordPress. These native columns are registered
	 * by setting 'show_admin_column' to 'true' as an argument in register_taxonomy();
	 * Only supports Post Types.
	 * @see register_taxonomy
	 *
	 * @param AC\ListScreen $list_screen
	 */
	private function register_column_native_taxonomies( AC\ListScreen $list_screen ) {
		if ( ! $list_screen instanceof AC\ListScreenPost ) {
			return;
		}

		$taxonomies = get_taxonomies(
			array(
				'show_ui'           => 1,
				'show_admin_column' => 1,
				'_builtin'          => 0,
			),
			'object'
		);

		foreach ( $taxonomies as $taxonomy ) {
			if ( in_array( $list_screen->get_post_type(), $taxonomy->object_type ) ) {
				$column = new Column\NativeTaxonomy();
				$column->set_type( 'taxonomy-' . $taxonomy->name );

				$list_screen->register_column_type( $column );
			}
		}
	}

	public function table_scripts() {
		wp_enqueue_style( 'acp-table', ACP()->get_url() . "assets/css/table.css", array(), AC()->get_version() );
	}

}