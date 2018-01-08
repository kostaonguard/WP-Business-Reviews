import PlatformSearchResults from './platform-search-results';
import axios from 'axios';
import queryString from 'query-string';

class PlatformSearch {
	constructor( platformField, termsField, locationField, buttonField ) {
		this.root = platformField.root.parentNode;
		this.platformField = platformField;
		this.termsField    = termsField;
		this.locationField = locationField;
		this.buttonField   = buttonField;
	}

	init() {
		this.registerButtonEventHandlers();
	}

	registerButtonEventHandlers() {
		this.buttonField.emitter.once( 'wpbrcontrolchange', () => {
			this.search(
				this.platformField.value,
				this.termsField.value,
				this.locationField.value
			);
		});
	}

	search( platform, terms, location ) {
		console.log( terms, location );
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
					console.log( response.data );

					// Hide search input fields.
					this.termsField.root.classList.add( 'wpbr-u-hidden' );
					this.locationField.root.classList.add( 'wpbr-u-hidden' );
					this.buttonField.root.classList.add( 'wpbr-u-hidden' );
					this.results = new PlatformSearchResults( this.root, this.platformField.value );
					this.results.populateResults( response.data );
				} else {

					// No results to populate, so the button needs re-enabled to try again.
					this.registerButtonEventHandlers();
				}
			})
			.catch( error => {
				console.log( error );
			});
	}
}

export default PlatformSearch;
