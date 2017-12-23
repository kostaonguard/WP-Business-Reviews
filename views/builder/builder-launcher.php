<div id="wpbr-builder" class="wpbr-builder js-wpbr-builder">
	<div class="wpbr-builder__workspace">
		<div class="wpbr-builder__launcher">
			<div class="wpbr-card">
				<h2><?php esc_html_e( 'Select a platform to build a new Review Set...', 'wp-business-reviews' ); ?></h2>
				<ul>
					<?php foreach ( $this->active_platforms as $platform_id => $platform_name ) : ?>
						<li><?php esc_html_e( $platform_name ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
