<div class="wpbr-panel__sidebar">
	<ul class="wpbr-subtabs js-wpbr-subtabs">
		<?php foreach ( $this->sections as $section_id => $section ) : ?>
			<?php
			// Skip platform panel if not active.
			if (
				'general' === $this->tab_id
				&& 'platforms' !== $section_id
				&& ! in_array( $section_id, array_keys( $this->active_platforms ) ) ) {
				continue;
			}

			// Set status icon based on connection status.
			if ( 'status' === $section['icon'] ) {
				$section['icon'] = in_array( $section_id, array_keys( $this->connected_platforms ) ) ? 'success' : 'error';
			}
			?>
			<li class="wpbr-subtabs__item">
				<a id="wpbr-subtab-<?php echo esc_attr( $section_id ); ?>" class="wpbr-subtabs__link wpbr-icon wpbr-icon--<?php echo esc_attr( $section['icon'] ); ?> js-wpbr-subtab" href="#wpbr-section-<?php echo esc_attr( $section_id ); ?>" data-subtab-id="<?php echo esc_attr( $section_id ); ?>">
					<?php echo esc_html( $section['name'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
