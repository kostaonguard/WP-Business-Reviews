<!-- Tabs -->
<nav>
	<ul class="wpbr-tabs js-wpbr-tabs">
		<?php foreach ( $settings as $tab ) : ?>
			<?php
			$tab_id   = ! empty( $tab['id'] ) ? str_replace( '_', '-', $tab['id'] ) : '';
			$tab_name = ! empty( $tab['name'] ) ? $tab['name'] : '';
			?>
			<li class="wpbr-tabs__item">
				<a id="wpbr-tab-<?php echo esc_attr( $tab_id ); ?>" class="wpbr-tabs__link js-wpbr-tab" href="#wpbr-panel-<?php echo esc_attr( $tab_id ); ?>" data-tab-id="<?php echo esc_attr( $tab_id ); ?>"><?php echo esc_html( $tab_name ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<!-- Panels -->
<div class="wpbr-admin-page">
	<?php foreach ( $settings as $tab ) : ?>
		<!-- Panel -->
		<?php $tab_id = ! empty( $tab['id'] ) ? str_replace( '_', '-', $tab['id'] ) : ''; ?>
		<div id="wpbr-panel-<?php echo esc_attr( $tab_id ); ?>" class="wpbr-panel js-wpbr-panel" data-tab-id="<?php echo esc_attr( $tab_id ); ?>">
			<?php
			// Do not render if no sections.
			if ( empty( $tab['sections'] ) ) {
				continue;
			}
			?>

			<?php
			// Show sections navigation if more than one section exists.
			if ( count( $tab['sections'] ) > 1 ) :
			?>
				<!-- Sidebar -->
				<div class="wpbr-panel__sidebar">
					<ul class="wpbr-subtabs js-wpbr-subtabs">
						<?php foreach ( $tab['sections'] as $section ) : ?>
							<?php
							$section_id   = ! empty( $section['id'] ) ? str_replace( '_', '-', $section['id'] ) : '';
							$section_name = ! empty( $section['name'] ) ? $section['name'] : '';
							?>
							<li class="wpbr-subtabs__item">
								<a id="wpbr-subtab-<?php echo esc_attr( $section_id ); ?>" class="wpbr-subtabs__link js-wpbr-subtab" href="#wpbr-section-<?php echo esc_attr( $section_id ); ?>" data-subtab-id="<?php echo esc_attr( $section_id ); ?>">
									<?php echo esc_html( $section_name ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<!-- Main -->
			<div class="wpbr-panel__main">
				<?php foreach ( $tab['sections'] as $section ) : ?>
					<?php
					$section_id          = ! empty( $section['id'] ) ? str_replace( '_', '-', $section['id'] ) : '';
					$section_heading     = ! empty( $section['heading'] ) ? $section['heading'] : '';
					$section_description = ! empty( $section['desc'] ) ? $section['desc'] : '';
					$allowed_html        = array(
						'a'      => array(
							'href'   => array(),
							'title'  => array(),
							'target' => array(),
						),
						'em'     => array(),
						'strong' => array(),
					);
					$save_button = isset( $section['save_button'] ) ? $section['save_button'] : true;
					?>

					<!-- Section -->
					<div id="wpbr-section-<?php echo esc_attr( $section_id ); ?>" class="wpbr-panel__section js-wpbr-section" data-subtab-id="<?php echo esc_attr( $section_id ); ?>">
						<div class="wpbr-panel__header">
							<h2 class="wpbr-panel__heading"><?php echo esc_html( $section_heading ); ?></h2>
							<p class="wpbr-panel__description"><span class="dashicons dashicons-editor-help"  aria-hidden="true"></span> <?php echo wp_kses( $section_description, $allowed_html ); ?></p>

							<?php
							/**
							 * Triggers dynamic action using section ID.
							 *
							 * Useful for adding admin notices to a section such as
							 * when saving setting succeed or fail.
							 *
							 * @since 1.0.0
							 */
							do_action( 'wpbr_settings_notices_' . $section_id );
							?>
						</div>

						<?php if ( ! empty( $section['fields'] ) ) : ?>
							<form method="post">
								<?php
								// Render settings fields.
								array_map( array( $this, 'render_field' ), $section['fields'] );
								?>

								<input type="hidden" name="action" value="wpbr_settings_save">
								<input type="hidden" name="wpbr_tab" value="<?php echo esc_attr( $tab_id ); ?>">
								<input type="hidden" name="wpbr_section" value="<?php echo esc_attr( $section_id ); ?>">

								<?php if ( $save_button ) : ?>
									<?php wp_nonce_field( 'wpbr_settings_save', 'wpbr_settings_nonce' ); ?>
									<div class="wpbr-settings-field wpbr-settings-field--submit">
										<button class="<?php esc_attr_e( 'wpbr-button', 'wpbr' ); ?>" type="submit" name="submit"  value="submit"><?php esc_attr_e( 'Save Changes', 'wpbr' ); ?></button>
									</div>
								<?php endif; ?>
							</form>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	<?php endforeach; ?>
</div>
