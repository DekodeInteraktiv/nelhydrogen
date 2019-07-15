<?php

namespace ACP\ListScreen;

use AC;
use ACP\Column;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Sorting;

class Post extends AC\ListScreen\Post
	implements Sorting\ListScreen, Editing\ListScreen, Filtering\ListScreen, Export\ListScreen {

	public function sorting( $model ) {
		return new Sorting\Strategy\Post( $model );
	}

	public function editing( $model ) {
		return new Editing\Strategy\Post( $model );
	}

	public function filtering( $model ) {
		return new Filtering\Strategy\Post( $model );
	}

	public function export() {
		return new Export\Strategy\Post( $this );
	}

	/**
	 * @throws \ReflectionException
	 */
	protected function register_column_types() {
		parent::register_column_types();

		$this->register_column_type( new Column\CustomField );
		$this->register_column_type( new Column\Actions );

		$this->register_column_types_from_dir( 'ACP\Column\Post' );
	}

}