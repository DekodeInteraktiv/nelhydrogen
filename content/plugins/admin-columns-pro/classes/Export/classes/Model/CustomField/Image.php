<?php

namespace ACP\Export\Model\CustomField;

use ACP\Export\Model;

class Image extends Model {

	public function get_value( $id ) {
		$urls = array();

		foreach ( (array) $this->get_column()->get_raw_value( $id ) as $url ) {
			if ( is_numeric( $url ) ) {
				$url = wp_get_attachment_url( $url );
			}

			$urls[] = strip_tags( $url );
		}

		return implode( ',', $urls );
	}

}