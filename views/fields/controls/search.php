<?php
$atts  = $context['atts'];
$value = $context['value'];
?>

<input
	type="text"
	id="wpbr-control-<?php echo esc_attr( $atts['id'] ); ?>"
	class="wpbr-field__control js-wpbr-search-input"
	name="<?php echo esc_attr( $atts['id'] ); ?>"
	value="<?php echo esc_attr( $value ); ?>"
	<?php
	// Output any additional control attributes.
	if ( ! empty( $atts['control_atts'] ) ) {
		foreach ( $atts['control_atts'] as $name => $value ) {
			echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
		}
	}
	?>
	>
<button class="button wpbr-field__inline-button js-wpbr-search-button"><?php esc_html_e( 'Search', 'wpbr' ); ?></button>
