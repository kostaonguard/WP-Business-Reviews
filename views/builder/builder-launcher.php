<div id="wpbr-builder" class="wpbr-builder js-wpbr-builder">
	<div class="wpbr-builder__workspace">
		<div class="wpbr-builder__launcher">
			<div class="wpbr-card">
				<h2><?php esc_html_e( 'Select a platform to build a new Review Set...', 'wp-business-reviews' ); ?></h2>
				<ul>
					<?php
					foreach ( $this->active_platforms as $platform_id => $platform_name ) :
						$platform_url = add_query_arg( array( 'wpbr_platform' => $platform_id ) );
					?>
						<li><a href="<?php echo esc_url( $platform_url ); ?>"><?php esc_html_e( $platform_name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
