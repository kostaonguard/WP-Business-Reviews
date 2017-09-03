<?php
$att_value = $saved_value;
$att_id    = 'wpbr-' . str_replace( '_', '-', $field['id'] );
$att_name  = 'wpbr_settings[' . $field['id'] . ']';
?>
<div class="wpbr-field wpbr-field--text<?php echo ! empty( $class ) ? ' ' . esc_attr( $class ) : ''; ?>">
	<label class="wpbr-field__name"
	       for="<?php echo esc_attr( $att_id ); ?>"><?php echo esc_html( $field['name'] ); ?></label>
	<input class="wpbr-field__control regular-text" id="<?php echo esc_attr( $att_id ); ?>" type="text"
	       name="<?php echo esc_attr( $att_name ); ?>" value="<?php echo esc_attr( $att_value ); ?>">
	<?php if ( ! empty( $field['desc'] ) ) : ?>
		<p class="wpbr-field__description"><?php $this->render_field_description( $field['desc'] ); ?></p>
	<?php endif; ?>
</div>
