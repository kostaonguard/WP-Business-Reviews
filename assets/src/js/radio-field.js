import Field from './field.js';

class RadioField extends Field {
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
				const controlValue = event.currentTarget.value;

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
	get value() {
		for ( const control of this.controls ) {
			if ( control.checked ) {
				return control.value;
			}
		}
	}
}

export default RadioField;
