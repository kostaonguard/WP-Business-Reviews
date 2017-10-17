<?php
/**
 * Displays a select element as the field control
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
 *     @type string $default      Default field value.
 *     @type string $value        Field value.
 *     @type array  $control_atts Additional attributes for the control element.
 *     @type array  $options      Field options for select/radios/checkboxes.
 * }
 */

namespace WP_Business_Reviews\Views;
?>

<select id="wpbr-field-control-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field__control" name="<?php echo esc_attr( $context['id'] ); ?>">
	<?php foreach ( $context['options'] as $value => $label ) : ?>
		<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value === $context['value'] ); ?>>
			<?php esc_html_e( $label ); ?>
		</option>
	<?php endforeach; ?>
</select>
