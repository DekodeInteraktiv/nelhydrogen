<?php

namespace ACP\Filtering\TableScreen;

use ACP\Filtering\TableScreen;

class Comment extends TableScreen {

	public function __construct( array $models ) {
		parent::__construct( $models );

		add_action( 'restrict_manage_comments', array( $this, 'render_markup' ) );
	}

}