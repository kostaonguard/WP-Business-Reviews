<p>
	<label for="<?php echo esc_attr( $this->field_id ); ?>">
		<?php esc_html_e( 'Blueprint:', 'text_domain' ); ?>
	</label>
	<input
		type="text"
		id="<?php echo esc_attr( $this->field_id ); ?>"
		class="widefat"
		name="<?php echo esc_attr( $this->field_name ); ?>"
		value="<?php echo esc_attr( $this->blueprint_id ); ?>"
		>
</p>
