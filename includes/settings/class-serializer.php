<?php
/**
 * Defines the Serializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

/**
 * Saves settings to the database.
 *
 * @since 0.1.0
 */
class Serializer {
	/**
	* Registers functionality with WordPress hooks.
	*
	* @since 0.1.0
	*/
	public function register() {
		add_action( 'admin_post', array( $this, 'save' ) );
	}

	/**
	 * Saves settings to database.
	 *
	 * @return void
	 */
	public function save() {
		// First, validate the nonce.
        // Secondly, verify the user has permission to save.
        // If the above are valid, save the option.
	}
}
