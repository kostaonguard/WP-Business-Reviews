<?php if ( 'connected' === $this->value ) : ?>
	<strong class="wpbr-platform-status wpbr-platform-status--success">
		<?php echo esc_html__( 'Connected', 'wp-business-reviews' ); ?>
	</strong>
<?php else : ?>
	<strong class="wpbr-platform-status wpbr-platform-status--error">
		<?php echo esc_html__( 'Not Connected', 'wp-business-reviews' ); ?>
	</strong>
<?php endif; ?>

<input
	id="wpbr-control-<?php echo esc_attr( $this->id ); ?>"
	class="wpbr-field__input"
	type="text"
	name="wp_business_reviews_settings[<?php echo esc_attr( $this->id ); ?>]"
	value="<?php echo esc_attr( $this->value ); ?>"
	readonly
	>
