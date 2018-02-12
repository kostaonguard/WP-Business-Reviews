<p>
	<label for="<?php echo esc_attr( $this->fields['title']['field_id'] ); ?>">
		<?php _e('Title:', 'wp-business-reviews'); ?>
	</label>
	<input
		type="text" value="<?php echo esc_attr( $this->instance['title'] ); ?>"
		id="<?php echo esc_attr( $this->fields['title']['field_id'] ); ?>"
		class="widefat"
		name="<?php echo esc_attr( $this->fields['title']['field_name'] ); ?>"
		value="<?php echo esc_attr( $this->instance['title'] ); ?>"
		>
</p>
<p>
	<label for="<?php echo esc_attr( $this->fields['collection_id']['field_id'] ); ?>">
		<?php esc_html_e( 'Review Collection:', 'wp-business-reviews' ); ?>
	</label>

	<select
		id="<?php echo esc_attr( $this->fields['collection_id']['field_id'] ); ?>"
		class="widefat"
		name="<?php echo esc_attr( $this->fields['collection_id']['field_name'] ); ?>"
		>

		<?php foreach ( $this->collection_posts as $post ) : ?>
			<option
				value="<?php echo esc_attr( $post->ID ); ?>"
				<?php selected( $post->ID, $this->instance['collection_id'] ); ?>
				>
				<?php echo esc_html( $post->post_title ); ?>
			</option>
		<?php endforeach; ?>

	</select>
</p>
