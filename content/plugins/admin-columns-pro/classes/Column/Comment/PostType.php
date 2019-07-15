<?php

namespace ACP\Column\Comment;

use AC;
use ACP\Filtering;

/**
 * @since 4.2
 */
class PostType extends AC\Column
	implements Filtering\Filterable {

	public function __construct() {
		$this->set_type( 'column-post_type' );
		$this->set_label( __( 'Post Type', 'codepress-admin-columns' ) );
	}

	public function get_value( $id ) {
		$post_type = $this->get_raw_value( $id );
		$post_type_object = get_post_type_object( $post_type );

		if ( ! $post_type_object ) {
			return false;
		}

		return $post_type_object->labels->singular_name;
	}

	public function get_raw_value( $id ) {
		$comment = get_comment( $id );

		return get_post_type( $comment->comment_post_ID );
	}

	public function filtering() {
		return new Filtering\Model\Comment\PostType( $this );
	}

}