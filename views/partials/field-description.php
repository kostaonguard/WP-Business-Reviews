<?php
/**
 * Displays the field description.
 *
 * Available Variables:
 *
 * @var View   $this The View object.
 * @var array  $context {
 *     Associative array with context variables.
 *
 *     @type string $description  Description to clarify field use.
 * }
 */

?>

<?php if ( ! empty( $context['description'] ) ) : ?>
	<p class="wpbr-field__description"><?php echo wp_kses_post( $context['description'] ); ?></p>
<?php endif; ?>
