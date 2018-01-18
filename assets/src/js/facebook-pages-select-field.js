import Field from './field';

class FacebookPagesSelectField extends Field {
	constructor( element ) {
		super( element );
	}

	init() {
		const customEvent = new CustomEvent( 'wpbrReviewSourcesReady', {
			bubbles: true
		});

		console.log( customEvent );

		// Emit custom event that passes the review sources.
		this.root.dispatchEvent( customEvent );
	}
}

export default FacebookPagesSelectField;
