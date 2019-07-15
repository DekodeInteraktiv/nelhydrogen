<?php

namespace ACP\Filtering\TableScreen;

use ACP\Filtering\Model;
use ACP\Filtering\TableScreen;

class Post extends TableScreen {

	public function __construct( array $models ) {
		parent::__construct( $models );

		add_action( 'restrict_manage_posts', array( $this, 'render_markup' ), 11 );
	}

	public function hide_default_dropdowns() {
		parent::hide_default_dropdowns();

		foreach ( $this->models as $model ) {
			if ( $model instanceof Model\Post\Date && $model->is_active() && 'monthly' === $model->get_filter_format() ) {
				add_filter( 'disable_months_dropdown', '__return_true' );
			}
		}
	}

}