<div
	id="wpbr-field-<?php echo esc_attr( $this->field_id ); ?>"
	class="<?php echo esc_attr( $this->field_class ); ?>"
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
