<!-- Tabs -->
<nav>
	<ul class="wpbr-tabs">
		<?php foreach ( $settings as $tab ) : ?>
			<li><a href=""><?php echo esc_html( $tab['name'] ) ?></a></li>
		<?php endforeach; ?>
	</ul>
</nav>

<!-- Panel -->
<div class="wpbr-admin-page">
	<?php foreach ( $settings as $tab ) : ?>
		<div class="wpbr-panel js-wpbr-panel">
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
					<ul class="wpbr-nav-sections">
						<?php foreach ( $tab['sections'] as $section ) : ?>
							<li><a href=""><?php echo esc_html( $section['name'] ) ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<!-- Main -->
			<div class="wpbr-panel__main">
				<?php foreach ( $tab['sections'] as $section ) : ?>
					<div class="wpbr-admin-section js-wpbr-admin-section">
						<div class="wpbr-admin-section__header">

							<?php if ( ! empty( $section['heading'] ) ) : ?>
								<h2 class="wpbr-admin-section__heading"><?php echo esc_html( $section['heading'] ); ?></h2>
							<?php endif; ?>

							<?php if ( ! empty( $section['desc'] ) ) : ?>
								<p class="wpbr-admin-section__description"><?php echo wp_kses_post( $section['desc'] ); ?></p>
							<?php endif; ?>

							<form method="post">
								<?php foreach ( $section['fields'] as $field ) : ?>
									<?php if ( ! empty( $field['name'] ) ) : ?>
										<label><?php echo $field['name'] . ' (' . $field['type'] . ')'; ?></label><br>
									<?php endif; ?>
								<?php endforeach; ?>
							</form>

						</div>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	<?php endforeach; ?>
</div>
