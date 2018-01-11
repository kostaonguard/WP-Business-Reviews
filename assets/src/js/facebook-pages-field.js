import Field from './field';

class FacebookPagesField extends Field {
	constructor( element ) {
		super( element );
		this.disconnectButton = this.root.querySelector( '.js-wpbr-facebook-disconnect' );
	}

	init() {
		this.registerEventHandlers();
	}

	registerEventHandlers() {
		if ( null !== this.disconnectButton ) {
			this.disconnectButton.addEventListener( 'click', ( event ) => {
				this.disconnect();
			}, this );
		}
	}

	disconnect() {
		this.root.parentNode.querySelector( '.js-wpbr-action' ).value = 'wp_business_reviews_disconnect_facebook';
	}
}

export default FacebookPagesField;
