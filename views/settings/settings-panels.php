<?php foreach ( $this->config as $panel_id => $panel ) : ?>
	<div id="wpbr-panel-<?php echo esc_attr( $panel_id ); ?>" class="wpbr-panel js-wpbr-panel" data-panel-id="<?php echo esc_attr( $panel_id ); ?>">
		<?php
		// Render the panel navigation if more than one section exists.
		if ( ! empty( $panel['sections'] ) && count( $panel['sections'] ) > 1 ) {
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/settings/panel/panel-sidebar.php',
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
				'field_repository' => $this->field_repository,
			)
		);
		?>
	</div>
<?php endforeach; ?>
