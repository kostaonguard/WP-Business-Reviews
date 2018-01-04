import Emitter from 'tiny-emitter';

class Field {
	constructor( element ) {
		this.root    = element;
		this.control = this.root.querySelector( '.js-wpbr-control' );
		this.emitter = new Emitter();

		if ( this.control ) {
			this.registerEventHandlers();
		}
	}

	registerEventHandlers() {
		this.control.addEventListener( 'change', event => {
			const controlType  = event.currentTarget.dataset.controlType;
			const controlValue = event.currentTarget.value;

			this.emitter.emit( 'wpbrcontrolchange', controlType, controlValue );
		});
	}
}

export default Field;
