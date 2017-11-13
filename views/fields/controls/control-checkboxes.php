<?php
$atts  = $context['atts'];
$value = $context['value'];
?>

<fieldset class="wpbr-field__fieldset">
	<legend class="screen-reader-text"><?php echo esc_html( $atts['name'] ); ?></legend>
	<ul class="wpbr-field__options">
		<?php foreach ( $atts['options'] as $option_value => $option_text ) : ?>
			<li class="wpbr-field__option">
				<input
					type="checkbox"
					id="wpbr-control-<?php echo esc_attr( $option_value ); ?>"
					class="wpbr-field__checkbox"
					name="<?php echo esc_attr( $atts['id'] ); ?>"
					value="<?php echo esc_attr( $atts['value'] ); ?>"
					<?php checked( $option_value, $value ); ?>
					>
				<label for="wpbr-control-<?php echo esc_attr( $option_value ); ?>">
					<?php echo esc_html( $option_text ); ?>
				</label>
			</li>
		<?php endforeach; ?>
	</ul>
</fieldset>
