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
		// Most platforms have their status saved after settings are saved.
		add_action( 'wp_business_reviews_saved_settings',array( $this, 'save_platform_status' ) );

		// Facebook is a special case because it needs to save status when the token is saved, after redirect.
		add_action( 'wp_business_reviews_facebook_user_token_saved', array( $this, 'save_facebook_platform_status' ) );
	}

	/**
	 * Saves the connection status of a platform.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform The platform slug.
	 * @return boolean True if status saved, false otherwise.
	 */
	public function save_platform_status( $platform ) {
		if ( ! $this->is_active_platform( $platform ) ) {
			return false;
		}

		if ( $this->is_connected( $platform ) ) {
			$status = 'connected';
		} else {
			$status = 'disconnected';
		}

		return $this->serializer->save(
			$platform . '_platform_status',
			array(
				'status'       => $status,
				'last_checked' => time(),
			)
		);
	}

	/**
	 * Saves the connection status of the Facebook platform.
	 *
	 * Since Facebook saves a token following a redirect, providing the
	 * platform with its own method allows the status to be checked immediately
	 * after the token is saved.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform The platform slug.
	 * @return boolean True if status saved, false otherwise.
	 */
	public function save_facebook_platform_status() {
		$this->save_platform_status( 'facebook' );
	}

	/**
	 * Determines if platform has been marked active by the user.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform The platform slug.
	 */
	private function is_active_platform( $platform ) {
		return in_array( $platform, $this->active_platforms );
	}

	/**
	 * Determines if a valid connection can be made to a platform.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform The platform slug.
	 */
	private function is_connected( $platform ) {
		$request = $this->request_factory->create( $platform );

		return $request->is_connected();
	}
}
