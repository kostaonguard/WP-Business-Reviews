<?php
/**
 * Defines the Facebook_Response_Normalizer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request\Response_Normalizer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request\Response_Normalizer;

/**
 * Normalizes the structure of a Facebook API response.
 *
 * @since 0.1.0
 */
class Facebook_Response_Normalizer extends Response_Normalizer_Abstract {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'facebook';

	/**
	 * @inheritDoc
	 */
	public function normalize_review_source( array $raw_review_source ) {
		$r          = $raw_review_source;
		$normalized = array();

		// Set ID of the review source on the platform.
		if ( isset( $r['id'] ) ) {
			$normalized['review_source_id'] = $this->clean( $r['id'] );

			// Use the ID to construct the icon URL.
			$normalized['icon'] = $this->generate_icon_url(
				$normalized['review_source_id']
			);
		}

		// Set name.
		if ( isset( $r['name'] ) ) {
			$normalized['name'] =  $this->clean( $r['name'] );
		}

		// Set page URL.
		if ( isset( $r['link'] ) ) {
			$normalized['url'] = $this->clean( $r['link'] );
		}

		// Set rating.
		if ( isset( $r['overall_star_rating'] ) ) {
			$normalized['rating'] = $this->clean( $r['overall_star_rating'] );
		}

		// Set rating count.
		if ( isset( $r['rating_count'] ) ) {
			$normalized['rating_count'] = $this->clean( $r['rating_count'] );
		}

		// Set image.
		if ( isset( $r['cover']['source'] ) ) {
			$normalized['image'] = $this->clean( $r['cover']['source'] );
		}

		// Set phone.
		if ( isset( $r['phone'] ) ) {
			$normalized['phone'] =  $this->clean( $r['phone'] );
		}

		// Set formatted address.
		if ( isset( $r['single_line_address'] ) ) {
			$normalized['formatted_address'] = $this->clean( $r['single_line_address'] );
		}

		// Set street address.
		if ( isset( $r['location']['street'] ) ) {
			$normalized['street_address'] = $this->clean( $r['location']['street'] );
		}

		// Set city.
		if ( isset( $r['location']['city'] ) ) {
			$normalized['city'] = $this->clean( $r['location']['city'] );
		}

		// Set state.
		if ( isset( $r['location']['state'] ) ) {
			$normalized['state_province'] = $this->clean( $r['location']['state'] );
		}

		// Set postal code.
		if ( isset( $r['location']['zip'] ) ) {
			$normalized['postal_code'] = $this->clean( $r['location']['zip'] );
		}

		// Set country.
		if ( isset( $r['location']['country'] ) ) {
			$normalized['country'] = $this->clean( $r['location']['country'] );
		}

		// Set latitude.
		if ( isset( $r['location']['latitude']) ) {
			$normalized['latitude'] = $this->clean( $r['location']['latitude'] );
		}

		// Set longitude.
		if ( isset( $r['location']['longitude']) ) {
			$normalized['longitude'] = $this->clean( $r['location']['longitude'] );
		}

		// Merge normalized properties with default properites in case any are missing.
		$normalized = wp_parse_args( $normalized, $this->get_review_source_defaults() );

		return $normalized;
	}

	/**
	 * @inheritDoc
	 */
	public function normalize_review( array $raw_review ) {
		$r          = $raw_review;
		$normalized = array();

		// Set review URL.
		if ( isset( $r['open_graph_story']['id'] ) ) {
			$normalized['review_url'] = $this->generate_review_url(
				$this->clean( $r['open_graph_story']['id'] )
			);
		}

		// Set reviewer.
		if ( isset( $r['reviewer']['name'] ) ) {
			$normalized['reviewer'] = $this->clean( $r['reviewer']['name'] );
		}

		// Set reviewer image.
		if ( isset( $r['reviewer']['picture']['data']['url'] ) ) {
			$normalized['reviewer_image'] = $this->clean(
				$r['reviewer']['picture']['data']['url']
			);
		}

		// Set rating.
		if ( isset( $r['rating'] ) ) {
			$normalized['rating'] = $this->clean( $r['rating'] );
		}

		// Set timestamp.
		if ( isset( $r['created_time'] ) ) {
			$normalized['timestamp'] = $this->clean( $r['created_time'] );
		}

		// Set content.
		if ( isset( $r['review_text'] ) ) {
			$normalized['content'] = $this->clean_multiline( $r['review_text'] );
		}

		// Merge normalized properties with default properites in case any are missing.
		$normalized = wp_parse_args( $normalized, $this->get_review_defaults() );

		return $normalized;
	}

	/**
	 * Generates the review URL using the review's Open Graph Story ID.
	 *
	 * @since 0.1.0
	 *
	 * @param int $id The Facebook review's Open Graph Story ID.
	 * @return string URL of the review.
	 */
	private function generate_review_url( $open_graph_story_id ) {
		return "https://www.facebook.com/{$open_graph_story_id}";
	}

	/**
	 * Generates the icon URL using the Facebook Page ID.
	 *
	 * @since 0.1.0
	 *
	 * @param int $id The Facebook Page ID.
	 * @return string URL of the Page icon.
	 */
	private function generate_icon_url( $page_id ) {
		return "https://graph.facebook.com/{$page_id}/picture";
	}
}
