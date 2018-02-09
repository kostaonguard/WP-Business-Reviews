<?php
/**
 * Defines the Platform_Manager class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes;

use WP_Business_Reviews\Includes\Serializer\Option_Serializer;
use WP_Business_Reviews\Includes\Request\Request_Factory;
use WP_Business_Reviews\Includes\Deserializer\Option_Deserializer;

/**
 * Manages the existing, active, and connected platforms.
 *
 * @since 0.1.0
 */
class Platform_Manager {
	/**
	 * Settings saver.
	 *
	 * @since 0.1.0
	 * @var Option_Serializer $serializer
	 */

	/**
	 * Settings retriever.
	 *
	 * @since 0.1.0
	 * @var Option_Deserializer $deserializer
	 */

	/**
	 * Request factory.
	 *
	 * @since 0.1.0
	 * @var Request_Factory $request_factory
	 */

	/**
	 * All platforms.
	 *
	 * @since 0.1.0
	 * @var array $platforms
	 */
	private $platforms;

	/**
	 * Default platforms.
	 *
	 * @since 0.1.0
	 * @var array $default_platforms
	 */
	private $default_platforms;

	/**
	 * Active platforms.
	 *
	 * @since 0.1.0
	 * @var array $active_platforms
	 */
	private $active_platforms;

	/**
	 * Connected platforms.
	 *
	 * @since 0.1.0
	 * @var array $connected_platforms
	 */
	private $connected_platforms;

	/**
	 * Instantiates the Platform_Manager object.
	 *
	 * @param Option_Deserializer $deserializer     Settings retriever.
	 * @param Option_Serializer   $serializer       Settings saver.
	 * @param Request_Factory     $request_factory  Request factory.
	 */
	public function __construct(
		Option_Deserializer $deserializer,
		Option_Serializer $serializer,
		Request_Factory $request_factory
	) {
		$this->deserializer    = $deserializer;
		$this->serializer      = $serializer;
		$this->request_factory = $request_factory;

		/**
		 * Filters the array of registered platforms.
		 *
		 * @since 0.1.0
		 */
		$this->platforms = apply_filters(
			'wp_business_reviews_platforms',
			array(
				'google_places' => __( 'Google', 'wp-business-reviews' ),
				'facebook'      => __( 'Facebook', 'wp-business-reviews' ),
				'yelp'          => __( 'Yelp', 'wp-business-reviews' ),
				'yp'            => __( 'YP', 'wp-business-reviews' ),
			)
		);

		/**
		 * Filters the array of default platforms.
		 *
		 * @since 0.1.0
		 */
		$this->default_platforms = apply_filters(
			'wp_business_reviews_default_platforms',
			array(
				'google_places',
				'facebook',
				'yelp',
			)
		);
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

		add_action( 'wp_business_reviews_settings_platforms', array( $this, 'get_platforms' ) );
		add_action( 'wp_business_reviews_settings_default_platforms', array( $this, 'get_default_platforms' ) );
	}

	/**
	 * Gets all registered platforms.
	 *
	 * @since 0.1.0
	 *
	 * @return array Array of platform slugs.
	 */
	public function get_platforms() {
		return $this->platforms;
	}

	/**
	 * Gets the default platforms.
	 *
	 * @since 0.1.0
	 *
	 * @return array Array of default platform slugs.
	 */
	public function get_default_platforms() {
		return array_intersect_key( $this->platforms, $this->default_platforms );
	}

	/**
	 * Gets the active platforms.
	 *
	 * If active platforms have not been set, they will be retrieved from the
	 * database.
	 *
	 * @since 0.1.0
	 *
	 * @return array Array of active platform slugs.
	 */
	public function get_active_platforms() {
		if ( isset( $this->active_platforms ) ) {
			$active_platforms = $this->active_platforms;
		} else {
			$active_platforms = $this->deserializer->get( 'active_platforms' ) ?: array();
		}

		return array_intersect_key( $this->platforms, $active_platforms );
	}

	/**
	 * Gets the currently connected platforms.
	 *
	 * If connected platforms have not been set, they will be retrieved from the
	 * database. Each platform has its own status key in the database, so this
	 * method will retrieve the options and combine statuses into one array.
	 *
	 * @since 0.1.0
	 *
	 * @return array Array of connected platform slugs.
	 */
	public function get_connected_platforms() {
		if ( isset( $this->connected_platforms ) ) {
			$connected_platforms = $this->connected_platforms;
		} else {
			$connected_platforms = array();

			foreach ( $this->platforms as $platform => $platform_name ) {
				$platform_status = $this->deserializer->get(
					"{$platform}_platform_status"
				);

				if (
					isset( $platform_status['status'] )
					&& 'connected' === $platform_status['status']
				) {
					$connected_platforms[ $platform ] = $platform_name;
				}
			}
		}

		return array_intersect_key( $this->platforms, $connected_platforms );
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
		if ( ! $this->is_active( $platform ) ) {
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
	private function is_active( $platform ) {
		return in_array( $platform, array_keys( $this->get_active_platforms() ) );
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
