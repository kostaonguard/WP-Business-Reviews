<div class="wpbr-launcher">
	<div class="wpbr-card">
		<h2 class="wpbr-launcher__heading"><?php esc_html_e( 'Select a platform to build a new Review Set...', 'wp-business-reviews' ); ?></h2>
		<ul class="wpbr-logo-gallery">
			<?php
			foreach ( $this->active_platforms as $platform_id => $platform_name ) :
				$platform_url = add_query_arg( array( 'wpbr_platform' => $platform_id ) );
			?>
				<li class="wpbr-logo-gallery__item">
					<a href="<?php echo esc_url( $platform_url ); ?>"><?php esc_html_e( $platform_name ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<h2 class="wpbr-launcher__heading"><?php esc_html_e( '...or select an existing Review Set.', 'wp-business-reviews' ); ?></h2>
	</div>
</div>
