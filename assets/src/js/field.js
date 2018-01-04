import Emitter from 'tiny-emitter';

class Field {
	constructor( element ) {
		this.root    = element;
		this.control = this.root.querySelector( '.js-wpbr-control' );

		if ( this.control ) {
			this.emitter = new Emitter();
			this.registerEventHandlers();
		}
	}

	registerEventHandlers() {
		this.control.addEventListener( 'change', event => {
			event.preventDefault();
			this.emitter.emit( 'change', this.value );
		});
	}
}

export default Field;
