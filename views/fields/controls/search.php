<input
	type="<?php echo esc_attr( $context['type'] ); ?>"
	id="wpbr-control-<?php echo esc_attr( $context['id'] ); ?>"
	class="wpbr-field__control js-wpbr-search-input"
	name="<?php echo esc_attr( $context['id'] ); ?>"
	value="<?php echo esc_attr( $context['value'] ); ?>"
	<?php
	// Output any additional control attributes.
	foreach ( $context['control_atts'] as $name => $value ) {
		echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
	}
	?>
	>
<button class="button wpbr-field__inline-button js-wpbr-search-button"><?php esc_html_e( 'Search', 'wpbr' ); ?></button>
