<div class="wpbr-field wpbr-field--platform-status<?php echo ! empty( $class ) ? ' ' . esc_attr( $class ) : ''; ?>">
	<span class="wpbr-field__name"><?php echo esc_html( $field['name'] ); ?></span>
	<div class="wpbr-field__control">
		<strong class="wpbr-platform-status"><?php echo esc_html( 'Not Connected' ); ?></strong>
	</div>
	<?php if ( ! empty( $field['desc'] ) ) : ?>
		<p class="wpbr-field__description"><?php $this->render_field_description( $field['desc'] ); ?></p>
	<?php endif; ?>
</div>
