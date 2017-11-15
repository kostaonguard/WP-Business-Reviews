<!-- Panels -->
<div class="wpbr-admin-page">
	<?php foreach ( $this->field_hierarchy as $panel ) : ?>
		<!-- Panel -->
		<?php $panel['id'] = ! empty( $panel['id'] ) ? $panel['id'] : ''; ?>
		<div id="wpbr-panel-<?php echo esc_attr( $panel['id'] ); ?>" class="wpbr-panel js-wpbr-panel" data-panel-id="<?php echo esc_attr( $panel['id'] ); ?>">
			<?php
			// Render the panel navigation if more than one section exists.
			if ( ! empty( $panel['sections'] ) && count( $panel['sections'] ) > 1 ) {
				$this->render_partial( WPBR_PLUGIN_DIR . 'views/settings/panel/panel-nav.php',
					array(
						'sections' => $panel['sections'],
					)
				);
			}
			// Render the panel's sections.
			$this->render_partial(
				WPBR_PLUGIN_DIR . 'views/settings/panel/panel-main.php',
				array(
					'sections' => $panel['sections'],
				)
			);
			?>
		</div>
	<?php endforeach; ?>
</div>
