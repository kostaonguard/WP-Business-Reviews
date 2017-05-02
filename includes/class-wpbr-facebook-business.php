<?php

/**
 * Defines the WPBR_Facebook_Business subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Business object for Facebook.
 *
 * @since 1.0.0
 * @see WPBR_Business
 */
class WPBR_Facebook_Business extends WPBR_Business {

	/**
	 * Sets properties from remote API call.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {

		$api_call = new WPBR_Facebook_API_Call( $this->business_id );

		$body = $api_call->get_response_body();

		$this->name = $body['name'];

		$this->platform_url = $body['link'];

		$this->image_url = "https://graph.facebook.com/v2.9/{$this->business_id}/picture/?height=192";

		$this->rating = $body['overall_star_rating'];

		$this->rating_count = $body['rating_count'];

		$this->phone = $body['phone'];

		$this->location = array(
			'city'      => $body['location']['city'],
			'country'   => $body['location']['country'],
			'latitude'  => $body['location']['latitude'],
			'longitude' => $body['location']['longitude'],
			'state'     => $body['location']['state'],
			'street'    => $body['location']['street'],
			'zip'       => $body['location']['zip'],
		);

	}

}
