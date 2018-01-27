<?php
/**
 * Defines the Blueprint_Serializer class
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
class Blueprint_Serializer extends Post_Serializer {
	/**
	 * @inheritDoc
	 */
	protected $post_type = 'wpbr_blueprint';

	/**
	 * @inheritDoc
	 */
	protected $post_key = 'wp_business_reviews_settings';

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_business_reviews_save_wpbr_review_source_from_builder', array( $this, 'set_post_parent' ) );
		add_action( 'admin_post_wp_business_reviews_save_builder', array( $this, 'save_from_post_array' ), 20 );
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
			'post_parent' => $this->post_parent,
		);

		if ( ! isset( $post_array['post_title'] ) ) {
			$post_array['post_title'] = 'test blueprint';
		}

		foreach ( $raw_data as $key => $value ) {
			switch ( $key ) {
				case 'title':
					$post_array['post_title'] = $this->clean( $value );
					break;
				case 'platform':
					$post_array['tax_input']['wpbr_platform'] = $this->clean( $value );
					break;
				case 'format':
				case 'max_columns':
				case 'theme':
					$post_array['meta_input'][ $this->prefix . $key ] = $this->clean( $value );
					break;
			}
		}

		return $post_array;
	}
}
