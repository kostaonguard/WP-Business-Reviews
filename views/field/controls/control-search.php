<div class="wpbr-field__flex">
	<input
		type="text"
		id="wpbr-control-<?php echo esc_attr( $this->id ); ?>"
		class="wpbr-field__input js-wpbr-search-input"
		name="<?php echo esc_attr( $this->id ); ?>"
		value="<?php echo esc_attr( $this->value ); ?>"
		placeholder="<?php echo esc_attr( $this->args['placeholder'] ); ?>"
		>
	<button class="button wpbr-field__inline-button js-wpbr-search-button"><?php esc_html_e( 'Search', 'wp-business-reviews' ); ?></button>
</div>
