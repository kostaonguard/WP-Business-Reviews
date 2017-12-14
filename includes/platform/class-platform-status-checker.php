<?php
/**
 * Defines the Platform_Status_Checker class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Platform
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Platform;

use WP_Business_Reviews\Includes\Request\Request_Factory;

/**
 * Checks the status of a platform.
 *
 * A remote API request is attempted for the given platform. The
 *
 * @since 0.1.0
 */
class Platform_Status_Checker {
	/**
	 * Instantiates the Platform_Status_Checker object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform Unique identifier of the platform being checked.
	 */
	public function __construct( $platform, Serializer $serializer ) {
		$this->platform   = $platform;
		$this->serializer = $serializer;
		$this->request    = Request_Factory( $platform );
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		// TODO: Hook into action after save.
	}

	/**
	 * Check the connection of the platform.
	 *
	 * @since 0.1.0
	 */
	public function check() {
		// TODO: Create test request.
		// TODO: Save result and timestamp to database.
	}
}
