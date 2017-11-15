<?php
/**
 * Defines the Admin_Notices class
 *
 * @package WP_Business_Reviews\Includes\Admin
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates admin notices for the plugin.
 *
 * Notices alert the user of important information such as when saving settings
 * either succeeds or fails.
 *
 * For ease of implementation, all admin messages are defined in the `messages`
 * property. This allows notices to be added simply by passing the notice ID
 * and type.
 *
 * @since 0.1.0
 */
class Admin_Notices {
	private $messages;
	private $notices;

	public function __construct() {
		$this->messages = $this->define_messages();
		$this->notices  = array();
	}

	private function define_messages() {
		$index = array(
			'settings_update_success'   => __( 'Settings saved successfully.', 'wpbr' ),
			'settings_nonce_error'      => __( 'Nonce could not be validated.', 'wpbr' ),
			'settings_permission_error' => __( 'User does not have permission to save settings.', 'wpbr' ),
		);

		return $index;
	}

	public function add_notice( $notice_id, $type = 'info' ) {
		// If message key is not set or if the notice has already been added, return false.
		if ( ! isset( $this->messages[ $notice_id ] ) || isset( $this->notices[ $notice_id ] ) ) {
			return false;
		}

		$this->notices[] = array(
			'message' => $this->messages[ $notice_id ],
			'type'    => $type,
		);
	}

	public function render_notices() {
		foreach ( $this->notices as $notice ) {
			$type = isset( $notice['type'] ) ? $notice['type'] : 'info';
			echo '<div class="wpbr-notice wpbr-notice--' . esc_attr( $type ) . '">'. $notice['message'] . '</div>';
		}
	}
}
