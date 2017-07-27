<?php
/**
 * Displays brief message in WP Admin.
 *
 * Available Variables:
 *
 * string $image_url
 * string $image_alt
 * string $heading
 * string $message
 * string $cta_text
 * string $cta_link
 */
?>

<div class="wpbr-admin-callout">
	<?php if ( ! empty( $image_url ) ) : ?>
		<img class="wpbr-admin-callout__image" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
	<?php endif; ?>

	<h2 class="wpbr-admin-callout__heading"><?php esc_html_e( $heading ); ?></h2>

	<?php if ( ! empty( $message ) ) : ?>
		<p class="wpbr-admin-callout__message"><?php esc_html_e( $message ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $cta_text) && ! empty( $cta_link ) ) : ?>
		<a class="wpbr-button" href="<?php echo esc_url( $cta_link ); ?>"><?php esc_html_e( $cta_text ); ?></a>
	<?php endif; ?>
</div>
