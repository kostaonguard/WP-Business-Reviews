import Field from './field';

class BasicField extends Field {
	constructor( element ) {
		super( element );
		this.control  = this.root.querySelector( '.js-wpbr-control' );
	}

	init() {
		if ( this.control ) {
			this.registerControlEventHandlers();
		}
	}

	registerControlEventHandlers() {
		this.control.addEventListener( 'change', event => {
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
			this.root.dispatchEvent( customEvent );
		});
	}

	// Retrieve the value of the field.
	get value() {
		return this.control.value;
	}
}

export default BasicField;
