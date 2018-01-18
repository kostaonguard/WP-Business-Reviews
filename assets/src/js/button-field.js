import Field from './field.js';

class ButtonField extends Field {
	constructor( element ) {
		super( element );
		this.control = this.root.querySelector( '.js-wpbr-control' );
	}

	init() {
		this.registerControlEventHandlers();
	}

	registerControlEventHandlers() {
		this.control.addEventListener( 'click', event => {
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
}

export default ButtonField;
