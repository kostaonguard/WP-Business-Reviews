<select
	id="wpbr-control-<?php echo esc_attr( $this->id ); ?>"
	class="wpbr-field__control js-wpbr-control"
	name="<?php echo esc_attr( $this->id ); ?>"
	<?php
	// Output any additional control attributes.
	if ( ! empty( $this->control_atts ) ) {
		foreach ( $this->control_atts as $name => $value ) {
			echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
		}
	}
	?>
	>
	<?php foreach ( $this->options as $option_value => $option_text ) : ?>
		<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $option_value === $this->value ); ?>>
			<?php esc_html_e( $option_text ); ?>
		</option>
	<?php endforeach; ?>
</select>