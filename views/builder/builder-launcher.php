<?php
$platform_count = count( $this->active_platforms );
?>

<div class="wpbr-launcher">
	<h2 class="wpbr-launcher__heading"><?php esc_html_e( 'Select a platform to build a new Review Set...', 'wp-business-reviews' ); ?></h2>
	<div class="wpbr-launcher__platforms">
		<ul class="wpbr-platform-gallery">
			<?php
			foreach ( $this->active_platforms as $platform_id => $platform_name ) :

				// Tweak the platform presentation based on its connection status.
				if ( in_array( $platform_id, array_keys( $this->connected_platforms ) ) ) {
					// Platform is connected.
					$cta_class = 'button button-primary';
					$cta_text = sprintf( __( 'Build %1$s Reviews', 'wp-business-reviews' ), esc_html( $platform_name ) );
					$cta_query_args = array(
						'wpbr_platform' => $platform_id,
					);
				} else {
					// Platform is not connected.
					$cta_class = 'button';
					$cta_text = sprintf( __( 'Connect to %1$s', 'wp-business-reviews' ), esc_html( $platform_name ) );
					$cta_query_args = array(
						'page'        => 'wpbr_settings',
						'wpbr_tab'    => 'general',
						'wpbr_subtab' => $platform_id,
					);
				}

				$cta_url       = add_query_arg( $cta_query_args );
				$platform_slug = str_replace( '_', '-', $platform_id );
				$image_url     = WPBR_ASSETS_URL . "images/platform-{$platform_slug}-160w.png";
				?>
				<li class="wpbr-platform-gallery__item wpbr-platform-gallery__item--<?php echo esc_attr( $platform_count ); ?>">
					<div class="wpbr-card wpbr-card--pad">
						<img class="wpbr-platform-gallery__image" src="<?php echo esc_attr( $image_url ); ?>" alt="Some alt text">
						<a class="<?php echo esc_attr( $cta_class ); ?>" href="<?php echo esc_url( $cta_url ); ?>">
							<?php echo esc_html( $cta_text ); ?>
						</a>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<h2 class="wpbr-launcher__heading"><?php esc_html_e( '...or load an existing Review Set.', 'wp-business-reviews' ); ?></h2>
	<?php // TODO: Make Review Set table dynamic. ?>
	<div class="wpbr-card">
		<table class="wpbr-post-table">
			<thead>
				<tr>
					<td><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
					<th><?php esc_html_e( 'Title', 'wp-business-reviews' ); ?></th>
					<th><?php esc_html_e( 'Business', 'wp-business-reviews' ); ?></th>
					<th><?php esc_html_e( 'Platform', 'wp-business-reviews' ); ?></th>
					<th><?php esc_html_e( 'Shortcode', 'wp-business-reviews' ); ?></th>
					<th><?php esc_html_e( 'Date', 'wp-business-reviews' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php for ( $i = 0; $i < 4; $i++ ) : ?>
				<tr>
					<td><input type="checkbox" name="" id=""></td>
					<td><a class="wpbr-post-table__title" href="">My Custom Title</a></td>
					<td>Company Name</td>
					<td>Facebook</td>
					<td><input type="text" disabled value="<?php echo esc_attr( '[wpbr_reviews id="123"]' ); ?>"></td>
					<td>2017/12/28</td>
				</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>
</div>
