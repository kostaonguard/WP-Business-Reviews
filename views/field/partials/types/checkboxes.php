<?php
if ( ! empty( $this->field_args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/name.php' );
}
?>

<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->field_id ); ?>" class="wpbr-field__control-wrap">
	<fieldset class="wpbr-field__fieldset">
		<legend class="screen-reader-text"><?php echo esc_html( $this->field_args['name'] ); ?></legend>
		<ul class="wpbr-field__options">
			<?php foreach ( $this->field_args['options'] as $option_value => $option_text ) : ?>
				<li class="wpbr-field__option">
					<input
						type="checkbox"
						id="wpbr-control-<?php echo esc_attr( $option_value ); ?>"
						class="wpbr-field__checkbox js-wpbr-control"
						name="<?php echo esc_attr( "{$this->prefix}[{$this->field_id}][{$option_value}]" ); ?>"
						value="enabled"
						data-wpbr-control-id="<?php echo esc_attr( $option_value ); ?>"
						<?php checked( $this->value && isset( $this->value[ $option_value ] ) ); ?>
						>
					<label for="wpbr-control-<?php echo esc_attr( $option_value ); ?>">
						<?php echo esc_html( $option_text ); ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>
	</fieldset>

	<?php
	if ( ! empty( $this->field_args['description'] ) ) {
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/description.php' );
	}
	?>
</div>
