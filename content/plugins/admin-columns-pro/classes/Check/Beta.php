<?php

namespace ACP\Check;

use AC;
use AC\Message\Notice;
use AC\Plugin;

class Beta
	implements AC\Registrable {

	/**
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * @var Notice
	 */
	protected $notice;

	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	public function register() {
		if ( ! $this->plugin->is_beta() ) {
			return;
		}

		$notice = new Notice();
		$notice->set_type( Notice::WARNING )
		       ->set_message( $this->get_message() )
		       ->enqueue_scripts();

		add_action( 'ac/settings/after_menu', array( $notice, 'display' ) );
	}

	/**
	 * @return string
	 */
	protected function get_feedback_link() {
		return ac_get_site_utm_url( 'forums/forum/beta-feedback/', 'beta-notice' );
	}

	/**
	 * @return string
	 */
	protected function get_message() {
		return implode( ' ', array(
			sprintf( __( 'You are using a beta version of %s.', 'codepress-admin-columns' ), $this->plugin->get_name() ),
			sprintf( __( 'If you have feedback or have found a bug, please report it on <a href="%s" target="_blank">our forum</a>.', 'codepress-admin-columns' ), $this->get_feedback_link() ),
		) );
	}

}