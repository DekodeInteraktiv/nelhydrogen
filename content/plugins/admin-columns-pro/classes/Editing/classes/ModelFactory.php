<?php

namespace ACP\Editing;

use AC;

class ModelFactory {

	public static function create( AC\Column $column ) {
		if ( ! $column instanceof Editable ) {
			return false;
		}

		$list_screen = $column->get_list_screen();

		if ( ! $list_screen instanceof ListScreen ) {
			return false;
		}

		$model = $column->editing();

		$model->set_strategy( $list_screen->editing( $model ) );

		return $model;
	}

}