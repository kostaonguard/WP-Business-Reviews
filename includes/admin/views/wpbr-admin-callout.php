<?php
/**
 * Displays brief message in WP Admin.
 *
 * Available Variables:
 *
 * string $heading  Required.
 * string $message  Optional.
 * string $cta_text Optional.
 * string $cta_link Optional.
 */
?>

<div class="wpbr-admin-callout">
	<h2 class="wpbr-admin-callout__heading"><?php esc_html_e( $heading ); ?></h2>

	<?php if ( ! empty( $message ) ) : ?>
		<p class="wpbr-admin-callout__message"><?php esc_html_e( $message ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $cta_text) && ! empty( $cta_link ) ) : ?>
		<a class="wpbr-button" href="<?php echo esc_url( $cta_link ); ?>"><?php esc_html_e( $cta_text ); ?></a>
	<?php endif; ?>
</div>
