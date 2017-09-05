<div class="wpbr-admin-page">
	<div class="wpbr-builder">
		<div class="wpbr-builder__controls">

			<div class="wpbr-builder__section">
				<div class="wpbr-builder__section-header">
					<button class="wpbr-builder__toggle"  aria-expanded="true">
						<span class="screen-reader-text">Toggle section: Presentation</span>
						<span class="wpbr-builder__toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
					</button>
					<h3 class="wpbr-builder__section-heading">Presentation Options</h3>
				</div>
				<div class="wpbr-builder__section-body">
					<div class="wpbr-field">
						<label class="wpbr-builder__label" for="">Format</label>
						<select class="wpbr-builder__select" name="" id="">
							<option value="reviews-list">Gallery</option>
							<option value="reviews-list">List</option>
							<option value="reviews-list">Badge</option>
						</select>
					</div>
					<div class="wpbr-field">
						<label class="wpbr-builder__label" for="">Theme</label>
						<select class="wpbr-builder__select js-wpbr-builder-theme" name="wpbr-theme" id="wpbr-theme">
							<option value="card">Card</option>
							<option value="seamless-light">Seamless - Light</option>
							<option value="seamless-dark">Seamless - Dark</option>
						</select>
					</div>
				</div>
			</div>
			<div class="wpbr-builder__section">
				<div class="wpbr-builder__section-header">
					<button class="wpbr-builder__toggle"  aria-expanded="true">
						<span class="screen-reader-text">Toggle section: Business Options</span>
						<span class="wpbr-builder__toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
					</button>
					<h3 class="wpbr-builder__section-heading">Business Options</h3>
				</div>
				<div class="wpbr-builder__section-body">
					<div class="wpbr-field">
						<label class="wpbr-builder__label" for="">Platform</label>
						<select class="wpbr-builder__select" name="" id="">
							<option value="google">Google</option>
							<option value="facebook">Facebook</option>
							<option value="yelp">Yelp</option>
							<option value="yp">YP</option>
						</select>
					</div>
					<div class="wpbr-field">
						<label class="wpbr-builder__label" for="">Business</label>
						<div class="wpbr-builder__search">
							<input class="wpbr-builder__input wpbr-builder__input--search" type="text">
							<button class="button"><?php esc_html_e( 'Search', 'wpbr' ); ?></button>
						</div>
						<p class="wpbr-builder__description">Search by business name and location or Google Place ID.</p>
					</div>
				</div>
			</div>
			<div class="wpbr-builder__section">
				<div class="wpbr-builder__section-header">
					<button class="wpbr-builder__toggle"  aria-expanded="true">
						<span class="screen-reader-text">Toggle section: Review Options</span>
						<span class="wpbr-builder__toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
					</button>
					<h3 class="wpbr-builder__section-heading">Review Options</h3>
				</div>
				<div class="wpbr-builder__section-body">
					<div class="wpbr-field">
						<label class="wpbr-builder__label" for="">Sort Order</label>
						<select class="wpbr-builder__select" name="" id="">
							<option value="google">Newest to Oldest</option>
						</select>
					</div>
					<div class="wpbr-field">
						<label class="wpbr-builder__label" for="">Minimum Star Rating</label>
						<select class="wpbr-builder__select" name="" id="">
							<option value="google">5 Stars</option>
						</select>
					</div>
					<div class="wpbr-field">
						<label class="wpbr-builder__label" for="">Review Components</label>
						<fieldset class="wpbr-field__fieldset">
							<legend class="wpbr-field__legend screen-reader-text"><?php echo esc_html( $field['name'] ); ?></legend>
							<ul class="wpbr-field__options">
								<li class="wpbr-field__option">
									<input id="" type="checkbox"
									       name=""
									       value="">
									<label for="">
										Show Reviewer Image
									</label>
								</li>
								<li class="wpbr-field__option">
									<input id="" type="checkbox"
									       name=""
									       value="">
									<label for="">
										Show Star Rating
									</label>
								</li>
								<li class="wpbr-field__option">
									<input id="" type="checkbox"
									       name=""
									       value="">
									<label for="">
										Show Review Date
									</label>
								</li>
								<li class="wpbr-field__option">
									<input id="" type="checkbox"
									       name=""
									       value="">
									<label for="">
										Show Blank Reviews
									</label>
								</li>
							</ul>
						</fieldset>
					</div>
					<div class="wpbr-field">
						<button class="button button-primary">Save Template</button>
					</div>
				</div>
			</div>
		</div>
		<div class="wpbr-builder__preview">
			<div class="wpbr-wrap wpbr-theme--card js-wpbr-wrap">
				<ul class="wpbr-gallery js-wpbr-reviews-list">
					<?php for ( $i = 0; $i < 12; $i++ ) : ?>
						<li class="wpbr-gallery__item wpbr-gallery__item--3 js-wpbr-reviews-item">
							<div class="wpbr-review js-wpbr-review">
								<div class="wpbr-review__header">
									<div class="wpbr-review__image">
										<img src="<?php echo WPBR_ASSETS_URL . 'images/demo-user-placeholder.png'; ?>">
									</div>
									<div class="wpbr-review__details">
										<h3 class="wpbr-review__name">Firstname Lastname</h3>
										<span class="wpbr-stars wpbr-stars--generic wpbr-stars--google wpbr-stars--generic-5" aria-label="Rated 5.0 out of 5"></span>
										<span>★★★★★</span>
										<span class="wpbr-review__timestamp">1 hour ago</span>
									</div>
								</div>
								<div class="wpbr-review__body">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam autem eveniet, nisi obcaecati perferendis porro ratione reiciendis sint. A alias enim fugiat obcaecati optio.</p>
								</div>
							</div>
						</li>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
