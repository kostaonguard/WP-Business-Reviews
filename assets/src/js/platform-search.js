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
			this.search();
		});
	}

	search() {
		return axios.post(
			ajaxurl,
			queryString.stringify({
				action: 'wpbr_platform_search',
				platform: this.platformField.value,
				terms: this.termsField.value,
				location: this.locationField.value
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
