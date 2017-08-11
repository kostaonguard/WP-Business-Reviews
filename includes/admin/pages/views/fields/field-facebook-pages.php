<div class="wpbr-settings-field">
	<div class="wpbr-settings-field__name">
		<span><?php echo esc_html( $field['name'] ); ?></span>
	</div>
	<div class="wpbr-settings-field__content">
		<a class="wpbr-button"
		   href="#"><?php _e( 'Connect to Facebook', 'wpbr' ); ?></a>
		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="wpbr-settings-field__description"><?php $this->render_field_description( $field['desc'] ); ?></p>
		<?php endif; ?>
	</div>
</div>
