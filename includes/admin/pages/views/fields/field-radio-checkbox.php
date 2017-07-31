<tr class="wpbr-settings-field">
	<th scope="row">
		<?php echo esc_html( $field['name'] ); ?>
	</th>
	<td>
		<?php if ( ! empty( $field['options'] ) ) : ?>
			<fieldset>
				<legend class="screen-reader-text"><?php echo esc_html( $field['name'] ); ?></legend>
				<?php foreach ( $field['options'] as $value => $label ) : ?>
					<?php
					$att_id          = 'wpbr-' . str_replace( '_', '-', $field['id'] ) . '-' . $value;
					$att_name_suffix = 'checkbox' === $field['type'] ? '[]' : '';
					$att_name        = 'wpbr_settings[' . $field['id'] . ']' . $att_name_suffix;
					$att_type        = $field['type'];
					?>
					<label for="<?php echo esc_attr( $att_id ); ?>">
						<input id="<?php echo esc_attr( $att_id ); ?>" type="<?php echo esc_attr( $att_type ); ?>"
						       name="<?php echo esc_attr( $att_name ); ?>" value="<?php echo esc_attr( $value ); ?>">
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
