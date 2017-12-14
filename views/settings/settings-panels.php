<?php foreach ( $this->config as $tab_id => $tab ) : ?>
	<div id="wpbr-panel-<?php echo esc_attr( $tab_id ); ?>" class="wpbr-panel js-wpbr-panel" data-tab-id="<?php echo esc_attr( $tab_id ); ?>">
		<?php
		// Render the panel navigation if more than one section exists.
		if ( ! empty( $tab['sections'] ) && count( $tab['sections'] ) > 1 ) {
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/settings/panel/panel-sidebar.php',
				array(
					'tab_id'              => $tab_id,
					'sections'            => $tab['sections'],
					'active_platforms'    => $this->active_platforms,
					'connected_platforms' => $this->connected_platforms,
					)
				);
			}

			// Render the panel's sections.
			$this->render_partial(
				WPBR_PLUGIN_DIR . 'views/settings/panel/panel-main.php',
			array(
				'tab_id'           => $tab_id,
				'sections'         => $tab['sections'],
				'field_repository' => $this->field_repository,
				'active_platforms' => $this->active_platforms,
			)
		);
		?>
	</div>
<?php endforeach; ?>
