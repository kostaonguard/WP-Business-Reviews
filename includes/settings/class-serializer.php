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
		add_action( 'admin_post_wp_business_reviews_save_settings', array( $this, 'save' ) );
	}

	/**
	 * Saves settings to database.
	 *
	 * @since 0.1.0
	 */
	public function save() {
		echo '<pre>' . var_dump($_POST) . '</pre>';
		// TODO: First, validate the nonce.
        // TODO: Secondly, verify the user has permission to save.
		// If the above are valid, save the option.
		if ( ! empty( $_POST['wp_business_reviews_settings'] ) ) {
			foreach ( $_POST['wp_business_reviews_settings'] as $option => $new_value ) {
				// TODO: Sanitize value before saving.
				update_option( 'wpbr_' . $option, $new_value );
			}
		}
	}
	}
}
