<?php
/**
 * Defines the Admin_Page_Builder class
 *
 * @package WP_Business_Reviews\Includes\Admin\Pages
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Pages;

use WP_Business_Reviews\Includes\Admin\Builder\Builder_Controls;
use WP_Business_Reviews\Includes\Admin\Builder\Builder_Preview;

/**
 * Creates the Builder page for the plugin.
 *
 * @since 1.0.0
 * @see   Admin_Page
 */
class Admin_Page_Builder extends Admin_Page {
	public function render_page() {
		$builder_controls = new Builder_Controls( 'builder-config' );
		$builder_preview  = new Builder_Preview();
		$view             = WPBR_PLUGIN_DIR . 'includes/admin/pages/views/page-builder.php';
		include $view;
	}
}
