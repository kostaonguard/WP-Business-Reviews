<div class="wpbr-reviews-builder__preview">
	<div class="wpbr-notice wpbr-notice--warning js-wpbr-reviews-builder-notice" style="display: none;"><strong>Note:</strong> The Google API returns a maximum of 5 reviews, however your total number may grow over time as new reviews become available.</div>
	<div class="wpbr-wrap wpbr-theme--card js-wpbr-wrap">
		<ul class="wpbr-gallery js-wpbr-list">
			<?php for ( $i = 0; $i < 12; $i++ ) : ?>
				<li class="wpbr-gallery__item wpbr-gallery__item--3 js-wpbr-item" data-rating="5" data-time-created="">
					<div class="wpbr-review js-wpbr-review">
						<div class="wpbr-review__header js-wpbr-review-details">
							<div class="wpbr-review__image js-wpbr-review-image">
								<img src="" alt="" class="js-wpbr-review-image-el">
							</div>
							<div class="wpbr-review__details">
								<h3 class="wpbr-review__name js-wpbr-review-name">Firstname Lastname</h3>
								<div class="js-wpbr-review-rating">
									<span class="wpbr-stars wpbr-stars--generic wpbr-stars--google wpbr-stars--generic-5" aria-label="Rated 5.0 out of 5"></span>
									<span>★★★★★</span>
								</div>
								<span class="wpbr-review__timestamp js-wpbr-review-timestamp">Last week via Facebook</span>
							</div>
						</div>
						<div class="wpbr-review__body js-wpbr-review-body">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda beatae in laborum laudantium neque omnis optio quasi qui sit voluptatum!</p>
						</div>
					</div>
				</li>
			<?php endfor; ?>
		</ul>
	</div>
</div>
