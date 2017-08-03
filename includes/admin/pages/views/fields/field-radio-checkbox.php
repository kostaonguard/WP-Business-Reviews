<tr class="wpbr-settings-field">
	<th scope="row">
		<?php echo esc_html( $field['name'] ); ?>
	</th>
	<td>
		<?php if ( ! empty( $field['options'] ) ) : ?>
			<fieldset>
				<legend class="screen-reader-text"><?php echo esc_html( $field['name'] ); ?></legend>
				<?php foreach ( $field['options'] as $att_value => $label ) : ?>
					<?php
					// Set input attributes.
					$att_id          = 'wpbr-' . str_replace( '_', '-', $field['id'] ) . '-' . $att_value;
					$att_name_suffix = 'checkbox' === $field['type'] ? '[]' : '';
					$att_name        = 'wpbr_settings[' . $field['id'] . ']' . $att_name_suffix;
					$att_type        = $field['type'];
					$checked         = false;

					if (  is_array( $saved_value ) ) {
						// If the input's value exists in the saved value array, mark it checked.
						$checked = in_array( $att_value, $saved_value );
					} else {
						$checked = $att_value === $saved_value ? true : false;
					}
					?>
					<label for="<?php echo esc_attr( $att_id ); ?>">
						<input id="<?php echo esc_attr( $att_id ); ?>" type="<?php echo esc_attr( $att_type ); ?>"
						       name="<?php echo esc_attr( $att_name ); ?>"
						       value="<?php echo esc_attr( $att_value ); ?>" <?php checked( $checked ); ?>>
						<?php echo esc_html( $label ); ?>
					</label><br>
				<?php endforeach; ?>
			</fieldset>
		<?php endif; ?>

		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="description"><?php $this->render_field_description( $field['desc'] ); ?></p>
		<?php endif; ?>
	</td>
</tr>
