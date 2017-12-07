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

use WP_Business_Reviews\Includes\Request\Request_Base;
use WP_Business_Reviews\Includes\Settings\Settings;
use WP_Business_Reviews\Includes\Settings\Deserializer;

/**
 * Creates new requests based on platform, business, and type.
 *
 * @since 0.1.0
 */
class Request_Factory {
	/**
	 * Retriever of information from the database.
	 *
	 * @since 0.1.0
	 * @var Deserializer $deserializer
	 */
	private $deserializer;

	/**
	 * Instantiates a Request_Factory object.
	 *
	 * @param Deserializer $deserializer Retriever of information from the database.
	 */
	public function __construct( Deserializer $deserializer ) {
		$this->deserializer = $deserializer;
	}

	/**
	 * Creates a new request based on the provided platform.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform    Reviews platform used in the request.
	 * @param string $business_id ID of the business on the platform.
	 *
	 * @return Request_Base Instance of Request for the provided platform.
	 */
	public function create( $platform ) {
		switch ( $platform ) {
			case 'google_places':
				$key     = $this->deserializer->get( 'api_key_google_places' );
				$request = new Google_Places_Request( $key );
				break;
			case 'facebook':
				// TODO: Get token via deserializer.
				// $request = new Facebook_Request( $token );
				break;
			case 'yelp':
				$client_id     = $this->deserializer->get( 'yelp_client_id' );
				$client_secret = $this->deserializer->get( 'yelp_client_secret' );
				$token         = $this->deserializer->get( 'yelp_token' );
				$request       = new Yelp_Request( $client_id, $client_secret, $token );
				break;
			case 'yp':
				$key     = $this->deserializer->get( 'api_key_yp' );
				$request = new YP_Request( $key );
				break;
			case 'wp_org':
				// $request = new WP_Org_Request();
				break;
		}

		return $request;
	}
}
