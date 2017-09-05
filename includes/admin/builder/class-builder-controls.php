<?php
/**
 * Defines the Builder_Controls class
 *
 * @package WP_Business_Reviews\Includes\Admin\Builder
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Builder;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the admin banner for the plugin.
 *
 * @since 1.0.0
 */
class Builder_Controls {
	/**
	 * Renders the builder controls.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		include WPBR_PLUGIN_DIR . 'includes/admin/builder/views/builder-controls.php';
	}
}
