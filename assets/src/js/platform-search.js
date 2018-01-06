import axios from 'axios';
import queryString from 'query-string';

class PlatformSearch {
	constructor( platformField, termsField, locationField, buttonField ) {
		this.platformField = platformField;
		this.termsField    = termsField;
		this.locationField = locationField;
		this.buttonField   = buttonField;
	}

	init() {
		this.registerEventHandlers();
	}

	registerEventHandlers() {
		console.log( 'registering event handler' );
		this.buttonField.emitter.on( 'wpbrcontrolchange', ( controlId, controlValue ) => {
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
			.then( function( response ) {
				console.table( response.data );
			})
			.catch( function( error ) {
				console.log( error );
			});
	}
}

export default PlatformSearch;
