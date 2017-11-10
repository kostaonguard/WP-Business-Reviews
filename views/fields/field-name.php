<?php
$atts = $context['atts'];
?>

<span id="wpbr-field-name-<?php echo esc_attr( $atts['id'] ); ?>" class="wpbr-field__name">
	<?php esc_html_e( $atts['name'] ); ?>
</span>
