<?php

function nel_get_shareholder_data() {

	/**
	 * All feeds found at http://ir.asp.manamind.com/?key=nel
	 */

	$xml_url           = '//ir.asp.manamind.com/products/xml/shareholders.do?key=nel&lang=en';
	$response_xml_data = file_get_contents( $xml_url );
	$json_data         = '';
	$updated           = '';

	if ( $response_xml_data == false ) {

		// echo "Error fetching XML\n";

	} else {

		libxml_use_internal_errors( true );
		$data = simplexml_load_string( $response_xml_data );

		if ( ! $data ) {

			// echo "Error loading XML\n";
			// foreach(libxml_get_errors() as $error) {
			// 	echo "\t", $error->message;
			// }

		} else {

			$collector = array();

			foreach ( $data->shareholders->position as $shareholder ) {
				$collector[] = array(
					'shares'  => (string) $shareholder->shares,
					'percent' => round( (string) $shareholder->percentage, 2 ),
					'name'    => (string) $shareholder->investor,
				);
			}

			$json_data = json_encode( $collector );
			$timestamp = substr( $data->shareholders->updated, 0, 10 );
			$updated   = date( 'd.m.Y', $timestamp );

		}
	}

	if ( $json_data == '' ) {
		$json_data = file_get_contents( TEMPLATEPATH . '/assets/investors.json' );
	}

	return array(
		'json'    => $json_data,
		'updated' => $updated
	);

}