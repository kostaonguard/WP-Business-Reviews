<select
	id="wpbr-control-<?php echo esc_attr( $context['id'] ); ?>"
	class="wpbr-field__control js-wpbr-control"
	name="<?php echo esc_attr( $context['id'] ); ?>"
	<?php
	// Output any additional control attributes.
	foreach ( $context['control_atts'] as $name => $value ) {
		echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
	}
	?>
	>
	<?php foreach ( $context['options'] as $value => $text ) : ?>
		<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value === $context['value'] ); ?>>
			<?php esc_html_e( $text ); ?>
		</option>
	<?php endforeach; ?>
</select>
