<?php

namespace ACP\License;

use AC\Capabilities;
use AC\Message;
use AC\Registrable;
use ACP\License;
use WP_Error;

class Settings
	implements Registrable {

	/**
	 * @var API
	 */
	protected $api;

	/**
	 * @param API $api
	 */
	public function __construct( API $api ) {
		$this->api = $api;
	}

	public function register() {
		// Add UI
		add_filter( 'ac/settings/groups', array( $this, 'settings_group' ) );
		add_action( 'ac/settings/group/addons', array( $this, 'display' ) );

		// Multisite
		add_filter( 'acp/network_settings/groups', array( $this, 'settings_group' ), 10, 2 );
		add_action( 'acp/network_settings/group/addons', array( $this, 'display' ) );

		// add scripts, after settings page is set.
		add_action( 'admin_init', array( $this, 'register_admin_scripts' ) );
		add_action( 'admin_menu', array( $this, 'scripts' ), 20 );
		add_action( 'network_admin_menu', array( $this, 'network_scripts' ), 20 );

		// Requests
		add_action( 'init', array( $this, 'handle_request' ) );
	}

	/**
	 * Check if the license for this plugin is managed per site or network
	 * @since 3.6
	 * @return boolean
	 */
	private function is_network_managed_license() {
		return is_multisite() && is_plugin_active_for_network( ACP()->get_basename() );
	}

	/**
	 * @since 3.1.2
	 */
	public function scripts() {
		if ( AC()->admin()->is_current_page( 'settings' ) ) {
			add_action( "admin_print_scripts-" . AC()->admin()->get_hook_suffix(), array( $this, 'admin_scripts' ) );
		}
	}

	public function network_scripts() {
		add_action( "admin_print_scripts-" . ACP()->network_admin()->get_hook_suffix(), array( $this, 'admin_scripts' ) );
	}

	public function register_admin_scripts() {
		wp_register_style( 'acp-license-manager', ACP()->get_url() . "assets/css/license-manager.css", array(), ACP()->get_version() );
		wp_register_script( 'acp-license-manager', ACP()->get_url() . "assets/js/license-manager.js", array( 'jquery' ), ACP()->get_version() );
	}

	/**
	 * @since 3.1.2
	 */
	public function admin_scripts() {
		wp_enqueue_script( 'acp-license-manager' );
		wp_enqueue_style( 'acp-license-manager' );
	}

	/**
	 * @param string $license_key
	 *
	 * @return string|WP_Error Success message
	 */
	private function activate_license( $license_key ) {
		$license_key = sanitize_text_field( $license_key );

		if ( empty( $license_key ) ) {
			return new WP_Error( 'empty-license', __( 'Empty license.', 'codepress-admin-columns' ) );
		}

		$license = new License();
		$license->delete();

		$request = new Request( array(
			'request'     => 'activation',
			'licence_key' => $license_key,
			'site_url'    => site_url(),
		) );

		$response = $this->api->request( $request );

		if ( $response->has_error() ) {
			return $response->get_error();
		}

		if ( null === $response->get( 'activated' ) ) {
			return new WP_Error( 'error', __( 'Wrong response from API.', 'codepress-admin-columns' ) );
		}

		if ( $response->get( 'expiry_date' ) ) {
			$license->set_expiry_date( $response->get( 'expiry_date' ) );
		}

		if ( $response->get( 'renewal_discount' ) ) {
			$license->set_renewal_discount( $response->get( 'renewal_discount' ) );
		}

		$license->set_key( $license_key )
		        ->set_status( 'active' )
		        ->save();

		do_action( 'acp/license/activated', $response );

		return $response->get( 'message' );
	}

	/**
	 * @return string|WP_Error Success message
	 */
	private function deactivate_license() {
		$license = new License();

		$request = new Request( array(
			'request'     => 'deactivation',
			'licence_key' => $license->get_key(),
			'site_url'    => site_url(),
		) );

		$response = $this->api->request( $request );

		$license->delete();

		if ( $response->has_error() ) {
			return new WP_Error( 'error', __( 'Wrong response from API.', 'codepress-admin-columns' ) . ' ' . $response->get_error()->get_error_message() );
		}

		if ( null === $response->get( 'deactivated' ) ) {
			return new WP_Error( 'error', __( 'Wrong response from API.', 'codepress-admin-columns' ) );
		}

		return $response->get( 'message' );
	}

	/**
	 * @param string|WP_Error $message
	 */
	private function request_notice( $message ) {
		$notice = new Message\Notice();

		if ( is_wp_error( $message ) ) {
			$notice->set_message( $message->get_error_message() )
			       ->set_type( $notice::ERROR );
		} else {
			$notice->set_message( $message );
		}

		$notice->register();
	}

	/**
	 * Handle requests for license activation and deactivation
	 * @since 1.0
	 */
	public function handle_request() {
		if ( ! current_user_can( Capabilities::MANAGE ) ) {
			return;
		}

		if ( ! wp_verify_nonce( filter_input( INPUT_POST, '_acnonce' ), 'acp-license' ) ) {
			return;
		}

		switch ( filter_input( INPUT_POST, 'action' ) ) {
			case 'activate' :
				$message = $this->activate_license( filter_input( INPUT_POST, 'license' ) );

				$this->request_notice( $message );
				break;
			case 'deactivate' :
				$message = $this->deactivate_license();

				$this->request_notice( $message );
				break;
		}
	}

	/**
	 * Add settings group to Admin Columns settings page
	 * @since 1.0
	 *
	 * @param array $groups Add group to ACP settings screen
	 *
	 * @return array Settings group for ACP
	 */
	public function settings_group( $groups ) {
		if ( isset( $groups['addons'] ) ) {
			return $groups;
		}

		$groups['addons'] = array(
			'title'       => __( 'Updates', 'codepress-admin-columns' ),
			'description' => __( 'Enter your license code to receive automatic updates.', 'codepress-admin-columns' ),
			'id'          => 'updates',
		);

		return $groups;
	}

	/**
	 * Display license field
	 * @since 1.0
	 * @return void
	 */
	public function display() {

		/**
		 * Hook is used for hiding the license form from the settings page
		 *
		 * @param bool false Show license input fields
		 */
		if ( ! apply_filters( 'acp/display_licence', true ) ) {
			return;
		}

		// When the plugin is network activated, the license is managed globally
		if ( $this->is_network_managed_license() && ! is_network_admin() ) {
			?>
			<p>
				<?php
				$page = __( 'network settings page', 'codepress-admin-columns' );

				if ( current_user_can( 'manage_network_options' ) ) {
					$page = ac_helper()->html->link( network_admin_url( 'settings.php?page=codepress-admin-columns' ), $page );
				}

				printf( __( 'The license can be managed on the %s.', 'codepress-admin-columns' ), $page );
				?>
			</p>
			<?php
		} else {

			$license = new License();
			?>

			<form id="licence_activation" action="" method="post">
				<?php wp_nonce_field( 'acp-license', '_acnonce' ); ?>

				<?php if ( $license->get_key() ) : ?>
					<input type="hidden" name="action" value="deactivate">


					<?php if ( $license->is_expired() ) : ?>
						<p>
							<span class="dashicons dashicons-no-alt"></span>
							<?php printf( __( 'License has expired on %s', 'codepress-admin-columns' ), '<strong>' . date_i18n( get_option( 'date_format' ), $license->get_expiry_date() ) . '</strong>' ); ?>
							<input type="submit" class="button" value="<?php _e( 'Deactivate license', 'codepress-admin-columns' ); ?>">
						</p>
					<?php else : ?>
						<p>
							<span class="dashicons dashicons-yes"></span>
							<?php _e( 'Automatic updates are enabled.', 'codepress-admin-columns' ); ?>
							<input type="submit" class="button" value="<?php _e( 'Deactivate license', 'codepress-admin-columns' ); ?>">
						</p>
						<p class="description">
							<?php printf( __( 'License is valid until %s', 'codepress-admin-columns' ), '<strong>' . date_i18n( get_option( 'date_format' ), $license->get_expiry_date() ) . '</strong>' ); ?>
						</p>
					<?php endif; ?>


				<?php else : ?>
					<input type="hidden" name="action" value="activate">
					<input type="password" value="<?php echo esc_attr( $license->get_key() ); ?>" name="license" size="30" placeholder="<?php echo esc_attr( __( 'Enter your license code', 'codepress-admin-columns' ) ); ?>">
					<input type="submit" class="button" value="<?php _e( 'Update license', 'codepress-admin-columns' ); ?>">
					<p class="description">
						<?php printf( __( 'You can find your license key on your %s.', 'codepress-admin-columns' ), '<a href="' . ac_get_site_utm_url( 'my-account', 'license-activation' ) . '" target="_blank">' . __( 'account page', 'codepress-admin-columns' ) . '</a>' ); ?>
					</p>
				<?php endif; ?>
			</form>

			<?php
		}
	}

}