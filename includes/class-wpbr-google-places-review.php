<?php

/**
 * Defines the WPBR_Google_Places_Review subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Google_Places_Review object.
 *
 * @since 1.0.0
 */
class WPBR_Google_Places_Review extends WPBR_Review {

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'google_places';

	/**
	 * Standardizes review data for a single review.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 *
	 * @return array Standardized properties and values.
	 */
	public function standardize_properties( $data ) {

		// Parse reviewer ID from reviewer URL.
		$reviewer_url = isset( $data['author_url'] ) ? $data['author_url'] : null;
		preg_match( '/contrib\/(.+)\/reviews/', $reviewer_url, $matches );
		$reviewer_id = $matches[1];

		// Build review URL using the reviewer ID and business ID.
		$review_url  = 'https://www.google.com/maps/contrib/' . $reviewer_id . '/place/' . $this->business_id;

		// Standardize data to match class properties.
		$properties = array(

			'review_id'          => null, // Unavailable.
			'rating'             => isset( $data['rating'] ) ? $data['rating'] : null,
			'review_title'       => null, // Unavailable.
			'review_text'        => isset( $data['text'] ) ? $data['text'] : null,
			'review_url'         => $review_url,
			'reviewer_name'      => isset( $data['author_name'] ) ? $data['author_name'] : null,
			'reviewer_image_url' => isset( $data['profile_photo_url'] ) ? $data['profile_photo_url'] : null,
			'time_created'       => isset( $data['time'] ) ? $data['time'] : null,

		);

		return $properties;

	}

}

