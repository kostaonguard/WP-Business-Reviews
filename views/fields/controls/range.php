<input
	id="wpbr-control-<?php echo esc_attr( $context['id'] ); ?>"
	class="wpbr-field__control"
	type="range"
	name="<?php echo esc_attr( $context['id'] ); ?>"
	value="<?php echo esc_attr( $context['value'] ); ?>"
	<?php
	// Output list attribute if datalist is defined.
	if ( ! empty( $context['datalist'] ) ) {
		echo 'list="wpbr-datalist-' . esc_attr( $context['id'] ) . '"';
	}

	// Output any additional control attributes.
	foreach ( $context['control_atts'] as $name => $value ) {
		echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
	}
	?>
	>

<?php if ( ! empty( $context['datalist'] ) ) : ?>
	<datalist id="wpbr-datalist-<?php echo esc_attr( $context['id'] ); ?>">
		<?php
		foreach ( $context['datalist'] as $value ) {
			echo '<option value="' . esc_attr( $value ) . '">';
		}
		?>
	</datalist>
<?php endif; ?>
