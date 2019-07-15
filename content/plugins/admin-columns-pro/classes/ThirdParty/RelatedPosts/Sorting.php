<?php

namespace ACP\ThirdParty\RelatedPosts;

use ACP\Sorting\Model;

class Sorting extends Model {

	public function get_sorting_vars() {
		$post_ids = array();
		foreach ( $this->get_strategy()->get_results() as $post_id ) {
			$related = $this->column->get_raw_value( $post_id );
			$post_ids[ $post_id ] = $related ? count( $related ) : false;
		}

		return array(
			'ids' => $this->sort( $post_ids ),
		);
	}

}