<div class="wpbr-panel__main">
	<?php foreach ( $this->sections as $section ) : ?>
		<?php $save_button = isset( $section['save_button'] ) ? $section['save_button'] : true; ?>
		<div id="wpbr-section-<?php echo esc_attr( $section['id'] ); ?>" class="wpbr-panel__section js-wpbr-section" data-subtab-id="<?php echo esc_attr( $section['id'] ); ?>">
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
				do_action( 'wpbr_settings_notices_' . $section['id'] );
				?>
			</div>

			<?php if ( ! empty( $section['fields'] ) ) : ?>
				<form method="post">
					<input type="hidden" name="wpbr_section" value="<?php echo esc_attr( $section['id'] ); ?>">
					<?php
					// Render settings fields.
					foreach ( $section['fields'] as $field ) {
						$field->render( WPBR_PLUGIN_DIR . 'views/field/field-main.php' );
					}
					?>
				</form>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>
