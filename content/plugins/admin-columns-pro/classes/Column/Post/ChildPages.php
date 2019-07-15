<?php

namespace ACP\Column\Post;

use AC;
use ACP\Export;
use ACP\Filtering;

class ChildPages extends AC\Column
	implements Filtering\Filterable, Export\Exportable {

	public function __construct() {
		$this->set_type( 'column-child-pages' );
		$this->set_label( __( 'Child Pages', 'codepress-admin-columns' ) );
	}

	// Display
	public function get_value( $post_id ) {
		$titles = array();

		if ( $ids = $this->get_raw_value( $post_id ) ) {
			foreach ( $ids as $id ) {
				$post = get_post( $id );

				$titles[] = ac_helper()->html->link( get_edit_post_link( $id ), $post->post_title );
			}
		}

		return ac_helper()->string->enumeration_list( $titles, 'and' );
	}

	public function get_raw_value( $post_id ) {
		$ids = get_posts( array(
			'post_type'      => $this->get_post_type(),
			'post_parent'    => $post_id,
			'fields'         => 'ids',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		) );

		return $ids;
	}

	public function is_valid() {
		return is_post_type_hierarchical( $this->get_post_type() ) || post_type_supports( $this->get_post_type(), 'page-attributes' );
	}

	public function filtering() {
		return new Filtering\Model\Post\ChildPages( $this );
	}

	public function export() {
		return new Export\Model\Post\ChildPages( $this );
	}

}