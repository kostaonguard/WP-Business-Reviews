<?php
$platform_count = count( $this->active_platforms );
?>

<div class="wpbr-launcher">
	<div class="wpbr-card">
		<h2 class="wpbr-launcher__heading"><?php esc_html_e( 'Select a platform to build a new Review Set...', 'wp-business-reviews' ); ?></h2>
		<div class="wpbr-launcher__platforms">
			<ul class="wpbr-platform-gallery">
				<?php
				foreach ( $this->active_platforms as $platform_id => $platform_name ) :
					$platform_url  = add_query_arg( array( 'wpbr_platform' => $platform_id ) );
					$platform_slug = str_replace( '_', '-', $platform_id );
					$image_url     = WPBR_ASSETS_URL . "images/platform-{$platform_slug}-160w.png";
				?>
					<li class="wpbr-platform-gallery__item wpbr-platform-gallery__item--<?php echo esc_attr( $platform_count ); ?>">
						<div class="wpbr-card">
							<img class="wpbr-platform-gallery__image" src="<?php echo esc_attr( $image_url ); ?>" alt="Some alt text">
							<a class="button button-primary" href="<?php echo esc_url( $platform_url ); ?>">
								<?php
								printf(
									__( 'Build %1$s Reviews', 'wp-business-reviews' ),
									esc_html( $platform_name )
								);
								?>
							</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
