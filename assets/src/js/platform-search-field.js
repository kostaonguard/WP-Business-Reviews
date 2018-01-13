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

	registerSearchButtonEventHandlers() {
		this.searchButtonField.emitter.once( 'wpbrcontrolchange', () => {
			this.search(
				this.platformField.value,
				this.termsField.value,
				this.locationField.value
			);
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

					// Emit custom event that passes the platform search results.
					this.emitter.emit( 'wpbrAfterPopulateResults', 'response.data' );
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

	clearSearch() {

		// this.searchInput.value = '';
	}

	clearResults() {

		// this.results.classList.add( 'wpbr-u-hidden' );
		// this.resetButton.classList.add( 'wpbr-u-hidden' );
		// this.resultsList.innerHTML = '';
	}

	reset() {
		this.clearSearch();
		this.clearResults();
	}
}

export default PlatformSearchField;
