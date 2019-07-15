<?php

namespace ACA\ACF;

interface Formattable {

	/**
	 * Return the formatted value when a field does not have any settings with formatters so it can be used in subfields
	 *
	 * @return string
	 */
	public function format( $value );

}