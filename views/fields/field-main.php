<div id="wpbr-field-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field js-wpbr-field">
	<?php
	if ( 'label' === $this->name_element ) {
		// Render field name in label tag.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/fields/field-label.php' );
	} else {
		// Render field name in span tag.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/fields/field-name.php' );
	}

	if ( ! empty( $this->tooltip ) ) {
		// Render tooltip.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/tooltip.php' );
	}
	?>

	<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__control-wrap">
		<?php
		// Render field control.
		$this->render_partial( WPBR_PLUGIN_DIR . "views/fields/controls/control-{$this->control}.php" );
		?>
	</div>

	<?php
	if ( ! empty( $this->description ) ) {
		// Render field description.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/fields/field-description.php' );
	}
	?>
</div>
