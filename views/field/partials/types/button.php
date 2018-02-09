<button
	type="button"
	class="button js-wpbr-control"
	value="<?php echo esc_attr( $this->value ); ?>"
	data-wpbr-control-id="<?php echo esc_attr( $this->field_id ); ?>"
>
	<?php esc_html_e( $this->field_args['button_text'] ); ?>
</button>
