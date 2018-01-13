import Emitter from 'tiny-emitter';

class ReviewFetcher {
	constructor( element ) {
		this.root    = element;
		this.emitter = new Emitter();

		console.log( 'ReviewFetcher constructor ran' );
		console.log( this );
	}

	init() {
		this.controls = this.root.querySelectorAll( '.js-wpbr-review-fetcher-button' );
		this.registerButtonEventHandlers();
	}

	registerButtonEventHandlers() {
		this.controls.forEach( ( control ) => {
			control.addEventListener( 'click', ( event ) => {
				const platform = event.currentTarget.getAttribute( 'data-wpbr-platform' );
				const platformId = event.currentTarget.getAttribute( 'data-wpbr-platform-id' );
				console.log( '==================================================' );
				console.log( 'Requested: ' + platform, platformId );
			});
		});
	}
}

export default ReviewFetcher;
