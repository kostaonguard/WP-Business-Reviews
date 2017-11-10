<?php
$atts = $context['atts'];
?>

<p id="wpbr-field-description-<?php echo esc_attr( $atts['id'] ); ?>" class="wpbr-field__description"><?php echo wp_kses_post( $atts['description'] ); ?></p>
