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

		axios.post(
			ajaxurl,
			queryString.stringify({
				action: 'wpbr_platform_search',
				platform: this.platformField.value,
				terms: this.termsField.value,
				location: this.locationField.value
			})
		)
			.then( function( response ) {
				console.log( response );
			})
			.catch( function( error ) {
				console.log( error );
			});
	}

	registerEventHandlers() {
		this.buttonField.emitter.on( 'wpbrbuttonclick', ( controlId, controlValue ) => {
			console.log( this.termsField.value, this.locationField.value );
		});
	}
}

export default PlatformSearch;
