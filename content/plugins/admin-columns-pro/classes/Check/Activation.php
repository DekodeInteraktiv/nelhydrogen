<?php

namespace ACP\Check;

use AC\Ajax;
use AC\Capabilities;
use AC\Message;
use AC\Registrable;
use AC\Screen;
use AC\Storage;
use ACP\License;

class Activation
	implements Registrable {

	/**
	 * @var License
	 */
	protected $license;

	/**
	 * @param License $license
	 */
	public function __construct( License $license ) {
		$this->license = $license;
	}

	/**
	 * @throws \Exception
	 */
	public function register() {
		add_action( 'ac/screen', array( $this, 'display' ) );

		$this->get_ajax_handler()->register();
	}

	/**
	 * @param Screen $screen
	 *
	 * @throws \Exception
	 */
	public function display( Screen $screen ) {
		if ( ! $screen->has_screen() ) {
			return;
		}

		if ( ! current_user_can( Capabilities::MANAGE ) ) {
			return;
		}

		if ( $this->license->is_active() ) {
			return;
		}

		if ( $screen->is_plugin_screen() ) {

			// Inline message on plugin page
			$notice = new Message\Plugin( ACP()->get_basename() );
			$notice->set_message( $this->get_message() )
			       ->register();

		} else if ( $screen->is_admin_screen( 'settings' ) ) {

			// Permanent displayed on settings page
			$this->register_notice( new Message\Notice() );

		} else if ( $screen->is_admin_screen( 'columns' ) && $this->get_dismiss_option()->is_expired() ) {

			// Dismissible on columns page
			$this->register_notice( new Message\Notice\Dismissible( $this->get_ajax_handler() ) );
		}
	}

	/**
	 * @param Message\Notice $notice
	 */
	private function register_notice( Message\Notice $notice ) {
		$notice->set_type( $notice::INFO )
		       ->set_message( $this->get_message() )
		       ->register();
	}

	/**
	 * return string
	 */
	private function get_message() {
		$message = sprintf(
			__( "To enable automatic updates <a href='%s'>enter your license key</a>. If you don't have a licence key, please see <a href='%s' target='_blank'>details & pricing</a>.", 'codepress_admin_columns' ),
			AC()->admin()->get_link( 'settings' ),
			ac_get_site_utm_url( 'pricing-purchase', 'plugins' )
		);

		return $message;
	}

	/**
	 * @return Ajax\Handler
	 */
	private function get_ajax_handler() {
		$handler = new Ajax\Handler();
		$handler->set_action( 'ac_notice_dismiss_activation' )
		        ->set_callback( array( $this, 'ajax_dismiss_notice' ) );

		return $handler;
	}

	/**
	 * @return Storage\Timestamp
	 * @throws \Exception
	 */
	private function get_dismiss_option() {
		return new Storage\Timestamp(
			new Storage\UserMeta( 'ac_notice_dismiss_activation' )
		);
	}

	/**
	 * @throws \Exception
	 */
	public function ajax_dismiss_notice() {
		$this->get_ajax_handler()->verify_request();
		$this->get_dismiss_option()->save( time() + ( MONTH_IN_SECONDS * 4 ) );
	}

}