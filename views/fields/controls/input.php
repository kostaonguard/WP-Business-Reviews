<input
	id="wpbr-control-<?php echo esc_attr( $context['id'] ); ?>"
	class="wpbr-field__control"
	type="<?php echo esc_attr( $context['type'] ); ?>"
	name="<?php echo esc_attr( $context['id'] ); ?>"
	value="<?php echo esc_attr( $context['value'] ); ?>"
	<?php
	// Output any additional control attributes.
	foreach ( $context['control_atts'] as $name => $value ) {
		echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
	}
	?>
	>
