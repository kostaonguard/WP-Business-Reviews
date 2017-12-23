<nav>
	<ul class="wpbr-tabs js-wpbr-tabs">
		<?php foreach ( $this->config as $tab_id => $tab ) : ?>
			<li class="wpbr-tabs__item">
				<a
					id="wpbr-tab-<?php echo esc_attr( $tab_id ); ?>"
					class="wpbr-tabs__link js-wpbr-tab"
					href="#wpbr-panel-<?php echo esc_attr( $tab_id ); ?>"
					data-tab-id="<?php echo esc_attr( $tab_id ); ?>
					">
					<?php echo esc_html( $tab['name'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
