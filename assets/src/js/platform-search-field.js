import Field from './field';
import FieldFactory from './field-factory';
import BasicField from './basic-field';
import ButtonField from './button-field';
import ReviewSourceCollection from './review-source-collection';
import axios from 'axios';
import queryString from 'query-string';

class PlatformSearchField extends Field {
	constructor( element ) {
		super( element );
		this.fieldFactory = new FieldFactory();
		this.subfields    = new Map();
	}

	init() {
		this.initSubfields();
		this.registerSearchEventHandlers();
	}

	initSubfields( selector ) {
		const subfieldEls = this.root.querySelectorAll( '.js-wpbr-subfield' );

		for ( const subfieldEl of subfieldEls ) {
			const fieldId   = subfieldEl.dataset.wpbrFieldId;
			const fieldType = subfieldEl.dataset.wpbrFieldType;
			const field     = this.fieldFactory.createField( subfieldEl, fieldType );

			if ( field ) {
				field.init();
				this.subfields.set( fieldId, field );
			}
		}
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
			this.subfields.get( 'platform_search_terms' ),
			this.subfields.get( 'platform_search_location' )
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
					this.subfields.get( 'platform_search_button' ).control.click();
				}
			});
		}

		// Trigger search on click.
		this.subfields.get( 'platform_search_button' ).control.addEventListener(
			'wpbrControlChange',
			() => {
				this.search(
					this.subfields.get( 'platform' ).value,
					this.subfields.get( 'platform_search_terms' ).value,
					this.subfields.get( 'platform_search_location' ).value
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

		this.root.dispatchEvent( getReviewSourcesStartEvent );

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
		this.subfields.get( 'platform_search_terms' ).hide();
		this.subfields.get( 'platform_search_location' ).hide();
		this.subfields.get( 'platform_search_button' ).hide();
	}

	showSearchFields() {
		this.subfields.get( 'platform_search_terms' ).show();
		this.subfields.get( 'platform_search_location' ).show();
		this.subfields.get( 'platform_search_button' ).show();
	}

	reset() {
		this.subfields.get( 'platform_search_terms' ).value = '';
		this.subfields.get( 'platform_search_location' ).value = '';
		this.root.removeChild( this.resetButton );
		this.resetButton = null;
		this.results.destroy();
		this.showSearchFields();
		this.subfields.get( 'platform_search_terms' ).control.focus();
	}
}

export default PlatformSearchField;
