<?php
if ( ! empty( $this->field_args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/name.php' );
}
?>

<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->field_id ); ?>" class="wpbr-field__control-wrap">
	<?php if ( ! empty( $this->value ) ) : ?>
		<ul class="wpbr-stacked-list wpbr-stacked-list--striped wpbr-stacked-list--border">
			<?php foreach ( $this->value as $page_id => $page_atts ) : ?>
				<?php
				$image_url = 'https://graph.facebook.com/' . $page_id . '/picture';
				$page_name = ! empty( $page_atts['name'] ) ? $page_atts['name'] : '';
				$page_url  = 'https://facebook.com/' . $page_id;
				?>
				<li class="wpbr-stacked-list__item wpbr-stacked-list__item--border-bottom">
					<div class="wpbr-media">
						<div class="wpbr-media__figure wpbr-media__figure--icon wpbr-media__figure--round">
							<img src="<?php echo esc_url( $image_url ); ?>">
						</div>
						<div class="wpbr-media__body">
							<div class="wpbr-review-source">
								<a class="wpbr-review-source__name" href="<?php echo esc_url( $page_url ); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo esc_html( $page_name ); ?>
								</a>
								<br>
								<span class="wpbr-review-source__id">
									<?php printf( esc_html__( 'ID: %s', 'wp-business-reviews' ), $page_id ); ?>
								</span>
							</div>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<button class="button js-wpbr-facebook-disconnect"><?php esc_html_e( 'Disconnect Facebook', 'wp-business-reviews' ) ?></button>
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
</div>
