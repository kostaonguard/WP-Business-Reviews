<?php
if ( ! empty( $this->args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/label.php' );
}
?>

<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__control-wrap">
	<select
		id="wpbr-control-<?php echo esc_attr( $this->id ); ?>"
		class="wpbr-field__select js-wpbr-control"
		name="wp_business_reviews_settings[<?php echo esc_attr( $this->id ); ?>]"
		data-wpbr-control-id="<?php echo esc_attr( $this->id ); ?>"
		>
		<?php foreach ( $this->args['options'] as $option_value => $option_text ) : ?>
			<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $option_value === $this->value ); ?>>
				<?php esc_html_e( $option_text ); ?>
			</option>
		<?php endforeach; ?>
	</select>

	<?php
	if ( ! empty( $this->args['description'] ) ) {
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/description.php' );
	}
	?>
</div>
