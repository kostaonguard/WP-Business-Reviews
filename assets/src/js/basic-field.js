import Field from './field';
import Emitter from 'tiny-emitter';

class BasicField extends Field {
	constructor( element ) {
		super( element );
		this.control  = this.root.querySelector( '.js-wpbr-control' );
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
			this.emitter.emit( 'wpbrcontrolchange', controlId, controlValue );
		});
	}

	// Retrieve the value of the field.
	get value() {
		return this.control.value;
	}
}

export default BasicField;
