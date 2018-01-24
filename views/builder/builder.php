<div id="wpbr-builder" class="wpbr-builder js-wpbr-builder">
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php?action=wp_business_reviews_save_builder' ) ); ?>">
		<input class="js-wpbr-action" type="text" name="action" value="wp_business_reviews_save_builder">
		<input class="js-wpbr-post-data" type="text" name="wp_business_reviews_post_data">
		<?php
		wp_nonce_field(
			'wp_business_reviews_save_builder',
			'wp_business_reviews_builder_nonce'
		);
		?>
		<div class="wpbr-builder__toolbar">
			<div id="titlediv" class="wpbr-builder__title ">
				<div id="titlewrap">
					<input type="text" name="post_title" size="30" value="" id="title" spellcheck="true" autocomplete="off" placeholder="Add title">
				</div>
			</div>
			<div class="wpbr-builder__tools">
				<ul class="wpbr-inline-list">
					<li class="wpbr-inline-list__item"><button type="button" id="wpbr-control-inspector" class="button"><?php esc_html_e( 'Settings', 'wp-business-reviews' ); ?></button></li>
					<li class="wpbr-inline-list__item"><button type="submit" id="wpbr-control-save" class="button button-primary"><?php esc_html_e( 'Save', 'wp-business-reviews' ); ?></button></li>
				</ul>
			</div>
		</div>
		<div class="wpbr-builder__workspace">
			<?php
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/builder/builder-preview.php' );
			$this->render_partial( WPBR_PLUGIN_DIR . 'views/builder/builder-inspector.php' );
			?>
		</div>
	</form>
</div>
