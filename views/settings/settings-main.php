<?php
/**
 * Displays the settings UI for the plugin
 *
 * @package WP_Business_Reviews
 * @since 0.1.0
 */

namespace WP_Business_Reviews;
?>

<?php $this->render_partial( WPBR_PLUGIN_DIR . 'views/settings/settings-tabs.php' ); ?>

<div class="wpbr-admin-page wpbr-admin-page--pad">
	<?php $this->render_partial( WPBR_PLUGIN_DIR . 'views/settings/settings-panels.php' ); ?>
</div>
