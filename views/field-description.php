<?php
/**
 * Displays the field description
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
 *     @type string $id          Field ID.
 *     @type string $description Description to clarify field use.
 * }
 */

namespace WP_Business_Reviews\Views;
?>

<?php if ( ! empty( $context['description'] ) ) : ?>
	<p id="wpbr-field-description-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field__description"><?php echo wp_kses_post( $context['description'] ); ?></p>
<?php endif; ?>
