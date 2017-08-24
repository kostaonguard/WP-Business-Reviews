<?php
/**
 * Displays blank slate message in the event of an empty list table.
 *
 * Available Variables:
 *
 * @var string $image_url Image URL.
 * @var string $image_alt Image alt text.
 * @var string $heading   Heading text.
 * @var string $message   Body copy.
 * @var string $cta_text  Button text.
 * @var string $cta_link  Button link.
 * @var string $help_text Help text, may contain a link to docs
 */
?>

<div class="wpbr-blank-slate">
	<?php if ( ! empty( $image_url ) ) : ?>
		<img class="wpbr-blank-slate__image" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
	<?php endif; ?>

	<?php if ( ! empty( $heading ) ) : ?>
		<h2 class="wpbr-blank-slate__heading"><?php esc_html_e( $heading ); ?></h2>
	<?php endif; ?>

	<?php if ( ! empty( $message ) ) : ?>
		<p class="wpbr-blank-slate__message"><?php esc_html_e( $message ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $cta_text) && ! empty( $cta_link ) ) : ?>
		<a class="wpbr-blank-slate__cta button button-primary button-hero" href="<?php echo esc_url( $cta_link ); ?>"><?php esc_html_e( $cta_text ); ?></a>
	<?php endif; ?>

	<?php if ( ! empty( $help_text ) ) : ?>
		<p class="wpbr-blank-slate__help">
			<?php
			$allowed_html = array(
				'a'      => array(
					'href'   => array(),
					'title'  => array(),
					'target' => array(),
				),
				'em'     => array(),
				'strong' => array(),
				'code'   => array(),
			);

			echo wp_kses( $help_text, $allowed_html );
			?>
		</p>
	<?php endif; ?>
</div>
