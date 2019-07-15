<?php

namespace ACP\Column\NetworkSite;

use AC;
use ACP\Settings;

class Plugins extends AC\Column {

	public function __construct() {
		$this->set_type( 'column-msite_plugins' );
		$this->set_label( __( 'Plugins' ) );
	}

	public function get_option_name() {
		return 'active_plugins';
	}

	public function get_raw_value( $blog_id ) {
		$active_plugins = array();

		$plugins = get_plugins();

		if ( $site_plugins = ac_helper()->network->get_site_option( $blog_id, 'active_plugins' ) ) {
			$site_plugins = unserialize( $site_plugins );

			foreach ( $site_plugins as $basename ) {
				if ( isset( $plugins[ $basename ] ) ) {
					$active_plugins[ $basename ] = $plugins[ $basename ]['Name'];
				}
			}
		}

		return $active_plugins;
	}

	public function register_settings() {
		$this->add_setting( new Settings\Column\NetworkSite\PluginsInclude( $this ) );
		$this->add_setting( new Settings\Column\NetworkSite\Plugins( $this ) );
	}

}