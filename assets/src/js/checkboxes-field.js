import Emitter from 'tiny-emitter';

class CheckboxesField {
	constructor( element ) {
		this.root     = element;
		this.controls = this.root.querySelectorAll( '.js-wpbr-control' );
		this.emitter  = new Emitter();
	}

	init() {
		this.registerEventHandlers();
	}

	registerEventHandlers() {
		this.controls.forEach( ( control ) => {
			control.addEventListener( 'change', event => {

				// Get the control ID from the data attribute.
				const controlId    = event.currentTarget.dataset.wpbrControlId;

				// Get the control value, in this case a checkbox.
				const controlValue = event.currentTarget.checked;

				// Emit custom event that passes the control ID and value that changed.
				this.emitter.emit( 'wpbrfieldchange', controlId, controlValue );
			});
		}, this );
	}

	// Retrieve the value of the field.
	get values() {
		const values = new Object;

		controls.forEach( ( control ) => {
			const controlId = control.dataset.controlId;
			values[controlId] = control.checked;
		}, this );

		return values;
	}
}

export default CheckboxesField;
