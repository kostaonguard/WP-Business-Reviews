<?php
// Determine if field or subfield to help JS selectors.
if ( $this->field_args['is_subfield'] ) {
	$js_handle = 'js-wpbr-subfield';
} else {
	$js_handle = 'js-wpbr-field';
}
echo $this->section_id;

$field_classes = array(
	'wpbr-field',
	"wpbr-field--{$this->field_args['type']}",
	$js_handle,
);

// Add wrapper class if one is set.
if ( ! empty( $this->field_args['wrapper_class'] ) ) {
	$field_classes[] = $this->field_args['wrapper_class'];
}

// Convert classes from array to string.
$field_class_att = implode( $field_classes, ' ' );
?>

<div
	id="wpbr-field-<?php echo esc_attr( $this->field_id ); ?>"
	class="<?php echo esc_attr( $field_class_att ); ?>"
	data-wpbr-field-id="<?php echo esc_attr( $this->field_id ); ?>"
	data-wpbr-field-type="<?php echo esc_attr( $this->field_args['type'] ); ?>"
>

	<?php
	$type_slug = str_replace( '_', '-', $this->field_args['type'] );

	// These fields can all be rendered using the text input view.
	$text_like_fields = array(
		'hidden',
		'date',
		'datetime-local',
		'email',
		'month',
		'number',
		'password',
		'search',
		'tel',
		'text',
		'time',
		'url',
		'week',
	);

	// If this is a text-like field, use the text view.
	if ( in_array( $type_slug, $text_like_fields ) ) {
		$type_slug = 'text';
	}

	$this->render_partial( WPBR_PLUGIN_DIR . "views/field/partials/types/{$type_slug}.php" );
	?>

</div>
