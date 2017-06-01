<?php

/**
 * Defines the Request_Factory class
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Request;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determines the appropriate Request subclass based on platform.
 *
 * @since 1.0.0
 * @see   Request
 */
class Request_Factory {

	/**
	 * Creates a new instance of the Request subclass.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business on the platform.
	 * @param string $platform    Reviews platform used in the request.
	 *
	 * @return Request Instance of Request for the provided platform.
	 */
	public static function create( $business_id, $platform ) {
		switch ( $platform ) {
			case 'google_places' :
				return new Google_Places_Request( $business_id, $platform );
			case 'facebook' :
				return new Facebook_Request( $business_id, $platform );
			case 'yelp' :
				return new Yelp_Request( $business_id, $platform );
			case 'yp' :
				return new YP_Request( $business_id, $platform );
			case 'wp_org' :
				return new WP_Org_Request( $business_id, $platform );
		}

	}

}
