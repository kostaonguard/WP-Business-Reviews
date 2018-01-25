import Field from './field';
import BasicField from './basic-field';
import ButtonField from './button-field';
import ReviewSourceCollection from './review-source-collection';
import axios from 'axios';
import queryString from 'query-string';

class PlatformSearchField extends Field {
	constructor( element ) {
		super( element );
	}

	init() {
		this.initSubfields();
		this.registerSearchEventHandlers();
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

	initResults() {
		this.results = new ReviewSourceCollection( this.root );
		this.results.init();
	}

	initResetButton() {
		this.resetButton = document.createElement( 'button' );
		this.resetButton.className = 'button';

		// TODO: Translate 'Reset Search' text.
		this.resetButton.innerText = 'Reset Search';
		this.root.appendChild( this.resetButton );
		this.registerResetButtonEventHandlers();
	}

	registerSearchEventHandlers() {
		const searchTextFields = [
			this.termsField,
			this.locationField
		];

		// Allow search to be initiated via Enter key.
		for ( const field of searchTextFields ) {
			field.control.addEventListener( 'keydown', event => {
				if ( 13 === event.keyCode ) {
					event.preventDefault();
				}
			});

			field.control.addEventListener( 'keyup', event => {
				if ( 13 === event.keyCode ) {
					event.preventDefault();
					this.searchButtonField.control.click();
				}
			});
		}

		// Trigger search on click.
		this.searchButtonField.control.addEventListener(
			'wpbrControlChange',
			() => {
				this.search(
					this.platformField.value,
					this.termsField.value,
					this.locationField.value
				);
			}
		);
	}

	registerResetButtonEventHandlers() {
		this.resetButton.addEventListener(
			'click',
			() => {
				this.reset();
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
					this.initResults();
					this.updateResults( response.data );
					this.initResetButton();
					this.root.dispatchEvent( getReviewSourcesEndEvent );
				} else {
				}
			})
			.catch( error => {

				// TODO: Handle error of failed platform search request.
			});
	}

	updateResults( results ) {
		this.results.replaceReviewSources( results );
	}

	hideSearchFields() {
		this.termsField.hide();
		this.locationField.hide();
		this.searchButtonField.hide();
	}

	showSearchFields() {
		this.termsField.show();
		this.locationField.show();
		this.searchButtonField.show();
	}

	reset() {
		this.termsField.value    = '';
		this.locationField.value = '';
		this.root.removeChild( this.resetButton );
		this.resetButton = null;
		this.results.destroy();
		this.showSearchFields();
		this.termsField.control.focus();
	}
}

export default PlatformSearchField;
