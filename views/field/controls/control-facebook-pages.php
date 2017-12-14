<?php if ( ! empty( $this->value ) ) : ?>
	<ul class="wpbr-media-list">
		<?php foreach ( $this->value as $page_id => $page_atts ) : ?>
			<?php
			$image_url = 'https://graph.facebook.com/' . $page_id . '/picture';
			$page_name = ! empty( $page_atts['name'] ) ? $page_atts['name'] : '';
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
			<button class="button button-primary"><?php _e( 'Refresh Pages', 'wp-business-reviews' ); ?></button>
		</li>
		<li class="wpbr-inline-list__item">
			<button class="button"><?php esc_html_e( 'Disconnect Facebook', 'wp-business-reviews' ) ?></button>
		</li>
	</ul>
<?php else : ?>
	<?php
	if ( 'development' === WPBR_ENV ) {
		$scheme = 'http';
		$host   = 'wp-business-reviews-server.localhost';
	} else {
		$scheme = 'https';
		$host   = 'wpbusinessreviews.com';
	}

	$settings_url = admin_url() . 'edit.php?page=wpbr_settings&post_type=wpbr_review&wpbr_subtab=facebook&wpbr_tab=general';
	$url          = $scheme . '://' . $host . '/facebook-token/request/?wpbr_redirect=' . urlencode( $settings_url );
	?>
	<a class="button button-primary" href="<?php echo esc_url( $url ); ?>"><?php _e( 'Connect to Facebook', 'wp-business-reviews' ); ?></a>
<?php endif; ?>
