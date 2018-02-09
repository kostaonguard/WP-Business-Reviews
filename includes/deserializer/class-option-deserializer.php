<?php
/**
 * Defines the Option_Deserializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Deserializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Deserializer;

/**
 * Retrieves options from the database.
 *
 * @since 0.1.0
 */
class Option_Deserializer {
	/**
	 * The prefix prepended to the retrieved key.
	 *
	 * @since 0.1.0
	 * @var string $prefix
	 */
	protected $prefix = 'wp_business_reviews_';

	/**
	 * Retrieves an option from the database.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key  Name of option to retrieve.
	 * @param mixed  $default Optional. Default value to return if the option does
	 *                        not exist.
	 * @return mixed Value associated with the key.
	 */
	public function get( $key, $default = false ) {
		return get_option( $this->prefix . $key, $default );
	}
}
