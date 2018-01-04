import Emitter from 'tiny-emitter';

class Field {
	constructor( element ) {
		this.root     = element;
		this.controls = this.root.querySelectorAll( '.js-wpbr-control' );
		this.emitter  = new Emitter();
		this.registerControlEventHandlers();
	}

	registerControlEventHandlers() {
		this.controls.forEach( ( control ) => {
			control.addEventListener( 'change', event => {

				// Get the control type from the data attribute.
				const controlType  = event.currentTarget.dataset.controlType;

				// Use 'checked' for radios/checkboxes; otherwise use 'value'.
				const valueProperty = undefined !== event.currentTarget.checked ? 'checked' : 'value';
				const controlValue = event.currentTarget[valueProperty];

				// Emit custom event that passes the control type and value that changed.
				this.emitter.emit( 'wpbrcontrolchange', controlType, controlValue );
			});
		}, this );
	}
}

export default Field;
