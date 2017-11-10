<?php
/**
 * Displays a field with a dynamically-typed control
 *
 * @package WP_Business_Reviews\Views\Fields
 * @since 1.0.0
 */

namespace WP_Business_Reviews;

$atts  = $context['atts'];
$value = $context['value'];
?>

<div id="wpbr-field-<?php echo esc_attr( $atts['id'] ); ?>" class="wpbr-field js-wpbr-field">
	<?php
	if ( 'label' === $atts['name_element'] ) {
		// Render field name in label tag.
		$this->render_partial( 'views/fields/field-label.php' );
	} else {
		// Render field name in span tag.
		$this->render_partial( 'views/fields/field-name.php' );
	}

	if ( ! empty( $atts['tooltip'] ) ) {
		// Render tooltip.
		$this->render_partial( 'views/tooltip.php' );
	}
	?>

	<div id="wpbr-field-control-wrap-<?php echo esc_attr( $atts['id'] ); ?>" class="wpbr-field__control-wrap">
		<?php
		// Render field control.
		$this->render_partial( "views/fields/controls/{$atts['control']}.php" );
		?>
	</div>

	<?php
	if ( ! empty( $atts['description'] ) ) {
		// Render field description.
		$this->render_partial( 'views/fields/field-description.php' );
	}
	?>
</div>
