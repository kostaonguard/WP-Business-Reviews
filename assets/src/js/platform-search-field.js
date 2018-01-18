import Field from './field';
import BasicField from './basic-field';
import ButtonField from './button-field';
import PlatformSearchResults from './platform-search-results';
import toggleVisibility from './visibility-toggle';
import axios from 'axios';
import queryString from 'query-string';

class PlatformSearchField extends Field {
	constructor( element ) {
		super( element );
		this.isSearchEnabled = true;
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
				if ( this.isSearchEnabled ) {
					this.search(
						this.platformField.value,
						this.termsField.value,
						this.locationField.value
					);
				}
			}
		);
	}

	search( platform, terms, location ) {
		this.isSearchEnabled = false;

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
					const customEvent = new CustomEvent( 'wpbrReviewSourcesReady', {
						bubbles: true
					});

					this.hideSearchFields();
					this.results = new PlatformSearchResults( this.root, this.platformField.value );
					this.results.populateResults( response.data );

					// Emit custom event that passes the review sources.
					this.root.dispatchEvent( customEvent );

					console.table( response.data );
				} else {
				}
			})
			.catch( error => {

				// TODO: Handle error of failed platform search request.
			});
	}

	hideSearchFields() {
		toggleVisibility( this.termsField.root );
		toggleVisibility( this.locationField.root );
		toggleVisibility( this.searchButtonField.root );
	}

	clearSearch() {

		// this.searchInput.value = '';
	}

	clearResults() {

		// this.results.classList.add( 'wpbr-u-hidden' );
		// this.resetButton.classList.add( 'wpbr-u-hidden' );
		// this.resultsList.innerHTML = '';
		// remove event listeners
		// this.isSearchEnabled = true;
	}

	reset() {
		this.clearSearch();
		this.clearResults();
	}
}

export default PlatformSearchField;
