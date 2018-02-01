<?php
/**
 * Defines the Request_Factory class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

use WP_Business_Reviews\Includes\Deserializer\Option_Deserializer;

/**
 * Creates a new request based on the provided platform.
 *
 * @since 0.1.0
 */
class Request_Factory {
	/**
	 * Retriever of information from the database.
	 *
	 * @since 0.1.0
	 * @var Option_Deserializer $deserializer
	 */
	private $deserializer;

	/**
	 * Instantiates a Request_Factory object.
	 *
	 * @param Option_Deserializer $deserializer Retriever of options from the database.
	 */
	public function __construct( Option_Deserializer $deserializer ) {
		$this->deserializer = $deserializer;
	}

	/**
	 * Creates a new request based on the provided platform.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform Reviews platform used in the request.
	 * @return Request Instance of Request for the provided platform.
	 */
	public function create( $platform ) {
		switch ( $platform ) {
			case 'google_places':
				$key     = $this->deserializer->get( 'google_places_api_key', '' );
				$request = new Google_Places_Request( $key );
				break;
			case 'facebook':
				$user_token = $this->deserializer->get( 'facebook_user_token', '' );
				$pages      = $this->deserializer->get( 'facebook_pages' ) ?: array();
				$request    = new Facebook_Request( $user_token, $pages );
				break;
			case 'yelp':
				$key     = $this->deserializer->get( 'yelp_api_key', '' );
				$request = new Yelp_Request( $key );
				break;
			case 'yp':
				$key     = $this->deserializer->get( 'yp_api_key', '' );
				$request = new YP_Request( $key );
				break;
			case 'wp_org':
				// $request = new WP_Org_Request();
				break;
		}

		return $request;
	}
}
