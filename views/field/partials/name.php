<span id="wpbr-field-name-<?php echo esc_attr( $this->field_id ); ?>" class="wpbr-field__name">
	<?php
	esc_html_e( $this->field_args['name'] );
	if ( ! empty( $this->field_args['tooltip'] ) ) {
		echo ' ';
		// Render tooltip.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/tooltip.php' );
	}
	?>
</span>
