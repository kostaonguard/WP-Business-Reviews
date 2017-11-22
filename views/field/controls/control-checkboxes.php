<fieldset class="wpbr-field__fieldset">
	<legend class="screen-reader-text"><?php echo esc_html( $this->args['name'] ); ?></legend>
	<ul class="wpbr-field__options">
		<?php foreach ( $this->args['options'] as $option_value => $option_text ) : ?>
			<li class="wpbr-field__option">
				<input
					type="checkbox"
					id="wpbr-control-<?php echo esc_attr( $option_value ); ?>"
					class="wpbr-field__checkbox"
					name="<?php echo esc_attr( $this->id ); ?>"
					value="<?php echo esc_attr( $option_value ); ?>"
					<?php checked( $this->value && in_array( $option_value, $this->value ) ); ?>
					>
				<label for="wpbr-control-<?php echo esc_attr( $option_value ); ?>">
					<?php echo esc_html( $option_text ); ?>
				</label>
			</li>
		<?php endforeach; ?>
	</ul>
</fieldset>
