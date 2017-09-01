<div class="wpbr-field wpbr-field--radio-checkbox<?php echo ! empty( $class ) ? ' ' . esc_attr( $class ) : ''; ?>">
	<span class="wpbr-field__name"><?php echo esc_html( $field['name'] ); ?></span>
	<div class="wpbr-field__control">
		<?php if ( ! empty( $field['options'] ) ) : ?>
			<fieldset class="wpbr-field__fieldset">
				<legend class="wpbr-field__legend screen-reader-text"><?php echo esc_html( $field['name'] ); ?></legend>
				<ul class="wpbr-field__options">
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
							<li class="wpbr-field__option">
								<input id="<?php echo esc_attr( $att_id ); ?>" type="<?php echo esc_attr( $att_type ); ?>"
								       name="<?php echo esc_attr( $att_name ); ?>"
								       value="<?php echo esc_attr( $att_value ); ?>" <?php checked( $checked ); ?>>
								<label for="<?php echo esc_attr( $att_id ); ?>">
									<?php echo esc_html( $label ); ?>
								</label>
							</li>
					<?php endforeach; ?>
				</ul>
			</fieldset>
		<?php endif; ?>
	</div>
	<?php if ( ! empty( $field['desc'] ) ) : ?>
		<p class="wpbr-field__description"><?php $this->render_field_description( $field['desc'] ); ?></p>
	<?php endif; ?>
</div>
