<?php
/**
 * Defines the Admin_Footer class
 *
 * @package WP_Business_Reviews\Includes\Admin
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the admin footer for the plugin.
 *
 * @since 1.0.0
 */
class Admin_Footer {
	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_filter( 'admin_footer_text', array( $this, 'render' ) );
	}

	/**
	 * Renders the admin header.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		$current_screen = get_current_screen();

		if ( ! empty( $current_screen->id ) && false !== strpos( $current_screen->id, 'wpbr' ) ) {
			$url             = 'https://wordpress.org/support/plugin/wp-business-reviews/reviews/?filter=5';
			$star_link       = '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">&#9733;&#9733;&#9733;&#9733;&#9733;</a>';
			$text_link_open  = '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">';
			$text_link_close = '</a>';
			$footer          = sprintf( esc_html__( 'If you enjoy WP Business Reviews, consider leaving us a %s on %sWordPress.org%s.', 'wpbr' ), $star_link, $text_link_open, $text_link_close );

			return $footer;
		}
	}
}
