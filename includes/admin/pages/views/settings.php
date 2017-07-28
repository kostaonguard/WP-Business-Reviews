<!-- Tabs -->
<nav>
	<ul class="wpbr-tabs">
		<?php foreach ( $settings as $tab ) : ?>
			<li class="wpbr-tabs__item">
				<a class="wpbr-tabs__link" href="">
					<?php echo esc_html( $tab['name'] ) ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<!-- Panel -->
<div class="wpbr-admin-page">
	<?php foreach ( $settings as $tab ) : ?>
		<div class="wpbr-panel">
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
					<ul class="wpbr-list-menu">
						<?php foreach ( $tab['sections'] as $section ) : ?>
							<li class="wpbr-list-menu__item">
								<a class="wpbr-list-menu__link" href="">
									<?php echo esc_html( $section['name'] ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<!-- Main -->
			<div class="wpbr-panel__main">
				<?php foreach ( $tab['sections'] as $section ) : ?>
					<div class="wpbr-panel__section">

						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h2 class="wpbr-panel__heading"><?php echo esc_html( $section['heading'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $section['desc'] ) ) : ?>
							<p class="wpbr-panel__description"><?php echo wp_kses_post( $section['desc'] ); ?></p>
						<?php endif; ?>

						<form method="post">

							<table class="form-table">
								<tbody>
									<?php
									foreach ( $section['fields'] as $field_id => $atts ) {
										$settings_api->render_field( $field_id, $atts );
									}
									?>
								</tbody>
							</table>

							<div class="wpbr-settings-field wpbr-settings-field--submit">
								<input type="submit" name="submit" class="<?php esc_attr_e( 'wpbr-button', 'wpbr' ); ?>" value="<?php esc_attr_e( 'Save Changes', 'wpbr' ); ?>">
							</div>

						</form>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	<?php endforeach; ?>
</div>
