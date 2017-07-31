<?php
$att_id   = 'wpbr-' . str_replace( '_', '-', $field['id'] );
$att_name = 'wpbr_settings[' . $field['id'] . ']';
?>
<tr class="wpbr-settings-field">
	<th scope="row">
		<label class="wpbr-settings-field__label" for="<?php echo esc_attr( $att_id ); ?>">
			<?php echo esc_html( $field['name'] ); ?>
		</label>
	</th>
	<td>
		<input id="<?php echo esc_attr( $att_id ); ?>" class="regular-text" type="password" name="<?php echo esc_attr( $att_name ); ?>" value="">
		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="description"><?php $this->render_description( $field['desc'] ); ?></p>
		<?php endif; ?>
	</td>
</tr>
