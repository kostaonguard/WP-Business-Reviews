<fieldset class="wpbr-field__fieldset">
	<legend class="screen-reader-text"><?php echo esc_html( $context['name'] ); ?></legend>
	<ul class="wpbr-field__options">
		<?php foreach ( $context['options'] as $value => $text ) : ?>
			<li class="wpbr-field__option">
				<input
					type="checkbox"
					id="wpbr-control-<?php echo esc_attr( $value ); ?>"
					class="wpbr-field__checkbox"
					name="<?php echo esc_attr( $context['id'] ); ?>"
					value="<?php echo esc_attr( $context['value'] ); ?>"
					>
				<label for="wpbr-control-<?php echo esc_attr( $value ); ?>">
					<?php echo esc_html( $text ); ?>
				</label>
			</li>
		<?php endforeach; ?>
	</ul>
</fieldset>
