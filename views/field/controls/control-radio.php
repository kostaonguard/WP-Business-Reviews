<fieldset class="wpbr-field__fieldset">
	<legend class="screen-reader-text"><?php echo esc_html( $this->name ); ?></legend>
	<ul class="wpbr-field__options">
		<?php foreach ( $this->options as $option_value => $option_text ) : ?>
			<li class="wpbr-field__option">
				<input
					type="radio"
					id="wpbr-control-<?php echo esc_attr( $this->id . '-' . $option_value ); ?>"
					class="wpbr-field__radio"
					name="<?php echo esc_attr( $this->id ); ?>"
					value="<?php echo esc_attr( $option_value ); ?>"
					<?php checked( $option_value, $this->value ); ?>
					>
				<label for="wpbr-control-<?php echo esc_attr( $this->id . '-' . $option_value ); ?>">
					<?php echo esc_html( $option_text ); ?>
				</label>
			</li>
		<?php endforeach; ?>
	</ul>
</fieldset>