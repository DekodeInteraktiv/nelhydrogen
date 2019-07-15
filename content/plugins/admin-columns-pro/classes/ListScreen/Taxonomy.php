<?php

namespace ACP\ListScreen;

use AC;
use ACP\Column;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;
use WP_Terms_List_Table;

class Taxonomy extends AC\ListScreenWP
	implements Editing\ListScreen, Export\ListScreen, Filtering\ListScreen, Sorting\ListScreen {

	/**
	 * @var string Taxonomy name
	 */
	private $taxonomy;

	/**
	 * Constructor
	 * @since 1.2.0
	 *
	 * @param $taxonomy
	 */
	public function __construct( $taxonomy ) {

		$this->set_taxonomy( $taxonomy )
		     ->set_meta_type( 'term' )
		     ->set_screen_base( 'edit-tags' )
		     ->set_screen_id( 'edit-' . $taxonomy )
		     ->set_key( 'wp-taxonomy_' . $taxonomy )
		     ->set_group( 'taxonomy' );
	}

	/**
	 * @param string $taxonomy
	 *
	 * @return self
	 */
	protected function set_taxonomy( $taxonomy ) {
		$this->taxonomy = (string) $taxonomy;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_taxonomy() {
		return $this->taxonomy;
	}

	/**
	 * @see WP_Terms_List_Table::column_default
	 */
	public function set_manage_value_callback() {
		add_action( "manage_" . $this->get_taxonomy() . "_custom_column", array( $this, 'manage_value' ), 10, 3 );
	}

	/**
	 * @return WP_Terms_List_Table
	 */
	public function get_list_table() {
		require_once( ABSPATH . 'wp-admin/includes/class-wp-terms-list-table.php' );

		return new WP_Terms_List_Table( array( 'screen' => $this->get_screen_id() ) );
	}

	/**
	 * @since 4.0
	 *
	 * @param int $term_id
	 *
	 * @return \WP_Term
	 */
	protected function get_object( $term_id ) {
		return get_term_by( 'id', $term_id, $this->get_taxonomy() );
	}

	/**
	 * @return string|false
	 */
	public function get_label() {
		return $this->get_taxonomy_label_var( 'name' );
	}

	/**
	 * @return false|string
	 */
	public function get_singular_label() {
		return $this->get_taxonomy_label_var( 'singular_name' );
	}

	/**
	 * @since 3.7.3
	 *
	 * @param $wp_screen
	 *
	 * @return bool
	 */
	public function is_current_screen( $wp_screen ) {
		return parent::is_current_screen( $wp_screen ) && $this->get_taxonomy() === filter_input( INPUT_GET, 'taxonomy' );
	}

	/**
	 * Get screen link
	 * @since 1.2.0
	 * @return string Link
	 */
	public function get_screen_link() {
		$post_type = null;

		if ( $object_type = $this->get_taxonomy_var( 'object_type' ) ) {
			if ( post_type_exists( $object_type[0] ) ) {
				$post_type = $object_type[0];
			}
		}

		return add_query_arg( array( 'taxonomy' => $this->get_taxonomy(), 'post_type' => $post_type ), parent::get_screen_link() );
	}

	/**
	 * Manage value
	 * @since 1.2.0
	 *
	 * @param string $value
	 * @param string $column_name
	 * @param int    $term_id
	 *
	 * @return string
	 */
	public function manage_value( $value, $column_name, $term_id ) {
		return $this->get_display_value_by_column_name( $column_name, $term_id, $value );
	}

	/**
	 * @param $var
	 *
	 * @return string|false
	 */
	private function get_taxonomy_label_var( $var ) {
		$taxonomy = get_taxonomy( $this->get_taxonomy() );

		return $taxonomy && isset( $taxonomy->labels->{$var} ) ? $taxonomy->labels->{$var} : false;
	}

	private function get_taxonomy_var( $var ) {
		$taxonomy = get_taxonomy( $this->get_taxonomy() );

		return $taxonomy && isset( $taxonomy->{$var} ) ? $taxonomy->{$var} : false;
	}

	/**
	 * @throws \ReflectionException
	 */
	protected function register_column_types() {
		$this->register_column_type( new Column\CustomField );
		$this->register_column_type( new Column\Actions );
		$this->register_column_types_from_dir( 'ACP\Column\Taxonomy' );
	}

	public function editing( $model ) {
		return new Editing\Strategy\Taxonomy( $model );
	}

	public function filtering( $model ) {
		return new Filtering\Strategy\Taxonomy( $model );
	}

	public function sorting( $model ) {
		return new Sorting\Strategy\Taxonomy( $model );
	}

	public function export() {
		return new Export\Strategy\Taxonomy( $this );
	}

}