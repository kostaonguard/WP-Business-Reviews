<?php if ( ! empty( $this->value ) ) : ?>
	<div class="wpbr-scrollable wpbr-scrollable--border">
		<ul class="wpbr-stacked-list wpbr-stacked-list--striped">
			<?php foreach ( $this->value as $page_id => $page_atts ) : ?>
				<?php
				$image_url = 'https://graph.facebook.com/' . $page_id . '/picture';
				$page_name = ! empty( $page_atts['name'] ) ? $page_atts['name'] : '';
				$page_url  = 'https://facebook.com/' . $page_id;
				?>
				<li class="wpbr-stacked-list__item wpbr-stacked-list__item--border-bottom">
					<div class="wpbr-media">
						<div class="wpbr-media__figure wpbr-media__figure--icon wpbr-media__figure--round">
							<img src="<?php echo esc_url( $image_url ); ?>">
						</div>
						<div class="wpbr-media__body">
							<div class="wpbr-review-source">
								<a class="wpbr-review-source__name" href="<?php echo esc_url( $page_url ); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo esc_html( $page_name ); ?>
								</a>
								<br>
								<button class="wpbr-review-source__button button button-primary js-wpbr-get-reviews-button"><?php echo esc_html( 'Get Reviews', 'wp-business-reviews' ); ?></button>
							</div>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php else : ?>

<?php endif; ?>
