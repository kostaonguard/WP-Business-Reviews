<?php
/**
 * Displays the field label and tooltip
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
 *     @type string $id      Field ID.
 *     @type string $name    Field name also used as label.
 *     @type string $tooltip Tooltip to clarify field purpose.
 * }
 */

namespace WP_Business_Reviews\Views;
?>

<label id="wpbr-label-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field__label js-wpbr-label" for="wpbr-control-<?php echo esc_attr( $context['id'] ); ?>">
	<?php esc_html_e( $context['name'] ); ?>
	<?php if ( ! empty( $context['tooltip'] ) ) : ?>
		<span id="wpbr-tooltip-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-tooltip wpbr-tooltip--medium wpbr-tooltip--right" aria-label="<?php echo esc_attr( $context['tooltip'] ); ?>"><span class="dashicons dashicons-editor-help"></span></span>
	<?php endif; ?>
</label>
