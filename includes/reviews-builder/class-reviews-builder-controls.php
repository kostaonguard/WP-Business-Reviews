<?php
/**
 * Defines the Builder_Controls class
 *
 * @package WP_Business_Reviews\Includes\Admin\Builder
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Reviews_Builder;

/**
 * Creates the admin banner for the plugin.
 *
 * @since 1.0.0
 */
class Reviews_Builder_Controls {
	/**
	 * Renders the builder controls.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		include WPBR_PLUGIN_DIR . 'views/reviews-builder-controls.php';
	}
}
