<div class="wpbr-field__flex">
	<input
		type="text"
		id="wpbr-control-<?php echo esc_attr( $this->id ); ?>"
		class="wpbr-field__input js-wpbr-search-input"
		name="<?php echo esc_attr( $this->id ); ?>"
		value="<?php echo esc_attr( $this->value ); ?>"
		<?php
		// Output any additional control attributes.
		if ( ! empty( $this->control_atts ) ) {
			foreach ( $this->control_atts as $name => $value ) {
				echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
			}
		}
		?>
		>
	<button class="button wpbr-field__inline-button js-wpbr-search-button"><?php esc_html_e( 'Search', 'wpbr' ); ?></button>
</div>
