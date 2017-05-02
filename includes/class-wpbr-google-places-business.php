<?php

/**
 * Defines the WPBR_Google_Places_Business subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Business object for Google Places.
 *
 * @since 1.0.0
 * @see WPBR_Business
 */
class WPBR_Google_Places_Business extends WPBR_Business {

	/**
	 * Sets properties from remote API call.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {

		$api_call = new WPBR_Google_Places_API_Call( $this->business_id );

		$body = $api_call->get_response_body();

		$this->name = $body['result']['name'];

		$this->platform_url = $body['result']['url'];

		$this->image_url = add_query_arg( array(
			'maxheight'      => '192',
			'photoreference' => $body['result']['photos'][0]['photo_reference'],
			'key'            => GOOGLE_PLACES_API_KEY,
		), 'https://maps.googleapis.com/maps/api/place/photo' );

		$this->rating = $body['result']['rating'];

		// Set to -1 because review count not available in Google Places API.
		$this->review_count = -1;

		$this->phone = $body['result']['formatted_phone_number'];

		$this->location = array(
			'city'      => $body['result']['address_components'][3]['short_name'],
			'country'   => $body['result']['address_components'][6]['short_name'],
			'latitude'  => $body['result']['geometry']['location']['lat'],
			'longitude' => $body['result']['geometry']['location']['lng'],
			'state'     => $body['result']['address_components'][5]['short_name'],
			'street'    => $body['result']['address_components'][0]['short_name'] . ' ' . $body['result']['address_components'][1]['short_name'],
			'zip'       => $body['result']['address_components'][7]['short_name'],
		);

	}

}
