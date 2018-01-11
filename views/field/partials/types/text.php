<?php
if ( ! empty( $this->args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/label.php' );
}
?>

<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__control-wrap">
	<input
		id="wpbr-control-<?php echo esc_attr( $this->id ); ?>"
		class="wpbr-field__input js-wpbr-control"
		type="<?php echo esc_attr( $this->args['type'] ); ?>"
		name="wp_business_reviews_settings[<?php echo esc_attr( $this->id ); ?>]"
		value="<?php echo esc_attr( $this->value ); ?>"
		placeholder="<?php echo esc_attr( $this->args['placeholder'] ); ?>"
		data-wpbr-control-id="<?php echo esc_attr( $this->id ); ?>"
		>

	<?php
	if ( ! empty( $this->args['description'] ) ) {
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/description.php' );
	}
	?>
</div>
