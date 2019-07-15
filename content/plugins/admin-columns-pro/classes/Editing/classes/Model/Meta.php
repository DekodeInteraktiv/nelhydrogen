<?php

namespace ACP\Editing\Model;

use AC;
use ACP\Editing\Model;

class Meta extends Model {

	/**
	 * @var AC\Column\Meta
	 */
	protected $column;

	public function __construct( AC\Column\Meta $column ) {
		parent::__construct( $column );
	}

	public function get_view_settings() {
		return array(
			'type'        => 'text',
			'placeholder' => $this->column->get_label(),
		);
	}

	public function save( $id, $value ) {
		update_metadata( $this->column->get_meta_type(), $id, $this->column->get_meta_key(), $value );
	}

}