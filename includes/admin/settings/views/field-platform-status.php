<tr class="wpbr-settings-field">
	<th scope="row">
		<?php echo esc_html( $field['name'] ); ?>
	</th>
	<td>
		<strong class="wpbr-platform-status"><?php echo esc_html( 'Not Connected' ); ?></strong>
		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="description"><?php $this->render_description( $field['desc'] ); ?></p>
		<?php endif; ?>
	</td>
</tr>
