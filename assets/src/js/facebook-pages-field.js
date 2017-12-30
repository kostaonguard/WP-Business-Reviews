import Field from './field';

class FacebookPagesField extends Field {
	constructor( name ) {
		super( name );

		if ( null !== this.root ) {
			this.disconnectButton = this.root.querySelector( '.js-wpbr-facebook-disconnect' );
		}
	}

	init() {
		this.registerEventHandlers();
	}

	disconnect() {
		this.root.parentNode.querySelector( '.js-wpbr-action' ).value = 'wp_business_reviews_disconnect_facebook';
	}


	registerEventHandlers() {
		if ( null !== this.disconnectButton ) {
			this.disconnectButton.addEventListener( 'click', ( event ) => {
				this.disconnect();
			}, this );
		}
	}
}

export default FacebookPagesField;
