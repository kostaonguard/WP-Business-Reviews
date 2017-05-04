<?php

/**
 * Defines the WPBR_YP_Business subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Business object for YP.
 *
 * @since 1.0.0
 * @see WPBR_Business
 */
class WPBR_YP_Business extends WPBR_Business {

	/**
	 * Sets properties from remote API call.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {

		// Call the API.
		$api_call = new WPBR_YP_Business_API_Call( $this->business_id );

		// Get JSON-decoded response.
		$body = $api_call->get_response_body();

		// Drill down to the relevant part of the response.
		$listing_detail = $body['listingsDetailsResult']['listingsDetails']['listingDetail'][0];

		// Set properties from API response.
		$this->set_name_from_api( $listing_detail );
		$this->set_platform_url_from_api( $listing_detail );
		$this->set_image_url_from_api( $listing_detail );
		$this->set_rating_from_api( $listing_detail );
		$this->set_rating_count_from_api( $listing_detail );
		$this->set_phone_from_api( $listing_detail );
		$this->set_latitude_from_api( $listing_detail );
		$this->set_longitude_from_api( $listing_detail );
		$this->set_street_address_from_api( $listing_detail );
		$this->set_city_from_api( $listing_detail );
		$this->set_state_province_from_api( $listing_detail );
		$this->set_postal_code_from_api( $listing_detail );

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_name_from_api( $listing_detail ) {

		$this->name = isset( $listing_detail['businessName'] ) ? $listing_detail['businessName'] : '';

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_platform_url_from_api( $listing_detail ) {

		$this->platform_url = isset( $listing_detail['moreInfoURL'] ) ? $listing_detail['moreInfoURL'] : '';

	}

	/**
	 * Set image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_image_url_from_api( $listing_detail ) {

		if ( isset( $listing_detail['id'] ) ) {

			$this->image_url = "https://graph.facebook.com/v2.9/{$listing_detail['id']}/picture/?height=192";

		}

	}

	/**
	 * Set rating from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_rating_from_api( $listing_detail ) {

		$this->rating = isset( $listing_detail['averageRating'] ) ? $listing_detail['averageRating'] : '';

	}

	/**
	 * Set rating count from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_rating_count_from_api( $listing_detail ) {

		$this->rating_count = isset( $listing_detail['ratingCount'] ) ? $listing_detail['ratingCount'] : '';

	}

	/**
	 * Set phone number from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_phone_from_api( $listing_detail ) {

		$this->phone = isset( $listing_detail['phone'] ) ? $listing_detail['phone'] : '';

	}

	/**
	 * Set latitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_latitude_from_api( $listing_detail ) {

		$this->latitude = isset( $listing_detail['latitude'] ) ? $listing_detail['latitude'] : '';

	}

	/**
	 * Set longitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_longitude_from_api( $listing_detail ) {

		$this->longitude = isset( $listing_detail['longitude'] ) ? $listing_detail['longitude'] : '';

	}

	/**
	 * Set street address from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_street_address_from_api( $listing_detail ) {

		$this->street_address = isset( $listing_detail['street'] ) ? $listing_detail['street'] : '';

	}

	/**
	 * Set city from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_city_from_api( $listing_detail ) {

		$this->city = isset( $listing_detail['city'] ) ? $listing_detail['city'] : '';

	}

	/**
	 * Set state/province from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_state_province_from_api( $listing_detail ) {

		$this->state_province = isset( $listing_detail['state'] ) ? $listing_detail['state'] : '';

	}

	/**
	 * Set postal code from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_postal_code_from_api( $listing_detail ) {

		$this->postal_code = isset( $listing_detail['zip'] ) ? $listing_detail['zip'] : '';

	}

	/**
	 * Set country from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $listing_detail Relevant portion of the response body.
	 */
	protected function set_country_from_api( $listing_detail ) {

		// YP API does not include country.
		$this->country = '';

	}

}
