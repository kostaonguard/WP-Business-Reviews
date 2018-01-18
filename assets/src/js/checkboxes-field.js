import Field from './field.js';

class CheckboxesField extends Field {
	constructor( element ) {
		super( element );
		this.controls = this.root.querySelectorAll( '.js-wpbr-control' );
	}

	init() {
		this.registerControlEventHandlers();
	}

	registerControlEventHandlers() {
		for ( const control of this.controls ) {
			control.addEventListener( 'change', event => {
				const controlId    = event.currentTarget.dataset.wpbrControlId;
				const controlValue = event.currentTarget.checked;
				const customEvent  = new CustomEvent( 'wpbrControlChange', {
					bubbles: true,
					detail: {
						controlId: controlId,
						controlValue: controlValue
					}
				});

				// Emit custom event that passes the control ID and value that changed.
				control.dispatchEvent( customEvent );
			});
		}
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
