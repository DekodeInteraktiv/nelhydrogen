<?php

namespace ACA\ACF\Setting;

use ACA\ACF\Column;
use AC;
use AC\View;

/**
 * @property Column $column
 */
class FlexibleContent extends AC\Settings\Column {

	/**
	 * @var string
	 */
	private $flex_display;

	protected function define_options() {
		return array( 'flex_display' => 'count' );
	}

	public function create_view() {
		$setting = $this->create_element( 'select' );

		$setting->set_options( array(
			'count'     => __( 'Layout Type Count', 'codepress-admin-columns' ),
			'structure' => __( 'Layout Structure', 'codepress-admin-columns' ),
		) );

		$view = new View( array(
			'label'   => __( 'Display', 'codepress-admin-columns' ),
			'setting' => $setting,
		) );

		return $view;
	}

	public function get_flex_display() {
		return $this->flex_display;
	}

	public function set_flex_display( $flex_display ) {
		$this->flex_display = $flex_display;

		return $this;
	}

}