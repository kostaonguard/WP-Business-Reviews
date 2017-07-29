<!-- Tabs -->
<nav>
	<ul class="wpbr-tabs">
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

<!-- Panel -->
<div class="wpbr-admin-page">
	<?php foreach ( $settings as $tab ) : ?>
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
					<ul class="wpbr-subtabs">
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
					?>

					<!-- Section -->
					<div id="wpbr-section-<?php echo esc_attr( $section_id ); ?>" class="wpbr-panel__section js-wpbr-section" data-subtab-id="<?php echo esc_attr( $section_id ); ?>">
						<h2 class="wpbr-panel__heading"><?php echo esc_html( $section_heading ); ?></h2>
						<p class="wpbr-panel__description"><?php echo wp_kses( $section_description, $allowed_html ); ?></p>

						<form method="post">
							<table class="form-table">
								<tbody>
									<?php
									if ( ! empty( $section['fields'] ) ) {
										// Render settings field.
										array_map( array( $settings_api, 'render_field' ), $section['fields'] );
									}
									?>
								</tbody>
							</table>
							<?php if ( 'pro-features' !== $section_id ) : ?>
								<div class="wpbr-settings-field wpbr-settings-field--submit">
									<input type="submit" name="submit" class="<?php esc_attr_e( 'wpbr-button', 'wpbr' ); ?>" value="<?php esc_attr_e( 'Save Changes', 'wpbr' ); ?>">
								</div>
							<?php endif; ?>
						</form>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	<?php endforeach; ?>
</div>
