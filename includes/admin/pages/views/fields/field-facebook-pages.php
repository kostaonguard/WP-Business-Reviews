<div class="wpbr-field wpbr-field--facebook-pages<?php echo ! empty( $class ) ? ' ' . esc_attr( $class ) : ''; ?>">
	<span class="wpbr-field__name"><?php echo esc_html( $field['name'] ); ?></span>
	<div class="wpbr-field__control">
		<?php if ( ! empty( $saved_value ) ) : ?>
			<ul class="wpbr-media-list">
				<?php foreach ( $saved_value as $page_id => $atts ) : ?>
					<?php
					$image_url = 'https://graph.facebook.com/' . $page_id . '/picture';
					$page_name = ! empty( $atts['name'] ) ? $atts['name'] : '';
					$page_url  = 'https://facebook.com/' . $page_id;
					?>
					<li class="wpbr-media-list__item">
						<a class="wpbr-media-list__link" href="<?php echo esc_url( $page_url ); ?>" target="_blank" rel="noopener noreferrer">
							<img class="wpbr-media-list__image wpbr-media-list__image--avatar" src="<?php echo esc_url( $image_url ); ?>" alt="">
							<div class="wpbr-media-list__content">
								<?php esc_html_e( $page_name ); ?>
							</div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<ul class="wpbr-inline-list">
				<li class="wpbr-inline-list__item">
					<button class="button button-primary"><?php _e( 'Refresh Pages', 'wpbr' ); ?></button>
				</li>
				<li class="wpbr-inline-list__item">
					<button class="button"><?php esc_html_e( 'Disconnect Facebook', 'wpbr' ) ?></button>
				</li>
			</ul>
		<?php else : ?>
			<a class="wpbr-button"
			   href="https://wordimpress.com/wi-api/get_token"><?php _e( 'Connect to Facebook', 'wpbr' ); ?></a>
		<?php endif; ?>
	</div>
	<?php if ( ! empty( $field['desc'] ) ) : ?>
		<p class="wpbr-field__description"><?php $this->render_field_description( $field['desc'] ); ?></p>
	<?php endif; ?>
</div>
