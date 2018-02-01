<?php
/**
 * Defines the Deserializer_Abstract class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Deserializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Deserializer;

/**
 * Retrieves values from the database.
 *
 * @since 0.1.0
 */
abstract class Deserializer_Abstract {
	/**
	 * The prefix prepended to the retrieved key.
	 *
	 * @since 0.1.0
	 * @var string $prefix
	 */
	protected $prefix = 'wp_business_reviews_';

	/**
	 * Retrieves a value from the database.
	 *
	 * @since 0.1.0
	 *
	 * @param string $option  Name of option to retrieve.
	 * @param mixed  $default Optional. Default value to return if the option does not exist.
	 * @return mixed Value set for the option.
	*/
	abstract public function get( $key, $default = false );
}
