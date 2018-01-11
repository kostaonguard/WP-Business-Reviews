<?php
$field_classes = array(
	'wpbr-field',
	"wpbr-field--{$this->args['type']}",
	'js-wpbr-field',
);

// Add wrapper class if one is set.
if ( ! empty( $this->args['wrapper_class'] ) ) {
	$field_classes[] = $this->args['wrapper_class'];
}

// Convert classes from array to string.
$field_class_att = implode( $field_classes, ' ' );
?>

<div
	id="wpbr-field-<?php echo esc_attr( $this->id ); ?>"
	class="<?php echo esc_attr( $field_class_att ); ?>"
	data-wpbr-field-id="<?php echo esc_attr( $this->id ); ?>"
	data-wpbr-field-type="<?php echo esc_attr( $this->args['type'] ); ?>"
>

	<?php
	$type_slug = str_replace( '_', '-', $this->args['type'] );
	$this->render_partial( WPBR_PLUGIN_DIR . "views/field/partials/types/{$type_slug}.php" );
	?>

</div>
