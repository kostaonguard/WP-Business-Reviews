<?php
/**
 * Defines the Option_Repository class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Repository;

/**
 * Holds option values retrieved from the WordPress database.
 *
 * @since 0.1.0
 */
class Option_Repository extends Repository {
	/**
	 * Gets an option by its primary key or identifier.
	 *
	 * If the option does not exist in the repository, it will be retrieved
	 * from the WordPress database or object cache.
	 *
	 * @since 0.1.0
	 *
	 * @param string $option_name Name of the option to return.
	 * @param mixed  $default     Optional. Default value to return if the option does not exist.
	 * @return mixed A single value from the repository.
	 */
	public function get( $option_name, $default = false ) {
		if ( $this->has( $option_name ) ) {
			return $this->values[ $option_name ];
		} else {
			return get_option( $option_name, $default );
		}
	}
}
