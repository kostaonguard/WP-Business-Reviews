<div class="wpbr-admin-page">
	<div class="wpbr-builder js-wpbr-builder">
		<div class="wpbr-builder__toolbar">
			<div id="titlediv" class="wpbr-builder__title ">
				<div id="titlewrap">
					<input type="text" name="post_title" size="30" value="" id="title" spellcheck="true" autocomplete="off" placeholder="Add title">
				</div>
			</div>
			<div class="wpbr-builder__tools">
				<ul class="wpbr-inline-list">
					<li class="wpbr-inline-list__item"><button id="wpbr-control-settings" class="button"><?php esc_html_e( 'Settings', 'wpbr' ); ?></button></li>
					<li class="wpbr-inline-list__item"><button id="wpbr-control-save" class="button button-primary"><?php esc_html_e( 'Save Review Set', 'wpbr' ); ?></button></li>
				</ul>
			</div>
		</div>
		<div class="wpbr-builder__workspace">
			<?php
			$this->render_partial( 'views/reviews-builder-preview.php' );
			$this->render_partial( 'views/reviews-builder-controls.php' );
			?>
		</div>
	</div>
</div>
