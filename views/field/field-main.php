<div
	id="wpbr-field-<?php echo esc_attr( $this->id ); ?>"
	class="wpbr-field js-wpbr-field<?php echo ( $this->args['wrapper_class'] ? ' ' . esc_attr( $this->args['wrapper_class'] ) : '' ); ?>"
	>
	<?php
	if ( ! empty( $this->args['name'] ) ) {
		if ( ! empty( $this->args['name_element'] ) && 'label' === $this->args['name_element'] ) {
			// Render field name in label tag.
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/field-label.php' );
		} else {
			// Render field name in span tag (intended for use alongside fieldsets).
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/field-name.php' );
		}
	}
	?>

	<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__control-wrap">
		<?php
		// Render field control.
		$type = str_replace( '_', '-', $this->args['type'] );
		$this->render_partial( WPBR_PLUGIN_DIR . "views/field/controls/control-{$type}.php" );

		if ( ! empty( $this->args['description'] ) ) {
			// Render field description.
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/field-description.php' );
		}
		?>
	</div>
</div>
