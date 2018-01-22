import Field from './field';
import BasicField from './basic-field';
import ButtonField from './button-field';
import PlatformSearchResults from './platform-search-results';
import axios from 'axios';
import queryString from 'query-string';

class PlatformSearchField extends Field {
	constructor( element ) {
		super( element );
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

	registerSearchButtonEventHandlers() {
		this.searchButtonField.control.addEventListener(
			'wpbrControlChange',
			event => {
				this.search(
					this.platformField.value,
					this.termsField.value,
					this.locationField.value
				);
			},
			{ once: true }
		);
	}

	search( platform, terms, location ) {
		const getReviewSourcesStartEvent = new CustomEvent(
			'wpbrGetReviewSourcesStart',
			{ bubbles: true }
		);

		const response = axios.post(
			ajaxurl,
			queryString.stringify({
				action: 'wpbr_search_review_source',
				platform: platform,
				terms: terms,
				location: location
			})
		)
			.then( response => {
				if ( response.data && 0 < response.data.length ) {
					const getReviewSourcesEndEvent = new CustomEvent(
						'wpbrGetReviewSourcesEnd',
						{
							bubbles: true,
							detail: { reviews: response.data }
						}
					);

					this.hideSearchFields();
					this.results = new PlatformSearchResults( this.root );
					this.results.init();
					this.results.replaceReviewSources( response.data );
					this.root.dispatchEvent( getReviewSourcesEndEvent );
					console.table( response.data );
				} else {
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

	clearSearch() {

		// this.searchInput.value = '';
	}

	clearResults() {

		// this.results.classList.add( 'wpbr-u-hidden' );
		// this.resetButton.classList.add( 'wpbr-u-hidden' );
		// this.resultsList.innerHTML = '';
		// remove event listeners
	}

	reset() {
		this.clearSearch();
		this.clearResults();
	}
}

export default PlatformSearchField;
