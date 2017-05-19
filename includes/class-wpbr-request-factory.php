<?php

/**
 * Defines the WPBR_Request_Factory class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Determines the appropriate WPBR_Request subclass based on platform.
 *
 * @since 1.0.0
 */
class WPBR_Request_Factory {

	/**
	 * Creates a new instance of the WPBR_Request subclass.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business on the platform.
	 * @param string $platform    Reviews platform used in the request.
	 *
	 * @return WPBR_Request Instance of WPBR_Request for the provided platform.
	 */
	public static function create( $business_id, $platform ) {

		switch ( $platform ) {

			case 'google_places' :

				return new WPBR_Google_Places_Request( $business_id, $platform );

			case 'facebook' :

				return new WPBR_Facebook_Request( $business_id, $platform );

			case 'yelp' :

				return new WPBR_Yelp_Request( $business_id, $platform );

			case 'yp' :

				return new WPBR_YP_Request( $business_id, $platform );

		}

	}

}
