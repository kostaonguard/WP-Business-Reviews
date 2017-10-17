<?php
use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Fields\Field_Factory;

$config = new Config( WPBR_PLUGIN_DIR . 'config/reviews-builder.php' );
?>
<div class="wpbr-builder__controls">
	<?php foreach ( $config as $section ) : ?>
		<div id="wpbr-section<?php echo esc_attr( $section['id'] ); ?>" class="wpbr-builder__section">
			<div class="wpbr-builder__section-header js-wpbr-section-header">
				<button class="wpbr-builder__toggle"  aria-expanded="true">
					<span class="screen-reader-text">Toggle section: <?php esc_html_e( $section['name'] ); ?></span>
					<span class="wpbr-builder__toggle-indicator js-wpbr-toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
				</button>
				<h3 class="wpbr-builder__section-heading"><?php esc_html_e( $section['name'] ); ?></h3>
			</div>

			<div class="wpbr-builder__section-body js-wpbr-section-body">
				<?php foreach ( $section['fields'] as $atts ) : ?>
					<?php
					$field = Field_Factory::create( $atts );
					$field->render_view( $field->get_att( 'view' ) );
					?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>





<div class="wpbr-builder__controls">
	<div class="wpbr-builder__section">
		<div class="wpbr-builder__section-header js-wpbr-section-header">
			<button class="wpbr-builder__toggle"  aria-expanded="true">
				<span class="screen-reader-text">Toggle section: Presentation</span>
				<span class="wpbr-builder__toggle-indicator js-wpbr-toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
			</button>
			<h3 class="wpbr-builder__section-heading">Presentation Options</h3>
		</div>
		<div class="wpbr-builder__section-body js-wpbr-section-body">
			<div class="wpbr-field">
				<label class="wpbr-builder__label" for="">Format</label>
				<select class="wpbr-builder__select js-wpbr-builder-format" name="" id="">
					<option value="reviews-gallery">Gallery</option>
					<option value="reviews-list">List</option>
				</select>
			</div>
			<div class="wpbr-field js-wpbr-builder-max-columns-field" style="padding-bottom: 10px;">
				<label class="wpbr-builder__label" for="">Maximum Columns</label>
				<input class="js-wpbr-builder-max-columns" type="range" list="tickmarks" min="1" max="6" style="width: 100%;" value="3">
				<datalist id="tickmarks">
					<option value="1">
					<option value="2">
					<option value="3">
					<option value="4">
					<option value="5">
					<option value="6">
				</datalist>
			</div>
			<div class="wpbr-field">
				<label class="wpbr-builder__label" for="">Theme</label>
				<select class="wpbr-builder__select js-wpbr-builder-theme" name="wpbr-theme" id="wpbr-theme">
					<option value="card">Card</option>
					<option value="seamless-light">Seamless</option>
					<option value="seamless-dark">Seamless Dark</option>
				</select>
			</div>
		</div>
	</div>
	<div class="wpbr-builder__section">
		<div class="wpbr-builder__section-header js-wpbr-section-header">
			<button class="wpbr-builder__toggle"  aria-expanded="true">
				<span class="screen-reader-text">Toggle section: Business Options</span>
				<span class="wpbr-builder__toggle-indicator js-wpbr-toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
			</button>
			<h3 class="wpbr-builder__section-heading">Business Options</h3>
		</div>
		<div class="wpbr-builder__section-body js-wpbr-section-business">
			<div class="wpbr-field js-wpbr-field-platform">
				<label class="wpbr-builder__label js-wpbr-label" for="">Platform</label>
				<select class="wpbr-builder__select js-wpbr-control" name="" id="">
					<option value="">-- Select a Platform --</option>
					<option value="google" selected>Google</option>
					<option value="facebook">Facebook</option>
					<option value="yelp">Yelp</option>
					<option value="yp">YP</option>
				</select>
			</div>
			<div class="wpbr-field js-wpbr-field-search">
				<label class="wpbr-builder__label js-wpbr-label" for="">Business</label>
				<div class="wpbr-builder__control wpbr-builder__search js-wpbr-control">
					<input class="wpbr-builder__input wpbr-builder__input--search js-wpbr-search-input" type="text" placeholder="Business Name, Location">
					<button class="button js-wpbr-search-button"><?php esc_html_e( 'Search', 'wpbr' ); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div class="wpbr-builder__section">
		<div class="wpbr-builder__section-header js-wpbr-section-header">
			<button class="wpbr-builder__toggle"  aria-expanded="true">
				<span class="screen-reader-text">Toggle section: Review Options</span>
				<span class="wpbr-builder__toggle-indicator js-wpbr-toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
			</button>
			<h3 class="wpbr-builder__section-heading">Review Options</h3>
		</div>
		<div class="wpbr-builder__section-body js-wpbr-section-body">
<!--			<div class="wpbr-field">-->
<!--				<label class="wpbr-builder__label" for="">Minimum Star Rating</label>-->
<!--				<select class="wpbr-builder__select js-wpbr-control-star-rating" name="" id="">-->
<!--					<option value="5">5 Stars</option>-->
<!--					<option value="4">4 Stars</option>-->
<!--					<option value="3">3 Stars</option>-->
<!--					<option value="2">2 Stars</option>-->
<!--					<option value="1">1 Stars</option>-->
<!--				</select>-->
<!--			</div>-->
			<div class="wpbr-field">
				<label class="wpbr-builder__label" for="">Review Order</label>
				<select class="wpbr-builder__select js-wpbr-control-order" name="wpbr-theme" id="wpbr-theme">
					<option value="desc">Newest to Oldest</option>
					<option value="asc">Oldest to Newest</option>
				</select>
			</div>
			<div class="wpbr-field">
				<label class="wpbr-builder__label" for="">Review Components</label>
				<fieldset class="wpbr-field__fieldset">
					<legend class="wpbr-field__legend screen-reader-text">Review Components</legend>
					<ul class="wpbr-field__options">
						<li class="wpbr-field__option js-wpbr-field-reviewer-image-vis">
							<input id="checkbox1" type="checkbox"
								   name=""
								   value="" class="js-wpbr-control-reviewer-image-vis" checked>
							<label for="checkbox1">
								Show Reviewer Image
							</label>
						</li>
						<li class="wpbr-field__option js-wpbr-field-star-rating-vis">
							<input id="checkbox2" type="checkbox"
								   name=""
								   value="" class="js-wpbr-control-star-rating-vis" checked>
							<label for="checkbox2">
								Show Star Rating
							</label>
						</li>
						<li class="wpbr-field__option js-wpbr-field-timestamp-vis">
							<input id="checkbox3" type="checkbox"
								   name=""
								   value="" class="js-wpbr-control-timestamp-vis" checked>
							<label for="checkbox3">
								Show Review Date
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
