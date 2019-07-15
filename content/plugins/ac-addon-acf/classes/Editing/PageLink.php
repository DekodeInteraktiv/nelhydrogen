<?php

namespace ACA\ACF\Editing;

class PageLink extends PostObject {

	public function get_ajax_options( $request ) {
		$field = $this->column->get_field();

		$post_type = $field->get( 'post_type' );

		if ( ! $post_type || in_array( 'all', $post_type ) || in_array( 'any', $post_type ) ) {
			$post_type = 'any';
		}

		return acp_editing_helper()->get_posts_list( array( 's' => $request['search'], 'post_type' => $post_type, 'paged' => $request['paged'] ) );
	}

}