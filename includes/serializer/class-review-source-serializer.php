<?php
/**
 * Defines the Review_Source_Serializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Serializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Serializer;

/**
 * Saves reviews to the database.
 *
 * @since 0.1.0
 */
class Review_Source_Serializer extends Post_Serializer {
	/**
	 * The post type being saved.
	 *
	 * @since 0.1.0
	 * @var string $post_type
	 */
	protected $post_type = 'wpbr_review_source';

	/**
	 * The $_POST key to which data is posted.
	 *
	 * @since 0.1.0
	 * @var string $post_key
	 */
	protected $post_key = 'wp_business_reviews_review_source';

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'admin_post_wp_business_reviews_save_builder', array( $this, 'save_from_post_json' ), 10 );
		add_action( 'admin_post_wp_business_reviews_save_builder', array( $this, 'redirect' ), 999 );
	}

	/**
	 * Prepares the post data in a ready-to-save format.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_data Raw, unstructured post data.
	 * @return array Array of elements that make up a post.
	 */
	public function prepare_post_array( array $raw_data ) {
		$post_array = array(
			'post_type'   => $this->post_type,
			'post_status' => 'publish',
			// 'post_parent' => $post_parent,
			'meta_input'  => array(
				// 'review_source_id' => $review_source_id,
			),
		);

		foreach ( $raw_data as $key => $value ) {
			switch ( $key ) {
				case 'name':
					$post_array['post_title'] = $this->clean( $value );
					break;
				case 'platform':
					$post_array['tax_input']['wpbr_platform'] = $this->clean( $value );
					break;
				case 'review_source_id':
				case 'url':
				case 'rating':
				case 'icon':
				case 'image':
				case 'phone':
				case 'formatted_address':
				case 'street_address':
				case 'city':
				case 'state_province':
				case 'postal_code':
				case 'country':
				case 'latitude':
				case 'longitude':
					if ( $value ) {
						$post_array['meta_input'][ $this->prefix . $key ] = $this->clean( $value );
					}
					break;
			}
		}

		return $post_array;
	}
}
