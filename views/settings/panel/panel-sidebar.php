<div class="wpbr-panel__sidebar">
	<ul class="wpbr-subtabs js-wpbr-subtabs">
		<?php foreach ( $this->sections as $section ) : ?>
			<li class="wpbr-subtabs__item">
				<a id="wpbr-subtab-<?php echo esc_attr( $section['id'] ); ?>" class="wpbr-subtabs__link wpbr-icon wpbr-icon--<?php echo esc_attr( $section['icon'] ); ?> js-wpbr-subtab" href="#wpbr-section-<?php echo esc_attr( $section['id'] ); ?>" data-subtab-id="<?php echo esc_attr( $section['id'] ); ?>">
					<?php echo esc_html( $section['name'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
