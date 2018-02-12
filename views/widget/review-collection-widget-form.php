<p>
	<label for="<?php echo esc_attr( $this->field_id ); ?>">
		<?php esc_html_e( 'Review Collection:', 'text_domain' ); ?>
	</label>
	<input
		type="text"
		id="<?php echo esc_attr( $this->field_id ); ?>"
		class="widefat"
		name="<?php echo esc_attr( $this->field_name ); ?>"
		value="<?php echo esc_attr( $this->review_collection_id ); ?>"
		>
</p>
