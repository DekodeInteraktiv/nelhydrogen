<?php

namespace ACP\Editing;

interface ListScreen {

	/**
	 * @param Model $model
	 *
	 * @return Strategy
	 */
	public function editing( $model );

}