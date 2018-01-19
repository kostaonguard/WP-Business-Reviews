<?php
if ( ! empty( $this->args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/name.php' );
}
?>

<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__control-wrap">
	<fieldset class="wpbr-field__fieldset">
		<legend class="screen-reader-text"><?php echo esc_html( $this->args['name'] ); ?></legend>
		<ul class="wpbr-field__options">
			<?php foreach ( $this->args['options'] as $option_value => $option_text ) : ?>
				<li class="wpbr-field__option">
					<input
						type="radio"
						id="wpbr-control-<?php echo esc_attr( $this->id . '-' . $option_value ); ?>"
						class="wpbr-field__radio"
						name="wp_business_reviews_settings[<?php echo esc_attr( $this->id ); ?>]"
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

	<?php
	if ( ! empty( $this->args['description'] ) ) {
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/description.php' );
	}
	?>
</div>
