import Emitter from 'tiny-emitter';

class Field {
	constructor( element ) {
		this.root     = element;
		this.control  = this.root.querySelector( '.js-wpbr-control' );
		this.emitter  = new Emitter();
	}

	init() {
		this.registerEventHandlers();
	}

	registerEventHandlers() {
		this.control.addEventListener( 'change', event => {

			// Get the control ID from the data attribute.
			const controlId    = event.currentTarget.dataset.wpbrControlId;

			// Get the control value.
			const controlValue = event.currentTarget.value;

			// Emit custom event that passes the control ID and value that changed.
			this.emitter.emit( 'wpbrfieldchange', controlId, controlValue );
		});
	}

	// Retrieve the value of the field.
	get value() {
		return this.control.value;
	}
}

export default Field;
