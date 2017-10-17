<?php
/**
 * Displays a field
 *
 * A field consists of a label, tooltip, control, and description. Fields are
 * used throughout the plugin in areas such as Settings or the Reviews Builder.
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Views
 * @since 1.0.0
 *
 * @var View  $this The View object.
 * @var array $context {
 *     Associative array with context variables.
 *
 *     @type string $id           Field ID.
 *     @type string $name         Field name also used as label.
 *     @type string $type         Field type to determine Field subclass.
 *     @type string $tooltip      Tooltip to clarify field purpose.
 *     @type string $description  Description to clarify field use.
 *     @type string $default      Default field value.
 *     @type string $value        Field value.
 *     @type array  $control_atts Placeholder value for relevant input types.
 *     @type array  $options      Field options for select/radios/checkboxes.
 *     @type string $view         View used to render the field.
 * }
 */

namespace WP_Business_Reviews\Views;
?>

<div id="wpbr-field-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field js-wpbr-field">

	<?php
	// Render the field label.
	$this->render_partial(
		'views/field-label.php',
		$this->narrow_context( $context, array( 'id', 'name', 'tooltip' ) )
	);

	// Render the field control.
	$this->render_partial(
		'views/field-control-select.php',
		$this->narrow_context( $context, array( 'id', 'default', 'value', 'control_atts', 'options' ) )
	);

	// Render the field description.
	$this->render_partial(
		'views/field-description.php',
		$this->narrow_context( $context, array( 'id', 'description' ) )
	);
	?>

</div>
