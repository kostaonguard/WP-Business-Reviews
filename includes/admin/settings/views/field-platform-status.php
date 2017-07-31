<tr class="wpbr-settings-field">
	<th scope="row">
		<label class="wpbr-settings-field__label" for="<?php echo esc_attr( $field['id'] ); ?>">
			<?php echo esc_html( $field['name'] ); ?>
		</label>
	</th>
	<td>
		<strong class="wpbr-platform-status"><?php echo esc_html( 'Not Connected' ); ?></strong>
		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="description"><?php $this->render_description( $field['desc'] ); ?></p>
		<?php endif; ?>
	</td>
</tr>
