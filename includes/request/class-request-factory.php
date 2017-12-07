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

/**
 * Creates new requests based on platform, business, and type.
 *
 * @since 0.1.0
 */
class Request_Factory {
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
	public function create( $platform, $business_id ) {
		switch ( $platform ) {
			case 'google_places' :
				return new Google_Places_Request( $platform, $business_id );
			case 'facebook' :
				return new Facebook_Request( $platform, $business_id );
			case 'yelp' :
				return new Yelp_Request( $platform, $business_id );
			case 'yp' :
				return new YP_Request( $platform, $business_id );
			case 'wp_org' :
				return new WP_Org_Request( $platform, $business_id );
		}
	}
}
