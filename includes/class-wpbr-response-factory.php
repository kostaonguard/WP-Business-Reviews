<?php

/**
 * Defines the WPBR_Response_Factory class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Determines which type of API response is required based on the platform.
 *
 * Each reviews platform API has unique characteristics, from the structure of
 * the request URL to the API response. This factory class determines the most
 * appropriate subclass to process the API response based on the platform.
 *
 * @since 1.0.0
 */
class WPBR_Response_Factory {

	/**
	 * Creates a WPBR_Response object that is appropriate for the platform.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business.
	 * @param string $platform Reviews platform associated with the business.
	 *
	 * @return WPBR_Response Normalized data from the reviews platform API.
	 */
	public static function create( $business_id, $platform ) {

		switch ( $platform ) {

			case 'google_places' :

				return new WPBR_Google_Places_Response( $business_id );

			case 'facebook' :

				return new WPBR_Facebook_Response( $business_id );

			case 'yelp' :

				return new WPBR_Yelp_Response( $business_id );

			case 'yp' :

				return new WPBR_YP_Response( $business_id );

		}

	}

}
