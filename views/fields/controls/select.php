<?php
$atts  = $context['atts'];
$value = $context['value'];
?>

<select
	id="wpbr-control-<?php echo esc_attr( $atts['id'] ); ?>"
	class="wpbr-field__control js-wpbr-control"
	name="<?php echo esc_attr( $atts['id'] ); ?>"
	<?php
	// Output any additional control attributes.
	if ( ! empty( $atts['control_atts'] ) ) {
		foreach ( $atts['control_atts'] as $name => $value ) {
			echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
		}
	}
	?>
	>
	<?php foreach ( $atts['options'] as $option_value => $option_text ) : ?>
		<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $option_value === $value ); ?>>
			<?php esc_html_e( $option_text ); ?>
		</option>
	<?php endforeach; ?>
</select>
