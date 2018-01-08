import Field from './field.js';
import Emitter from 'tiny-emitter';

class ButtonField extends Field {
	constructor( element ) {
		super( element );
		this.control = this.root.querySelector( '.js-wpbr-control' );
	}

	init() {
		this.registerEventHandlers();
	}

	registerEventHandlers() {
		this.control.addEventListener( 'click', event => {

			// Get the control ID from the data attribute.
			const controlId    = event.currentTarget.dataset.wpbrControlId;

			// Get the control value.
			const controlValue = event.currentTarget.value;

			// Emit custom event that passes the control ID and value that changed.
			this.emitter.emit( 'wpbrcontrolchange', controlId, controlValue );
		});
	}
}

export default ButtonField;
