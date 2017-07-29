<tr class="wpbr-settings-field">
	<th scope="row">
		<label class="wpbr-settings-field__label" for="<?php echo esc_attr( $field['id'] ); ?>">
			<?php echo esc_html( $field['name'] ); ?>
		</label>
	</th>
	<td>
		<input id="<?php echo esc_attr( $field['id'] ); ?>" class="wpbr-settings-field__input regular-text" type="password">
		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<?php
			$allowed_html = array(
				'a'      => array(
					'href'   => array(),
					'title'  => array(),
					'target' => array(),
				),
				'em'     => array(),
				'strong' => array(),
			);
			?>
			<p class="description"><?php echo wp_kses( $field['desc'], $allowed_html ); ?></p>
		<?php endif; ?>
	</td>
</tr>
