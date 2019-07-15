<?php

namespace ACP\License;

use AC\Transient;
use ACP\License;
use WP_Error;

class Install {

	/**
	 * @var string Plugin name e.g. ac-plugin
	 */
	private $plugin_name;

	/**
	 * @var API;
	 */
	private $api;

	/**
	 * @param string $plugin_name
	 * @param        $api
	 */
	public function __construct( $plugin_name, $api ) {
		$this->plugin_name = $plugin_name;
		$this->api = $api;
	}

	/**
	 * @return object|WP_Error
	 * @throws \Exception
	 */
	public function get_install_data() {
		$cache = new Transient( 'acpplugin_install_' . $this->plugin_name );

		if ( $cache->is_expired() ) {
			$license = new License();

			$request = new Request( array(
				'request'     => 'plugininstall',
				'licence_key' => $license->get_key(),
				'plugin_name' => $this->plugin_name,
				'site_url'    => site_url(),
				'php_version' => phpversion(),
			) );

			$response = $this->api->request( $request );

			$result = $response->has_error()
				? $response->get_error()->get_error_message()
				: $response->get_body();

			$cache->save( $result, MINUTE_IN_SECONDS * 15 );
		}

		$data = $cache->get();

		if ( is_string( $data ) ) {
			return new WP_Error( 'error', $data );
		}

		return $data;
	}

}