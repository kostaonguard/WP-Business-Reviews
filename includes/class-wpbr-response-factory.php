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
					'key'     => 'AIzaSyAjtk8Puo1jhDO1nije8dYIRN5rgN23qzs', // Hard-coded temporarily.

				);

				return new WPBR_Google_Places_Response( $platform, $business_id, $request_url_base, $request_url_parameters );

			case 'facebook' :

				return new WPBR_Facebook_Response( $platform, $business_id );

			case 'yelp' :

				return new WPBR_Yelp_Response( $platform, $business_id );

			case 'yp' :

				return new WPBR_YP_Response( $platform, $business_id );

		}

	}

}
