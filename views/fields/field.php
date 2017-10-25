<?php
/**
 * Displays a field with a dynamically-typed input
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Views
 * @since 1.0.0
 *
 * @var string $name_element The element used to wrap the field name. Expects
 *                           'label' if field includes a single control input
 *                           that can be focused; otherwise 'span'.
 * @var string $control_view The path of the field control view.
 * @var View   $this         The View object of the field.
 * @var array  $context {
 *     Associative array with context variables.
 *
 *     @type string $id           Field ID.
 *     @type string $name         Field name also used as label.
 *     @type string $type         Field type to determine Field subclass and control type.
 *     @type string $tooltip      Tooltip to clarify field purpose.
 *     @type string $description  Description to clarify field use.
 *     @type string $default      Default field value.
 *     @type string $value        Field value.
 *     @type array  $control_atts Additional attributes for the control element.
 *     @type array  $options      Field options for select/radios/checkboxes.
 *     @type string $view         View used to render the field.
 * }
 */

namespace WP_Business_Reviews;

// Use the field type to set the appropriate name element and control view.
switch ( $context['type'] ) {
	case 'select':
		$name_element = 'label';
		$control_view = 'views/fields/controls/select.php';
		break;
	case 'range':
		$name_element = 'label';
		$control_view = 'views/fields/controls/range.php';
		break;
	case 'search':
		$name_element = 'label';
		$control_view = 'views/fields/controls/search.php';
		break;
	case 'checkboxes':
		$name_element = 'span';
		$control_view = 'views/fields/controls/checkboxes.php';
		break;
	case 'radio':
		$name_element = 'span';
		$control_view = 'views/fields/controls/radio.php';
		break;
	default:
		$name_element = 'label';
		$control_view = 'views/fields/controls/input.php';
}
?>

<div id="wpbr-field-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field js-wpbr-field">

	<?php if ( 'label' === $name_element ) : ?>
		<label id="wpbr-field-name-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field__name" for="wpbr-field-control-<?php echo esc_attr( $context['id'] ); ?>">
			<?php esc_html_e( $context['name'] ); ?>
		</label>
	<?php else : ?>
		<span id="wpbr-field-name-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field__name">
			<?php esc_html_e( $context['name'] ); ?>
		</span>
	<?php endif; ?>

	<?php
	// Render the tooltip if available.
	if ( ! empty( $context['tooltip'] ) ) :
	?>
		<span id="wpbr-tooltip-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-tooltip wpbr-tooltip--medium wpbr-tooltip--right" aria-label="<?php echo esc_attr( $context['tooltip'] ); ?>"><span class="dashicons dashicons-editor-help"></span></span>
	<?php endif; ?>

	<div id="wpbr-field-control-wrap-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field__control-wrap">
		<?php
		// Render the control used to input a field value.
		$this->render_partial( $control_view );
		?>
	</div>

	<?php
	// Render the description if available.
	if ( ! empty( $context['description'] ) ) : ?>
		<p id="wpbr-field-description-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field__description"><?php echo wp_kses_post( $context['description'] ); ?></p>
	<?php endif; ?>

</div>
