<?php

/**
 * Determine the appropriate type of API response to request based on platform
 *
 * @link       https://wordimpress.com
 * @since      1.0.0
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 */

/**
 * Determine the appropriate type of API response to request based on platform.
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @author     WordImpress, LLC <info@wordimpress.com>
 */
class WPBR_Response_Factory {

	/**
	 * Initialize the concrete class that is appropriate for the platform.
	 *
	 * @since 1.0.0
	 *
	 * @param string $platform Reviews platform associated with the business.
	 * @param string $business_id ID of the business.
	 *
	 * @return WPBR_Response Normalized data from the reviews platform API.
	 */
	public static function create( $platform, $business_id ) {

		switch ( $platform ) {

			case 'google_places' :

				$request_url_base = 'https://maps.googleapis.com/maps/api/place/details/json';

				$request_url_parameters = array(

					'placeid' => $business_id,
					'key'     => GOOGLE_PLACES_API_KEY, // Constant is temporary for testing.

				);

				return new WPBR_Google_Places_Response( $platform, $business_id, $request_url_base, $request_url_parameters );

			case 'facebook' :

				$request_url_base = "https://graph.facebook.com/v2.9/{$business_id}/";

				$fields = array(
					'name',
					'overall_star_rating',
					'rating_count',
					'single_line_address',
					'phone',
					'hours',
					'ratings',
				);

				$fields_value = implode( ',', $fields );

				$request_url_parameters = array(

					'fields' => $fields_value,
					'access_token' => FACEBOOK_PAGE_ACCESS_TOKEN, // Constant is temporary for testing.

				);

				return new WPBR_Facebook_Response( $platform, $business_id, $request_url_base, $request_url_parameters );

			case 'yelp' :

				return new WPBR_Yelp_Response( $platform, $business_id );

			case 'yp' :

				return new WPBR_YP_Response( $platform, $business_id );

		}

	}

}
