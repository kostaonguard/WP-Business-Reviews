<?php

/**
 * Defines the WP_Org_Request subclass
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Request;
use WP_Error;

/***
 * Requests data from the WordPress.org API.
 *
 * @since 1.0.0
 * @see   Request
 */
class WP_Org_Request extends Request {

	/**
	 * Reviews platform used in the request.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'wp_org';

	/**
	 * API host used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_host = 'https://api.wordpress.org';

	/**
	 * Path used in the business request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_path;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business passed in the API request.
	 */
	public function __construct( $business_id ) {
		$this->business_id = $business_id;
		$this->business_path = "/plugins/info/1.0/{$business_id}.json";
	}

	/**
	 * Requests business data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return array|WP_Error Business data or WP_Error on failure.
	 */
	public function request_business() {
		// Request data from remote API.
		$response = $this->request( $this->business_path );

		return $response;
	}

	/**
	 * Standardize business response.
	 *
	 * @since 1.0.0
	 * @see Business
	 *
	 * @param array $response Business data from remote API.
	 *
	 * @return array|WP_Error Standardized business properties or WP_Error if
	 *                        response structure does not meet expectations.
	 */
	public function standardize_business( array $response ) {
		if ( empty( $response ) ) {
			return new WP_Error( 'invalid_response_structure', __( 'Response could not be standardized.', 'wpbr' ) );
		} else {
			$r = $response;
		}

		// Set defaults.
		$business = array(
			'platform'      => $this->platform,
			'business_id'   => $this->business_id,
			'business_name' => null,
			'meta'          => array(
				'wpbr_page_url'          => null,
				'wpbr_image_url'         => null,
				'wpbr_banner_image_url'  => null,
				'wpbr_rating'            => null,
				'wpbr_ratings'           => array(),
				'wpbr_rating_count'      => null,
				'wpbr_author_name'       => null,
				'wpbr_author_url'        => null,
				'wpbr_version'           => null,
				'wpbr_wp_min_version'    => null,
				'wpbr_wp_tested_version' => null,
				'wpbr_web_url'           => null,
			),
		);

		// Set business name.
		if ( isset( $r['name'] ) ) {
			$business['business_name'] = sanitize_text_field( $r['name'] );
		}

		// Set page URL.
		$business['meta']['wpbr_page_url'] = "https://wordpress.org/plugins/{$this->business_id}/";

		// Set icon image URL.
		$business['meta']['wpbr_image_url'] = "https://ps.w.org/{$this->business_id}/assets/icon-256x256.jpg";

		// Set banner image URL.
		$business['meta']['wpbr_banner_image_url'] = "https://ps.w.org/{$this->business_id}/assets/banner-1544x500.jpg";

		// Set rating.
		if (
			isset( $r['rating'] )
			&& is_numeric( $r['rating'] )
		) {
			$business['meta']['wpbr_rating'] = $r['rating'];
		}

		// Set ratings.
		if ( is_array( $r['ratings'] ) ) {
			for( $i = 5; $i > 0; $i-- ) {
				$business['meta']['wpbr_ratings'][ $i ] = intval( $r['ratings'][$i] );
			}
		}

		// Set rating count.
		if (
			isset( $r['num_ratings'] )
			&& is_int( $r['num_ratings'] )
		) {
			$business['meta']['wpbr_rating_count'] = $r['num_ratings'];
		}

		// Set author name.
		if ( isset( $r['author'] ) ) {
			$business['meta']['wpbr_author_name'] = sanitize_text_field( $r['author'] );
		}

		// Set author URL.
		if (
			isset( $r['author_profile'] )
			&& filter_var( $r['author_profile'], FILTER_VALIDATE_URL )
		) {
			$business['meta']['wpbr_author_url'] = $r['author_profile'];
		}

		// Set version.
		if ( isset( $r['version'] ) ) {
			$business['meta']['wpbr_version'] = sanitize_text_field( $r['version'] );
		}

		// Set minimum required WordPress version.
		if ( isset( $r['requires'] ) ) {
			$business['meta']['wpbr_wp_min_version'] = sanitize_text_field( $r['requires'] );
		}

		// Set last tested WordPress version.
		if ( isset( $r['tested'] ) ) {
			$business['meta']['wpbr_wp_tested_version'] = sanitize_text_field( $r['tested'] );
		}

		// Set website URL.
		if (
			isset( $r['homepage'] )
			&& filter_var( $r['homepage'], FILTER_VALIDATE_URL )
		) {
			$business['meta']['wpbr_web_url'] = $r['homepage'];
		}

		return $business;
	}

}
