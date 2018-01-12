import Field from './field';
import BasicField from './basic-field';
import ButtonField from './button-field';
import PlatformSearchResults from './platform-search-results';
import axios from 'axios';
import queryString from 'query-string';

class PlatformSearchField extends Field {
	constructor( element ) {
		super( element );

		// TODO: Figure out if all properties should be declared in constructor.
	}

	init() {
		this.initSubfields();
		this.registerSearchButtonEventHandlers();
	}

	initSubfields() {
		this.platformField = new BasicField(
			this.root.querySelector(
				'[data-wpbr-field-id="platform_search_platform"]'
			)
		);
		this.termsField = new BasicField(
			this.root.querySelector(
				'[data-wpbr-field-id="platform_search_terms"]'
			)
		);
		this.locationField = new BasicField(
			this.root.querySelector(
				'[data-wpbr-field-id="platform_search_location"]'
			)
		);
		this.searchButtonField = new ButtonField(
			this.root.querySelector(
				'[data-wpbr-field-id="platform_search_button"]'
			)
		);

		this.platformField.init();
		this.termsField.init();
		this.locationField.init();
		this.searchButtonField.init();
	}

	initReviewsButtons() {
		this.reviewsButtons = this.root.querySelectorAll( '.js-wpbr-get-reviews-button' );
		this.registerReviewsButtonEventHandlers();
	}

	registerSearchButtonEventHandlers() {
		this.searchButtonField.emitter.once( 'wpbrcontrolchange', () => {
			this.search(
				this.platformField.value,
				this.termsField.value,
				this.locationField.value
			);
		});
	}

	registerReviewsButtonEventHandlers() {
		this.reviewsButtons.forEach( ( button ) => {
			button.addEventListener( 'click', ( event ) => {
				console.log( 'clicked review' );

				// this.populateReviews( controlId, controlValue );
			});
		});
	}

	search( platform, terms, location ) {
		const response = axios.post(
			ajaxurl,
			queryString.stringify({
				action: 'wpbr_platform_search',
				platform: platform,
				terms: terms,
				location: location
			})
		)
			.then( response => {
				if ( response.data && 0 < response.data.length ) {

					// Hide search input fields.
					this.hideSearchFields();
					this.results = new PlatformSearchResults( this.root, this.platformField.value );
					this.results.populateResults( response.data );
					this.initReviewsButtons();
				} else {

					// No results to populate, so the button needs re-enabled to try again.
					this.registerSearchButtonEventHandlers();
				}
			})
			.catch( error => {

				// TODO: Handle error of failed platform search request.
			});
	}

	hideSearchFields() {
		this.termsField.hide();
		this.locationField.hide();
		this.searchButtonField.hide();
	}
}

export default PlatformSearchField;
