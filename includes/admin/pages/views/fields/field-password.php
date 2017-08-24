<?php
$att_id   = 'wpbr-' . str_replace( '_', '-', $field['id'] );
$att_name = 'wpbr_settings[' . $field['id'] . ']';
?>
<div class="wpbr-settings-field wpbr-settings-field--text">
	<div class="wpbr-settings-field__name">
		<label for="<?php echo esc_attr( $att_id ); ?>"><?php echo esc_html( $field['name'] ); ?></label>
	</div>
	<div class="wpbr-settings-field__content">
		<?php
		// Set input attributes.
		$att_value = $saved_value;
		$att_id   = 'wpbr-' . str_replace( '_', '-', $field['id'] );
		$att_name = 'wpbr_settings[' . $field['id'] . ']';
		?>
		<input id="<?php echo esc_attr( $att_id ); ?>" type="password"
		       name="<?php echo esc_attr( $att_name ); ?>" value="<?php echo esc_attr( $att_value ); ?>">
		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="wpbr-settings-field__description"><?php $this->render_field_description( $field['desc'] ); ?></p>
		<?php endif; ?>
	</div>
</div>
