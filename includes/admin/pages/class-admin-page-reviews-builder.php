<?php
/**
 * Defines the Admin_Page_Reviews_Builder class
 *
 * @package WP_Business_Reviews\Includes\Admin\Pages
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Pages;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the Reviews Builder page for the plugin.
 *
 * @since 1.0.0
 * @see Admin_Page
 */
class Admin_Page_Reviews_Builder extends Admin_Page {
	public function render_page() {
		$view = WPBR_PLUGIN_DIR . 'includes/admin/pages/views/reviews-builder.php';
		include $view;
	}
}
