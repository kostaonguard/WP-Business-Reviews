<?php
/**
 * Defines the Reviews_Builder_Launcher class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Reviews_Builder
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Reviews_Builder;

use WP_Business_Reviews\Includes\View;


/**
 * Allows the user to select a platform or existing reviews set when they enter
 * the Reviews Builder.
 *
 * @since 0.1.0
 */
class Reviews_Builder_Launcher {
	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_business_reviews_admin_page_wpbr_reviews_builder', array( $this, 'init' ) );
	}

	/**
	 * Initializes the object for use.
	 *
	 * There are three possible scenarios when the Reviews Builder is loaded:
	 *
	 * 1. An existing review set is defined in the URL, so load it.
	 * 2. A platform is defined but not a review set, so display empty builder
	 *    that is configured for that platform.
	 * 3. Neither a review set or platform is defined, so display the launcher.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		if( isset( $_GET['wpbr-review-set'], $_GET['wpbr-platform'] ) ) {
			$this->review_set = sanitize_text_field( $_GET['wpbr-review-set'] );
			$this->platform = sanitize_text_field( $_GET['wpbr-platform'] );
		} else {
			$this->render();
		}
	}

	/**
	 * Renders the Reviews Builder launcher.
	 *
	 * @since  0.1.0
	 */
	public function render() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/reviews-builder/reviews-builder-launcher.php' );
		$view_object->render();
	}
}
