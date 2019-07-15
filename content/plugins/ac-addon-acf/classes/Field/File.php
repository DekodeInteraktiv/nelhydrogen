<?php

namespace ACA\ACF\Field;

use ACA\ACF\Field;
use ACA\ACF\Editing;
use ACA\ACF\Filtering;
use ACA\ACF\Formattable;
use ACP;

class File extends Field
	implements Formattable {

	public function get_value( $id ) {
		$attachment_id = parent::get_value( $id );

		return $this->format( $attachment_id );
	}

	public function format( $attachment_id ) {
		$value = false;

		if ( $attachment_id ) {
			if ( $attachment = get_attached_file( $attachment_id ) ) {
				$value = ac_helper()->html->link( wp_get_attachment_url( $attachment_id ), esc_html( basename( $attachment ) ), array( 'target' => '_blank' ) );
			} else {
				$value = '<em>' . __( 'Invalid attachment', 'codepress-admin-columns' ) . '</em>';
			}
		}

		return $value;
	}

	public function editing() {
		return new Editing\File( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model( $this->column );
	}

	public function filtering() {
		return new Filtering\File( $this->column );
	}

}