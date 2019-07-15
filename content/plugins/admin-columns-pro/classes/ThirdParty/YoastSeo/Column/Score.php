<?php

namespace ACP\ThirdParty\YoastSeo\Column;

use AC;
use ACP\Export;
use ACP\Sorting;

class Score extends AC\Column\Meta
	implements Export\Exportable, Sorting\Sortable {

	public function __construct() {
		$this->set_original( true );
		$this->set_group( 'yoast-seo' );
		$this->set_type( 'wpseo-score' );
	}

	// The display value is handled by the native column
	public function get_value( $id ) {
		return false;
	}

	public function register_settings() {
		$width = $this->get_setting( 'width' );
		$width->set_default( 63 );
		$width->set_default( 'px', 'width_unit' );
	}

	/**
	 * @inheritDoc
	 */
	public function get_meta_key() {
		return '_yoast_wpseo_linkdex';
	}

	public function export() {
		return new Export\Model\StrippedRawValue( $this );
	}

	/**
	 * @inheritDoc
	 */
	public function sorting() {
		$model = new Sorting\Model\Meta( $this );
		$model->set_data_type( 'numeric' );

		return $model;
	}

}