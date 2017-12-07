<?php
/**
 * Defines the Platform_Status class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes;

use WP_Business_Reviews\Includes\Settings\Serializer;
use WP_Business_Reviews\Includes\Settings\Deserializer;
use WP_Business_Reviews\Includes\Request\Request_Factory;

/**
 * Determines the connection status to a remote API.
 *
 * @since 0.1.0
 */
class Platform_Status {
	/**
	 * Settings saver.
	 *
	 * @since 0.1.0
	 * @var Serializer $serializer
	 */

	/**
	 * Settings reader.
	 *
	 * @since 0.1.0
	 * @var Deserializer $deserializer
	 */

	/**
	 * Request factory.
	 *
	 * @since 0.1.0
	 * @var Request_Factory $request_factory
	 */

	private $serializer;

	/**
	 * Instantiates the Platform_Status object.
	 *
	 * @param Serializer      $serializer      Settings saver.
	 * @param Deserializer    $deserializer    Settings reader.
	 * @param Request_Factory $request_factory Request factory.
	 */
	public function __construct(
		Serializer $serializer,
		Deserializer $deserializer,
		Request_Factory $request_factory
	) {
		$this->serializer      = $serializer;
		$this->deserializer    = $deserializer;
		$this->request_factory = $request_factory;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_business_reviews_saved_settings', array( $this, 'test_connection' ) );
	}

	public function save_platform_status() {
		// Check if platform is active.
		// Check if platform is connected.
		// Save result to database.
	}

	private function is_platform_active( $platform ) {
		// Compare $platform to active platforms in database.
	}

	private function is_connected( $platform ) {
		// Send a test request to the provided platform.
	}
}
