<?php
$atts  = $context['atts'];
$value = $context['value'];
?>

<input
	id="wpbr-control-<?php echo esc_attr( $atts['id'] ); ?>"
	class="wpbr-field__control"
	type="<?php echo esc_attr( $atts['control_atts']['type'] ); ?>"
	name="<?php echo esc_attr( $atts['id'] ); ?>"
	value="<?php echo esc_attr( $value ); ?>"
	<?php
	// Output any additional control attributes.
	if ( ! empty( $atts['control_atts'] ) ) {
		foreach ( $atts['control_atts'] as $name => $value ) {
			echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
		}
	}

	// Output list attribute if datalist is defined.
	if ( ! empty( $atts['datalist'] ) ) {
		echo 'list="wpbr-datalist-' . esc_attr( $atts['id'] ) . '"';
	}
	?>
	>

<?php if ( ! empty( $atts['datalist'] ) ) : ?>
	<datalist id="wpbr-datalist-<?php echo esc_attr( $atts['id'] ); ?>">
		<?php
		foreach ( $atts['datalist'] as $value ) {
			echo '<option value="' . esc_attr( $value ) . '">';
		}
		?>
	</datalist>
<?php endif; ?>
