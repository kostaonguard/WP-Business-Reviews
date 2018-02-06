<?php
if ( ! empty( $this->field_args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/label.php' );
}
?>

<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->field_id ); ?>" class="wpbr-field__control-wrap">
	<input
		id="wpbr-control-<?php echo esc_attr( $this->field_id ); ?>"
		class="wpbr-field__input js-wpbr-control"
		type="<?php echo esc_attr( $this->field_args['type'] ); ?>"
		name="<?php echo esc_attr( "{$this->prefix}[{$this->field_id}]" ); ?>"
		value="<?php echo esc_attr( $this->value ); ?>"
		placeholder="<?php echo esc_attr( $this->field_args['placeholder'] ); ?>"
		data-wpbr-control-id="<?php echo esc_attr( $this->field_id ); ?>"
		>

	<?php
	if ( ! empty( $this->field_args['description'] ) ) {
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/description.php' );
	}
	?>
</div>
