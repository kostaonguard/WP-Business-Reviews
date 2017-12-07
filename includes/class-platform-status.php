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
	 * Request factory.
	 *
	 * @since 0.1.0
	 * @var Request_Factory $request_factory
	 */

	/**
	 * Active platforms.
	 *
	 * @since 0.1.0
	 * @var array $active_platforms
	 */

	private $serializer;

	/**
	 * Instantiates the Platform_Status object.
	 *
	 * @param Serializer      $serializer       Settings saver.
	 * @param Request_Factory $request_factory  Request factory.
	 * @param array           $active_platforms Active platforms.
	 */
	public function __construct(
		Serializer $serializer,
		Request_Factory $request_factory,
		array $active_platforms
	) {
		$this->serializer       = $serializer;
		$this->request_factory  = $request_factory;
		$this->active_platforms = $active_platforms;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_business_reviews_saved_settings', array( $this, 'save_platform_status' ) );
	}

	public function save_platform_status( $platform ) {
		error_log( print_r( 'save_platform_status', true ) );

		if ( $this->is_active_platform( $platform ) && $this->is_connected( $platform ) ) {
			error_log( print_r( $platform . ' is active!', true ) );
		} else {
			error_log( print_r( $platform . ' is NOT active!', true ) );
		}
	}

	private function is_active_platform( $platform ) {
		return in_array( $platform, $this->active_platforms );
	}

	private function is_connected( $platform ) {
		$request = $this->request_factory->create( $platform );
		return $request->is_connected();
	}
}
