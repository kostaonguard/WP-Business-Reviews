<div class="wpbr-panel__main">
	<?php foreach ( $this->sections as $section_id => $section ) : ?>
		<div id="wpbr-section-<?php echo esc_attr( $section_id ); ?>" class="wpbr-panel__section js-wpbr-section" data-subtab-id="<?php echo esc_attr( $section_id ); ?>">
			<div class="wpbr-admin-header">
				<h2 class="wpbr-admin-header__heading"><?php echo esc_html( $section['heading'] ); ?></h2>

				<?php if ( ! empty( $section['description'] ) ) : ?>
					<p class="wpbr-admin-header__subheading">
						<?php echo wp_kses_post( $section['description'] ); ?>
					</p>
				<?php endif;?>

				<?php
				/**
				 * Triggers dynamic action using section ID.
				 *
				 * Useful for adding admin notices to a section such as
				 * when saving setting succeed or fail.
				 *
				 * @since 0.1.0
				 */
				do_action( 'wp_business_reviews_settings_notices_' . $section_id );
				?>
			</div>

			<?php if ( ! empty( $section['fields'] ) ) : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="wp_business_reviews_save_settings">
					<input type="hidden" name="wp_business_reviews_tab" value="<?php echo esc_attr( $this->tab_id ); ?>">
					<input type="hidden" name="wp_business_reviews_subtab" value="<?php echo esc_attr( $section_id ); ?>">
					<?php
					wp_nonce_field(
						'wp_business_reviews_save_settings',
						'wp_business_reviews_settings_nonce'
					);
					foreach ( $section['fields'] as $field_id => $field_args ) {
						if ( $this->field_repository->has( $field_id ) ) {
							$field_object = $this->field_repository->get( $field_id );
							$field_object->render();
						}
					}
					?>
				</form>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>
