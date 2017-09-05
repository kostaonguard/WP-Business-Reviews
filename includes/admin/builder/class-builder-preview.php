<?php
/**
 * Defines the Builder_Preview class
 *
 * @package WP_Business_Reviews\Includes\Admin\Builder
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Builder;

/**
 * Creates the admin banner for the plugin.
 *
 * @since 1.0.0
 */
class Builder_Preview {
	/**
	 * Renders the builder preview.
	 *
	 * The preview appears alongside builder controls to give the user an idea
	 * of how reviews will appear on the front-end.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		include WPBR_PLUGIN_DIR . 'includes/admin/builder/views/builder-preview.php';
	}
}
