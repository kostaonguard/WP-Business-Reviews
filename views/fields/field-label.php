<?php
$atts = $context['atts'];
?>

<label id="wpbr-field-name-<?php echo esc_attr( $atts['id'] ); ?>" class="wpbr-field__name" for="wpbr-field-control-<?php echo esc_attr( $atts['id'] ); ?>">
	<?php esc_html_e( $atts['name'] ); ?>
</label>
