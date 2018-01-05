<?php
$field_classes = array(
	'wpbr-field',
	"wpbr-field-{$this->args['type']}",
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
	if ( ! empty( $this->args['name'] ) ) {
		if ( ! empty( $this->args['name_element'] ) && 'label' === $this->args['name_element'] ) {
			// Render field name in label tag.
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/field-label.php' );
		} else {
			// Render field name in span tag (intended for use alongside fieldsets).
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/field-name.php' );
		}
	}
	?>

	<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__control-wrap">
		<?php
		// Render field control.
		$type = str_replace( '_', '-', $this->args['type'] );

		switch ( $this->args['type'] ) {
			case 'checkboxes':
				$type = 'checkboxes';
				break;
			case 'facebook_pages':
				$type = 'facebook-pages';
				break;
			case 'platform_status':
				$type = 'platform-status';
				break;
			case 'radio':
				$type = 'radio';
				break;
			case 'save':
				$type = 'save';
				break;
			case 'search':
				$type = 'search';
				break;
			case 'select':
				$type = 'select';
				break;
			case 'button':
				$type = 'button';
				break;
			default:
				$type = 'input';
		}

		$this->render_partial( WPBR_PLUGIN_DIR . "views/field/controls/control-{$type}.php" );

		if ( ! empty( $this->args['description'] ) ) {
			// Render field description.
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/field-description.php' );
		}
		?>
	</div>
</div>
