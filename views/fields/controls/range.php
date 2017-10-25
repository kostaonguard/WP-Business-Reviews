<input
	id="wpbr-control-<?php echo esc_attr( $context['id'] ); ?>"
	class="wpbr-field__control"
	type="range"
	name="<?php echo esc_attr( $context['id'] ); ?>"
	value="<?php echo esc_attr( $context['value'] ); ?>"
	list="wpbr-datalist-<?php echo esc_attr( $context['id'] ); ?>"
	<?php
	// Output any additional control attributes.
	foreach ( $context['control_atts'] as $name => $value ) {
		echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
	}
	?>
	>

<?php if ( ! empty( $context['options'] ) ) : ?>
	<datalist id="wpbr-datalist-<?php echo esc_attr( $context['id'] ); ?>">
		<?php
		foreach ( $context['options'] as $value ) {
			echo '<option value="' . esc_attr( $value ) . '">';
		}
		?>
	</datalist>
<?php endif; ?>
