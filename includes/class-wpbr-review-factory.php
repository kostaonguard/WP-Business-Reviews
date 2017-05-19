<?php

/**
 * Defines the WPBR_Review_Factory class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Determines the appropriate WPBR_Review subclass based on platform.
 *
 * @since 1.0.0
 */
class WPBR_Review_Factory {

	/**
	 * Creates a new instance of the WPBR_Review subclass.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business.
	 * @param string $platform Reviews platform associated with the business.
	 *
	 * @return WPBR_Review Instance of WPBR_Review for the provided platform.
	 */
	public static function create( $business_id, $platform ) {

		switch ( $platform ) {

			case 'google_places' :

				return new WPBR_Google_Places_Review( $business_id );

			case 'facebook' :

				return new WPBR_Facebook_Review( $business_id );

			case 'yelp' :

				return new WPBR_Yelp_Review( $business_id );

			case 'yp' :

				return new WPBR_YP_Review( $business_id );

		}

	}

}
