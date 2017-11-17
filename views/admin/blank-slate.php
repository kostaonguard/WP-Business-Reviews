<div class="wpbr-blank-slate">
	<?php if ( ! empty( $this->image_url ) ) : ?>
		<img class="wpbr-blank-slate__image" src="<?php echo esc_url( $this->image_url ); ?>" alt="<?php echo esc_attr( $this->image_alt ); ?>">
	<?php endif; ?>

	<?php if ( ! empty( $this->heading ) ) : ?>
		<h2 class="wpbr-blank-slate__heading"><?php esc_html_e( $this->heading ); ?></h2>
	<?php endif; ?>

	<?php if ( ! empty( $this->message ) ) : ?>
		<p class="wpbr-blank-slate__message"><?php esc_html_e( $this->message ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $this->cta_text) && ! empty( $this->cta_link ) ) : ?>
		<a class="wpbr-blank-slate__cta button button-primary button-hero" href="<?php echo esc_url( $this->cta_link ); ?>"><?php esc_html_e( $this->cta_text ); ?></a>
	<?php endif; ?>

	<?php if ( ! empty( $this->help_text ) ) : ?>
		<p class="wpbr-blank-slate__help">
			<?php echo wp_kses_post( $this->help_text ); ?>
		</p>
	<?php endif; ?>
</div>
