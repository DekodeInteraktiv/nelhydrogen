<?php

namespace ACP;

use AC;

abstract class Strategy {

	/**
	 * @return AC\Column
	 */
	public function get_column() {
		return $this->get_model()->get_column();
	}

	/**
	 * @return Model
	 */
	public abstract function get_model();

}