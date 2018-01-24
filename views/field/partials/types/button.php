<button
	class="button js-wpbr-control"
	type="button"
	value="<?php echo esc_attr( $this->value ); ?>"
	data-wpbr-control-id="<?php echo esc_attr( $this->id ); ?>"
>
	<?php esc_html_e( $this->args['button_text'] ); ?>
</button>
