<div id="wpbr-field-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field js-wpbr-field">
	<?php
	if ( ! empty( $this->name ) ) {
		if ( ! empty( $this->name_element ) && 'label' === $this->name_element ) {
			// Render field name in label tag.
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/field-label.php' );
		} else {
			// Render field name in span tag (intended for use alongside fieldsets).
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/field-name.php' );
		}
	}

	if ( ! empty( $this->tooltip ) ) {
		// Render tooltip.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/tooltip.php' );
	}
	?>

	<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__control-wrap">
		<?php
		// Render field control.
		$this->render_partial( WPBR_PLUGIN_DIR . "views/field/controls/control-{$this->control}.php" );
		?>
	</div>

	<?php
	if ( ! empty( $this->description ) ) {
		// Render field description.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/field-description.php' );
	}
	?>
</div>
