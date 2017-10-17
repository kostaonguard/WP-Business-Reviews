class Field {
	constructor( name ) {
		this.field = document.getElementById( `wpbr-field-${name}` );
		this.label = document.getElementById( `wpbr-label-${name}` );
		this.tooltip = document.getElementById( `wpbr-tooltip-${name}` );
		this.control = document.getElementById( `wpbr-control-${name}` );
		this.description = document.getElementById( `wpbr-description-${name}` );
	}

	getValue() {
		return this.control.value;
	}

}

export default Field;
