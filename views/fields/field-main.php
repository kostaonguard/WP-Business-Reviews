<?php
/**
 * Displays a field with a dynamically-typed control
 *
 * @package WP_Business_Reviews\Views\Fields
 * @since 1.0.0
 */

namespace WP_Business_Reviews;

$atts  = $this->context['atts'];
$value = $this->context['value'];
?>

<div id="wpbr-field-<?php echo esc_attr( $atts['id'] ); ?>" class="wpbr-field js-wpbr-field">
	<?php
	if ( 'label' === $atts['name_element'] ) {
		// Render field name in label tag.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/fields/field-label.php' );
	} else {
		// Render field name in span tag.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/fields/field-name.php' );
	}

	if ( ! empty( $atts['tooltip'] ) ) {
		// Render tooltip.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/tooltip.php' );
	}
	?>

	<div id="wpbr-field-control-wrap-<?php echo esc_attr( $atts['id'] ); ?>" class="wpbr-field__control-wrap">
		<?php
		// Render field control.
		$this->render_partial( WPBR_PLUGIN_DIR . "views/fields/controls/control-{$atts['control']}.php" );
		?>
	</div>

	<?php
	if ( ! empty( $atts['description'] ) ) {
		// Render field description.
		$this->render_partial( WPBR_PLUGIN_DIR . 'views/fields/field-description.php' );
	}
	?>
</div>