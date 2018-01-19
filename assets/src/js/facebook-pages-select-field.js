import Field from './field';

class FacebookPagesSelectField extends Field {
	constructor( element ) {
		super( element );
	}

	init() {
		const reviewSourcesReadyEvent = new CustomEvent(
			'wpbrReviewSourcesReady',
			{ bubbles: true }
		);
		this.root.dispatchEvent( reviewSourcesReadyEvent );
	}
}

export default FacebookPagesSelectField;
