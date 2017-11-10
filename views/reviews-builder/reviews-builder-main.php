<div class="wpbr-admin-page">
	<div id="wpbr-reviews-builder" class="wpbr-reviews-builder js-wpbr-reviews-builder">
		<div class="wpbr-reviews-builder__toolbar">
			<div id="titlediv" class="wpbr-reviews-builder__title ">
				<div id="titlewrap">
					<input type="text" name="post_title" size="30" value="" id="title" spellcheck="true" autocomplete="off" placeholder="Add title">
				</div>
			</div>
			<div class="wpbr-reviews-builder__tools">
				<ul class="wpbr-inline-list">
					<li class="wpbr-inline-list__item"><button id="wpbr-control-settings" class="button"><?php esc_html_e( 'Settings', 'wpbr' ); ?></button></li>
					<li class="wpbr-inline-list__item"><button id="wpbr-control-save" class="button button-primary"><?php esc_html_e( 'Save Review Set', 'wpbr' ); ?></button></li>
				</ul>
			</div>
		</div>
		<div class="wpbr-reviews-builder__workspace">
			<?php
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/reviews-builder/reviews-builder-preview.php' );
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/reviews-builder/reviews-builder-settings.php' );
			?>
		</div>
	</div>
</div>
