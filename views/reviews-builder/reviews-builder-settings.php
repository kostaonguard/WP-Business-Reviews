<div id="wpbr-reviews-builder-settings" class="wpbr-reviews-builder__settings">
	<?php foreach ( $this->config as $section_id => $section ) : ?>
		<div id="wpbr-section<?php echo esc_attr( $section_id ); ?>" class="wpbr-reviews-builder__section">
			<div class="wpbr-reviews-builder__section-header js-wpbr-section-header">
				<button class="wpbr-reviews-builder__toggle"  aria-expanded="true">
					<span class="screen-reader-text">Toggle section: <?php esc_html_e( $section['name'] ); ?></span>
					<span class="wpbr-reviews-builder__toggle-indicator js-wpbr-toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
				</button>
				<h3 class="wpbr-reviews-builder__section-heading"><?php esc_html_e( $section['name'] ); ?></h3>
			</div>
			<div class="wpbr-reviews-builder__section-body js-wpbr-section-body">
				<?php
				foreach ( $section['fields'] as $field_id ) {
					// Render the field object that matches the field ID present in the config.
					$field_object = $this->field_repository->get( $field_id )->render();
				}
				?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
