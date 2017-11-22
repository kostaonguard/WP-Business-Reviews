<span id="wpbr-field-name-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__name">
	<?php
	esc_html_e( $this->args['name'] );
	if ( ! empty( $this->tooltip ) ) {
		echo ' ';
		// Render tooltip.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/tooltip.php' );
	}
	?>
</span>
