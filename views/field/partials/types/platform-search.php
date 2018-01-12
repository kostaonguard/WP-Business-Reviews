<?php
if ( ! empty( $this->args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/label.php' );
}
?>

<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__control-wrap">

	<?php
	foreach ( $this->args['subfields'] as $subfield ) {
		$subfield->render();
	}
	?>

	<?php
	if ( ! empty( $this->args['description'] ) ) {
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/description.php' );
	}
	?>
</div>
